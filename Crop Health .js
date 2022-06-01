//the following code is to be used in google earth engine code editor 
// authentication is mandatory 
//we first define the dates that are to be used 
var Start_period = ee.Date('2020-01-01');
var End_period = ee.Date(new Date().getTime());
//we set the map to app to center at kenya when the application is used  
Map.setCenter(37.75, 0.64, 7);
// we define the map to be a hybrid showing lables and satellite imagery 
Map.setOptions('HYBRID');

// define drawing tools  to select area of interest 
Map.drawingTools().setLinked(false);
Map.drawingTools().setDrawModes(['rectangle', 'polygon', 'line', 'point']);
Map.drawingTools().addLayer([]);
Map.drawingTools().setShape('rectangle', 'polygon', 'point', 'line');

var getAOI = Map.drawingTools().draw();

var getAOI = function() {
    Map.drawingTools().layers().get(0).toFeatureCollection();
};

var AOI = Map.drawingTools().onDraw(function(getAOI) {
    var region = ee.FeatureCollection('FAO/GAUL_SIMPLIFIED_500m/2015/level0')
        .filterMetadata('ADM0_NAME', 'equals', 'Kenya')
        .first()
        .geometry();
    Map.centerObject(getAOI);

    // import the satellite image and filter the image to tghe required specifications 

    var S2 = ee.ImageCollection('COPERNICUS/S2_SR')
        .filterMetadata('CLOUDY_PIXEL_PERCENTAGE', 'less_than', 20)
        .filterDate(Start_period, End_period)
        .filterBounds(region);


    ////////////////////////////YEAR_SELECTION//////////////////////////////////////////
    var collection = S2.map(function(image) {
        return image.select().addBands(image.normalizedDifference(['B8', 'B4'])).rename('NDVI');
    });


    ee.Dictionary({ start: Start_period, end: End_period })
        .evaluate(renderSlider);

    //define the date slider function   
    function renderSlider(dates) {
        var slider = ui.DateSlider({
            start: dates.start.value,
            end: dates.end.value,
            period: 30,
            onChange: renderDateRange
        });
        Map.add(slider);
    }

    // define the function to render date slider 

    function renderDateRange(dateRange) {
        var image = collection
            .filterDate(dateRange.start(), dateRange.end())
            .median();
        var layer = ui.Map.Layer(image.clip(getAOI), { min: -1, max: 1, palette: pal }, 'NDVI');
        Map.layers().reset([layer, ]);
    }
    ///////////////////////////////////////////////////////////////////////////////////////

    //  to ensuare you remain with vegatationj and soil

    function keepFieldPixel(image) {
        var scl = image.select('SCL');
        var veg = scl.eq(4);
        var soil = scl.eq(5);
        var mask = (veg.neq(1)).or(soil.neq(1));
        return image.updateMask(mask);
    }

    //define function to remove clouds

    function maskS2clouds(image) {
        var qa = image.select('QA60');
        var cloudBitMask = 1 << 10;
        var cirrusBitMask = 1 << 11;
        var mask = qa.bitwiseAnd(cloudBitMask).eq(0)
            .and(qa.bitwiseAnd(cirrusBitMask).eq(0));
        return image.updateMask(mask);
    }

    //define NDVI function 

    var addNDVI = function(image) {
        return image.addBands(image.normalizedDifference(['B8', 'B4']));
    };
    S2 = S2.map(addNDVI);
    S2 = S2.map(keepFieldPixel);
    S2 = S2.map(maskS2clouds);
    var NDVI = S2.select(['nd']);
    var NDVImed = NDVI.median();
    //////////////////////////////////////////NDVI_CHART/////////////////////////////////////////////////////////////////////////////////////
    var evoNDVI = ui.Chart.image.seriesByRegion(
        S2,
        getAOI,
        ee.Reducer.mean(),
        'nd',
        10);
    var plotNDVI = evoNDVI
        .setChartType('LineChart')
        .setSeriesNames(['SCL filter only'])
        .setOptions({
            interpolateNulls: true,
            lineWidth: 1,
            pointSize: 3,
            title: 'NDVI annual evolution',
            hAxis: { title: 'Date' },
            vAxis: { title: 'NDVI' }
        });
    // plot the NDVI chart 
    plotNDVI = ui.Chart.image.seriesByRegion(
            S2,
            getAOI,
            ee.Reducer.mean(),
            'nd', 10)
        .setChartType('LineChart')
        .setSeriesNames(['After cloud filter'])
        .setOptions({
            interpolateNulls: true,
            lineWidth: 1,
            pointSize: 3,
            title: 'NDVI annual evolution',
            hAxis: { title: 'Date' },
            vAxis: { title: 'NDVI' },
            series: { 0: { color: 'red' } },
        });
    plotNDVI.style().set({ height: '170px', width: '400px', position: 'bottom-right' });
    Map.add(plotNDVI);
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //var pal = ['#FA8072','red','#DFFF00','#E35335','#B4C424','#4CBB17'];
    var pal = ['red', '#FA8072', '#FF3131', '#CC5500', 'yellow', '#4F7942', 'green'];



    Map.addLayer(NDVImed.clip(getAOI), { min: -1, max: 1, palette: pal }, 'NDVI');
});


// set position of panel
var legend = ui.Panel({
    style: {
        position: 'bottom-left',
        padding: '8px 15px'
    }
});

// Create legend title
var legendTitle = ui.Label({
    value: 'Legend',
    style: {
        fontWeight: 'bold',
        fontSize: '18px',
        margin: '0 0 4px 0',
        padding: '0'
    }
});

// Add the title to the panel
legend.add(legendTitle);

// Creates and styles 1 row of the legend.
var makeRow = function(color, name) {

    // Create the label that is actually the colored box.
    var colorBox = ui.Label({
        style: {
            backgroundColor: '#' + color,
            // Use padding to give the box height and width.
            padding: '8px',
            margin: '0 0 4px 0'
        }
    });

    // Create the label filled with the description text.
    var description = ui.Label({
        value: name,
        style: { margin: '0 0 4px 6px' }
    });

    // return the panel
    return ui.Panel({
        widgets: [colorBox, description],
        layout: ui.Panel.Layout.Flow('horizontal')
    });
};

//  Palette with the colors
var palette = ['008000', 'FFFF00', 'FF0000'];


// name of the legend
var names = ['Healthy Crop', 'Unhealthy Crops', 'Bare Land'];

// Add color and and names
for (var i = 0; i < 3; i++) {
    legend.add(makeRow(palette[i], names[i]));
}

// add legend to map (alternatively you can also print the legend to the console)
Map.add(legend);

// Create the title label.
var title = ui.Label('Crop Health Mapping in Kenya');
title.style().set('position', 'top-center');
Map.add(title);


// Create the title label.
var title = ui.Label('Prepared by Taita Taveta University');
title.style().set('position', 'bottom-right');
// add the title to the map 
Map.add(title);