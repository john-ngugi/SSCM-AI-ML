<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSCM | Dashboard</title>
    <link rel="icon" href="images/TTU-Logo.png">
    <!--importing our css file -->
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- font awesome v5.15.2 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
</head>

<body>
    <!--Creating a navigation bar with the title-->
    <div class="topnav">
        <div class="topnav-title">
            <a href="#">small scale crop <span>Mapping</span></a>
        </div>
        <br>
        <a class="active" id="home" href="homePage.php">Home</a>
        <a href="https://oduoljeffrey.users.earthengine.app/view/rainfallapp">Rainfall</a>
        <a href="https://muthamijohn.users.earthengine.app/view/crophealth">Crop Health</a>
        <a href="#">Maize Area</a>
        <a href="https://share.streamlit.io/john-ngugi/crop-yield-prediction-model-app/main/model1.py">Yield Prediction</a>
        <a href="#info"><i class="fas fa-user-friends"></i>  Contact</a>
        <a href="about.php"><i class="fas fa-info-circle"></i>  About</a>
        <a href="logout.php" tite="Logout">Logout.</a>
        <div class="hamburger">
            <i class="fas fa-bars"></i>
        </div>
    </div>
    <div class="wrapper">

        <!--Top menu -->
        <div class="sidebar">
            <!--profile image & text-->
            <!--menu item-->
            <div class="profile">
                <img src="images/logo.jpg">
                <h3>TAITA TAVETA UNIVERSITY</h3>
                <p>Small cale Crop Mapping</p>
            </div>
            <div class="menu">
                <ul>
                    <li>
                        <a href="#introduction" class="active">
                            <span class="icon"><i class="fas fa-home"></i></span>
                            <span class="item">Introduction</span>
                        </a>
                    </li>
                    <li>
                        <a href="#Rainfall">
                            <span class="icon"><i class="fas fa-chart-line"></i></span>
                            <span class="item">Rainfall Graphs</span>
                        </a>
                    </li>
                    <li>
                        <a href="#indices">
                            <span class="icon"><i class="fas fa-tasks"></i></span>
                            <span class="item">Parameters</span>
                        </a>
                    </li>
                    <li>
                        <a href="#health">
                            <span class="icon"><i class="fas fa-seedling"></i></span>
                            <span class="item">Crop Description</span>
                        </a>
                    </li>
                    <li>
                        <a href="#slideshow">
                            <span class="icon"><i class="fas fa-sitemap"></i></span>
                            <span class="item">Classfication</span>
                        </a>
                    </li>
                    <li>
                        <a href="about.php">
                            <span class="icon"><i class="fas fa-cog"></i></span>
                            <span class="item">About</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>





    </div>
    <div class="section">
        <br>
        <br>

        <div class="container">
            <!-- Content here -->
        </div>
        <div class="row">
            <div class="main-introduction" id="introduction">
                <center>
                    <img class="ksa" src="images/KSA-TTU.png" alt="">
                    <h3 class="title">TAITA TAVETA UNIVERSITY</h3>
                    <h2>Small Scale Maize Mapping <br> Using Machine Learning</h2>
                </center>
            </div>
            <div class="Kenya-map">
                <center>
                    <h1>LAND COVER LAND USE FOR THE MAP OF KENYA</h1>
                </center>
                <img src="images/kenya.jpg" alt="Kenya Land Cover Land Use Image">
                <div class="Describe">
                    <centre>
                        <h2>KENYA MAP</h2>
                        <p>This data set represents land cover map for the year 2016. This layer was clipped from Sentinel-2 global land cover data. To show the classification of different features in Kenya hence categorizing different geographical features
                            such as Bare Land, Forest and Water bodies, Grasslands, Build up Regions assigning then different colors for visualization
                            <br>
                            <strong>1. Green color</strong>
                            <br> The green color shows areas covered with Trees.
                            <br>
                            <strong>2. Blue color</strong><br> Also the Blue color show regions cover by water bodies. <br>
                            <strong>3.Orange color </strong><br> It shows the grasslands. <br>
                            <strong>4. Red Color</strong><br> The color shows Built up Regions i.e Residential areas in Kenya. <br>
                            <strong>5. White color</strong><br> It shows Bare land areas. <br>
                            <strong>6. yellow color</strong><br> It shows it show the areas covered by crops. <br>
                            <strong>7. Brown color</strong><br> It show the scrubs cover Areas.

                        </p>
                    </centre>
                </div>
            </div>
            <br>
            <div class="col" id="Rainfall">
                <center>
                    <h1>Rainfall Graph to show the trend since year 1982 to 2022</h1>
                </center>
                <img src="images/ee-chart.png" alt="Rainfall graph image">
                <p>
                    <strong>Rainfall</strong><br><br> This page presents Kenya's region of interest climate context for the current climatology, 1982-2022, derived from observed, historical data. <br><br> Information should be used to build a strong understanding
                    of current climate conditions in order to appreciate future climate scenarios and projected change. <br><br> You can visualize data for the current climatology through spatial variation, the seasonal cycle, or as a time series. Analysis
                    is available for both annual and seasonal data.
                </p>
            </div>
            <div class="col" id="indices">
                <P>
                    <center><strong><h1>VEGETATION INDICES</h1></strong><br></center>
                    <strong><h1>1. NDVI</h1></strong>
                    <P>Normalized Difference Vegetation Index (NDVI) quantifies vegetation by measuring the difference between near-infrared (which vegetation strongly reflects) and red light (which vegetation absorbs).</P>
                    <p>Their ratio yields a measure of photosynthetic activity within values between -1 and 1. <br><br> Low NDVI values indicates moisture-stressed vegetation <br> Higher values indicates a higher density of green vegetation . <br> Also used
                        for drought monitoring and famine early warning.</p>
                </P>
                <strong><h1>2. RVI</h1></strong>
                <p>
                    Ratio Vegetation Index (RVI), which is based on the principle that leaves absorb relatively more red than infrared light;<br><br> RVI can be expressed mathematically as <br> RVI=R/NIR <br><br>where NIR is the near infrared band reflectance
                    and R is red band reflectance.
                </p>
                <strong><h1>3. NPCRI</h1></strong><br>
                <p>
                    Normalized Pigment Chlorophyll Ratio Index is an index that is associated with the chlorophyll content and can find applications in precission agriculture. <br> Using the red and blue spectral bands, NPCRI captures the information
                    needed to quantify chlorophyll and Nitrogen.
                </p>
                <strong><h1>4. SARVI</h1></strong><br>
                <p>
                    Soil-adjusted Atmospherically Resistant Vegetation Index (SARVI), is a combination of Soil-Adjusted Vegetation Index(SAVI) and Atmospherically Resistant Vegetation Index(ARVI). <br> SAVI is a vegetation index that attempts to minimize
                    soil brightness influences using a soil-brightness correction factor. <br> ARVI is an enhancement to the NDVI tha is relatively resistant to atmospheric factor such as aerosols. <br> it works by using reflectance measurement in the
                    blue wavelengths to correct atmospheric scattering effects that register in the red reflectance spectrum. <br> ARVI is most usefull in regions with high atmospheric aerosol content
                </p>
                <strong><h1>5. GCI</h1></strong><br>
                <p>
                    Green Chlorophyll Index (GCI), is use to estimate Leaf chlorophyll content in the plants based on Near-infrared and greeb bands. <br> In general, the chlorophyll value directly reflects the vegetation. <br> GCI= NIR/Green-1 <br> Where
                    NIR is Near-infrared band.
                </p>
                <strong><h1>6. NDMI</h1></strong><br>
                <p>
                    Normalized Difference Moisture Index (NDMI), detects moisture level in vegetation using a combination of Near-Infrared (NIR) and Short-Wave infrared(SWIR),spectral bands. <br><br> It is a reliable indicator of water stress in crops.
                    <br><br> Is used to monitor irrigation especially in areas where crops requires more water than nature can supply,help to significantly improve crop growth.
                </p>

            </div>

            <div class="col" id="health">
                <img src="images/cropHealth.png" alt="Crop Health for Trans Nzoia Imagery">
                <p>
                    The classification was done from 20th May 2022 to 24th May 2022.
                    It  show the visualization of the crops which are health, unhealthy crops and bare land areas. <br><br>
                    The Green color show area with Healthy crops ,that is, Crops with NDVI between 0.7-0.9 i.e places with forest / trees. <br><br>
                    The Yellow color shows area with seedlings or unhealthy crops with NDVI ranging from 0.4 - 0.6 Hence showing Regions covered mostly by maize . <br><br>
                    The Red color also shows areas with no crops , that is, Bare land areas. <br>
                </p>
            </div>
            <br><br>
            <!-- Define the slideshow container -->
            <div class="col" id="slideshow">
                <center>
                    <h1>Classification of different <strong>sentinel-2</strong> images using different bands for visualization</h1>
                </center>
                <div class="slide-wrapper">

                    <!-- Define each of the slides
                and write the content -->

                    <div class="slide">
                        <h1 class="slide-number">
                            <img src="images/sentinel/sentinel1.jpg" alt="sentinel image">
                        </h1>
                    </div>
                    <div class="slide">
                        <img src="images/sentinel/sentinel2.png" alt="sentinel image">
                    </div>
                    <div class="slide">
                        <img src="images/sentinel/sentinel3.png" alt="sentinel image">
                    </div>
                    <div class="slide">
                        <img src="images/sentinel/sentinel4.jpg" alt="sentinel image">
                    </div>
                    <div class="slide">
                        <img src="images/sentinel/sentinel6.png" alt="sentinel image">
                    </div>
                    <!--
                    <div class="slide">
                        <img src="images/sentinel/sentinel6.png" alt="sentinel image">
                    </div>
                    -->
                </div>
            </div>

            <footer id="info">
                <center>
                    <h1>Small Scale Crop Mapping</h1>
                    <a href="https://www.facebook.com/Taitatavetauni/"><i class="fab fa-facebook-square" style="font-size: 36px;"></i></a>
                    <a href="https://instagram.com/TaitaTavetaUni"><i class="fab fa-instagram" style="font-size: 36px;"></i></a>
                    <a href="https://twitter.com/TaitaTavetaUni"><i class="fab fa-twitter" style="font-size: 36px;"></i></a>
                    <h1>ADDRESS</h1>
                    Taita Taveta University, Sagala Voi-Mwatate road, Voi.
                    <h1>PHONE</h1>
                    +254 721 113 302/+254 774 222 064
                    <h1>EMAIL</h1>
                    info@ttu.ac.ke
                </center>
            </footer>
        </div>
    </div>
    </div>
    </div>

    <script>
        var hamburger = document.querySelector(".hamburger");
        var menu = document.querySelector(".wrapper");
        hamburger.addEventListener("click", function() {
            menu.classList.toggle("active");
        })
    </script>

</body>

</html>