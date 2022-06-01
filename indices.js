
Map.setOptions('HYBRID');
Map.drawingTools().setLinked(false);
Map.drawingTools().setDrawModes(['polygon']);
Map.drawingTools().addLayer([]);
Map.drawingTools().setShape('polygon');

var getAOI = Map.drawingTools().draw();

var getAOI = function(){
  Map.drawingTools().layers().get(0).toFeatureCollection();
};

var AOI=Map.drawingTools().onDraw(function (getAOI) {
  var maize = ee.FeatureCollection("users/oduoljeffrey/maize")
  var bareland = ee.FeatureCollection("users/oduoljeffrey/bareland")
  var water = ee.FeatureCollection("users/oduoljeffrey/water")
  var trees = ee.FeatureCollection("users/oduoljeffrey/trees")
  var roi = ee.FeatureCollection("users/oduoljeffrey/transnzoia")
  var region = ee.FeatureCollection("users/oduoljeffrey/Kenya/KenyaLand");
  
    //cloud masking
  function maskS2clouds(image){
      return image.updateMask(image.select('QA60').eq(0));
  }
  Map.addLayer(roi, {}, false);
  
  var s2 = ee.ImageCollection("COPERNICUS/S2")
  var rgbVis = {
    min: 0.0,
    max: 3000,
    bands: ['B4', 'B3', 'B2'],
  };
  
  var filtered = s2
  .filter(ee.Filter.date('2016-06-01', '2016-07-30'))
  .filter(ee.Filter.bounds(roi))
  .map(maskS2clouds);
  
  var composite = filtered.median().clip(roi);
  var outImg = composite.visualize(rgbVis)
  Map.addLayer(composite.clip(getAOI), rgbVis, 'Sentinel 2 image', false);
  
  var gcps = maize.merge(bareland).merge(water).merge(trees)
  
  // Overlay the point on the image to get training data.
  var training = composite.sampleRegions({
    collection: gcps, 
    properties: ['Class'], 
    scale: 10
  });
  
  // Train a classifier.
  var classifier = ee.Classifier.smileCart().train({
    features: training,  
    classProperty: 'Class', 
    inputProperties: composite.bandNames()
  });
  // // Classify the image.
  var classified = composite.classify(classifier);
  Map.addLayer(classified.clip(getAOI), {min: 0, max: 3, palette: ['yellow', 'red', 'blue', 'green']}, 'Classification', false);
  
  var kenyaArea = roi.geometry().area();
  var kenyaAreaSqM = ee.Number(kenyaArea); //.round()
  print('Region of Interest in Sq M', kenyaAreaSqM);
  
  var geometryArea = getAOI.area();
  var geometryAreaSqM = ee.Number(geometryArea);
  print('Area of Geometry in Sq M',geometryAreaSqM );
  
  var maizeRegion = classified.eq(0);
  Map.addLayer(maizeRegion.clip(getAOI), {min:0, max:1, palette: ['white', 'Green']}, 'Maize Area');
  
  var areaImage = maizeRegion.multiply(ee.Image.pixelArea());
  var area = areaImage.reduceRegion({
    reducer: ee.Reducer.sum(),
    geometry: getAOI,
    scale: 10,
    tileScale: 8,
    maxPixels: 1e10
    });
  
  var maizeAreaSqM = ee.Number(area.get('classification')).divide(1e4);
  print('Maize Area in Sq M',maizeAreaSqM);
  
  var mean = filtered.reduce(ee.Reducer.mean()).clip(region);
  
  var vis_param = {min:0, max:2000,bands:['B4_mean', 'B3_mean', 'B2_mean'], gamma: 1.6};
  //Calculate NDVI using NIR and RED bands
  var NIR = mean.select('B8_mean');
  var RED = mean.select('B4_mean');
  var NDVI = NIR.subtract(RED).divide(NIR.add(RED));
  Map.addLayer(NDVI.clip(getAOI),{palette:'white,green'},'NDVI', false);
  
  var maizePixels = maizeRegion.reduceToVectors(
    ee.Reducer.countEvery(),
    getAOI, 
    10
  );
  Map.addLayer(maizePixels,{}, 'Maize Pixels', false);
  ///////////////////////////////////////////////////////////////////////////////////////////
  //Converting the feature collection to a geometry
  var FFF = maizePixels.geometry();
  
  var meanNDVI = NDVI.reduceRegion({
    reducer: ee.Reducer.mean(),
    geometry: FFF,
    scale: 10,
    tileScale: 8,
    maxPixels: 1e10
    });
  
  var MNDVI = ee.Dictionary(meanNDVI).getNumber('B8_mean') 
  print('Mean NDVI', MNDVI)
  
  //SARVI
  var SARVI = mean.expression('((NIR-(Red-1*(Blue-Red)))/(NIR+(Red-1*(Blue-Red))))*(1+0.5)', {
                            'NIR' : mean.select('B8_mean'),
                            'Red' : mean.select('B4_mean'),
                            'Blue' : mean.select('B2_mean')
                        })
                        ;
  var meanSARVI= SARVI.reduceRegion({
    reducer: ee.Reducer.mean(),
    geometry: FFF,
    scale: 10,
    maxPixels: 1e10
  });
  var MSARVI = ee.Dictionary(meanSARVI).getNumber('B8_mean') 
  print('Mean SARVI', MSARVI)
  Map.addLayer(SARVI.clip(maizePixels),{palette:['white','red']},'SARVI', false);
  
  //NPCRI
  var NPCRI = mean.expression(
                        '((RED-blue)/(RED+blue))', {
                          'RED' : mean.select('B4_mean'),
                          'blue' : mean.select('B2_mean')
                        })
                        ;
                        
  var meanNPCRI= NPCRI.reduceRegion({
    reducer: ee.Reducer.mean(),
    geometry: FFF,
    scale: 10,
    maxPixels: 1e10
  });
  
  var MNPCRI = ee.Dictionary(meanNPCRI).getNumber('B4_mean') 
  print('Mean NPCRI', MNPCRI)
  Map.addLayer(NPCRI.clip(maizePixels),{palette:['#e5f5f9','#99d8c9','#2ca25f']},'NPCRI', false);
  
  //EVI_2
  var EVI_2 = mean.expression(
                        '(2.5*(NIR-RED))/(NIR+C2*Blue+1)', {
                          'NIR' : mean.select('B8_mean'),
                          'RED' : mean.select('B4_mean'),
                          'Blue' : mean.select('B2_mean'),
                          'C2' :7.5
                        })
                        ;
                        
  var meanEVI_2= EVI_2.reduceRegion({
    reducer: ee.Reducer.mean(),
    geometry: getAOI,
    scale: 10,
    maxPixels: 1e10
  });
  
  var MEVI_2 = ee.Dictionary(meanEVI_2).getNumber('constant') 
  print('Mean EVI_2', MEVI_2)
  Map.addLayer(EVI_2.clip(maizePixels),{palette:['#fff7bc','#fec44f','#d95f0e'],min:0,max:10},'EVI_2', false);
  
  // RVI
  var RVI = mean.expression(
                        '(NIR/RED)', {
                          'NIR' : mean.select('B8_mean'),
                          'RED' : mean.select('B4_mean')
                        })
                        ;
                        
  var meanRVI= RVI.reduceRegion({
    reducer: ee.Reducer.mean(),
    geometry: getAOI,
    scale: 10,
    maxPixels: 1e10
  });
  
  var MRVI = ee.Dictionary(meanRVI).getNumber('B8_mean') 
  print('Mean RVI', MRVI)
  Map.addLayer(RVI.clip(maizePixels),{palette:['#fff7bc','#fec44f','#d95f0e'],min:0,max:10},'RVI', false);
  
  //GCI
  var GCI = mean.expression(
                        '(NIR/Green-1)', {
                          'NIR' : mean.select('B8_mean'),
                          'Green' : mean.select('B3_mean')
                        })
                        ;
                        
  var meanGCI= GCI.reduceRegion({
    reducer: ee.Reducer.mean(),
    geometry: getAOI,
    scale: 10,
    maxPixels: 1e10
  });
  
  var MGCI = ee.Dictionary(meanGCI).getNumber('B8_mean') 
  print('Mean GCI', MGCI)
  Map.addLayer(GCI.clip(maizePixels),{palette:['#fff7bc','#fec44f','#d95f0e'],min:0,max:10},'GCI', false);

  Map.centerObject(getAOI);
  
  
//////////////////////Adding the indices to the panel/////////////////////
var panel = ui.Panel({style: {width: '100px'}})
    .add(ui.Label('Panel'));

var number = 23;
panel.widgets().set(1, ui.Label(number));

ui.root.add(panel);
//////////////////////////////////////////////
});


