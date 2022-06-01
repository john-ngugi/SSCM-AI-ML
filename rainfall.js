var Start_period = ee.Date('2016-01-01');
var End_period = ee.Date(new Date().getTime());
//we set the map to app to center at kenya when the application is used  
Map.setCenter(37.75,0.64,7);
// we define the map to be a hybrid showing lables and satellite imagery 
Map.setOptions('HYBRID');

// define drawing tools  to select area of interest 
Map.drawingTools().setLinked(false);
Map.drawingTools().setDrawModes(['rectangle','polygon','line','point']);
Map.drawingTools().addLayer([]);
Map.drawingTools().setShape('rectangle','polygon','point','line');

var getAOI = Map.drawingTools().draw();

var getAOI = function(){
  Map.drawingTools().layers().get(0).toFeatureCollection();
};

var AOI=Map.drawingTools().onDraw(function (getAOI) {
 
Map.centerObject(getAOI);




///////////////////////////////////////////////////////////////////////////////////////

var collection = ee.ImageCollection("UCSB-CHG/CHIRPS/PENTAD")
.filterDate('2021-01-01','2022-05-01');





var averageRainfall= collection.reduce(ee.Reducer.sum());
Map.addLayer(collection.median().clip(getAOI),{	palette:['#ffffcc','#a1dab4','#41b6c4','#2c7fb8','#253494']},"rainfall");
Map.addLayer(averageRainfall.clip(getAOI),{min:0,max:2000,	palette:['red','yellow','green']},"avg_rainfall");

var chart = ui.Chart.image.seriesByRegion({
  imageCollection:collection, 
  regions:getAOI,
  reducer: ee.Reducer.mean(),
  band: 'precipitation',
  scale: 2000,
  xProperty: 'system:time_start',
  seriesProperty: 'SITE'
}).setOptions(chart)
  .setChartType('ColumnChart')
  .setOptions({
    linewidth:3,
    title: 'Total monthly rainfall graph',
    hAxis: {title: 'mMonths of the year'},
    vAxis: {title: 'Precipitation values'},

  });
  chart.style().set({height: '200px', width: '500px', position: 'bottom-right'});
                  


Map.add(chart);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//var pal = ['#FA8072','red','#DFFF00','#E35335','#B4C424','#4CBB17'];
var pal = ['red','#FA8072','#FF3131','#CC5500','yellow','#4F7942','green'];

});



