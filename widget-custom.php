<?php
// ini_set("session.cookie_lifetime",360000);
session_start();
require("inc/config.php");
require("facebook.php");
require("inc/functions.php");
?>


<!doctype html>
<html lang="en" xmlns:fb="http://ogp.me/ns/fb#">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RateStuf | Share Your Ratings</title>
  <meta name="description" content="Ratestuf&trade; is the easiest way to rate and share stuf.">
  <link href='http://fonts.googleapis.com/css?family=Lilita+One|Passion+One:700,400,900|Chivo:400,900,900italic' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="http://www.ratestuf.org/favicon.ico" />
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <!--   drag and drop on touch screens --> 
  <script src="js/jquery.ui.touch-punch.min.js"></script>
  <script src="js/respond.js"></script>
<script src="js/app.js" type="text/javascript"></script>
<!-- <script src="js/ZeroClipboard.min.js" type="text/javascript"></script>
<script src="js/ZeroClipboard.Core.min.js" type="text/javascript"></script> -->
<script> 
userloggedin =<?php 
  if ($user) {
    echo "true";
  } else {
    echo "false";
  }
?>;
</script>


<!-- facebook og sharing -->
<meta property="fb:app_id" content="228744763916305" />
<!-- i want to add explicitly share so it goes in the news feed how? -->
<!-- "fb:explicitly_shared=true" -->
<meta property="og:type" content="website" />
<meta property="og:title" content="My rating of <?php echo ucwords((isset($_GET['s'])? $_GET['s']:""))?><?php; ?>"/>
<meta property="og:description" content="Rate anything and share your stuf." />
<meta property="og:image" content="https://www.ratestuf.org/screenshots/<?php echo $_GET['i']; ?>">

</head>
  <body>

    <div class="container-fluid">
          <header class="row">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
            <div class="col-lg-7 col-md-7 hidden-sm hidden-xs"></div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"></div>
          </div>
          </header>
          <div class="row">
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm">
              </div>
            <div class="col-lg-6 col-md-6 hidden-xs hidden-sm"></div>         
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
          </div>   
          <div class="row">
            <div class="col-lg-4 col-md-2 hidden-sm hidden-xs"></div>
            <div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
<!--               <div id="logo3-container" class="logo pull-left" alt="RateStuf logo">
                <p id="logo3">Ratestuf</p>
                <p id="logo3trademark" >&trade;</p>
                <p id="logo3tagline">rate anything and compare stuf<span style="margin-left:1px;margin-top:0px" id="logo3-falling-f">f.</span></p>
              </div> -->


            </div>
            <div class="col-lg-3 col-md-2 hidden-sm hidden-xs"></div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-2 hidden-sm hidden-xs"></div>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12">
            </div>  
            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs"></div>
          </div>

      <div class="row">  <!-- start of row containing ratetable and adsense ad-->
            <div class="col-lg-4 col-md-2 hidden-sm hidden-xs trendingBox">        
            </div>
      <div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
          <div id="container-for-ratetable-and-arrows">
              <div id="arrow-on-the-y-axis-container">
                <p id="widget-y-axis-name"><?php echo (isset($_GET['yAxis'])? $_GET['yAxis']:"Change Me Y")?><?php; ?></p>
                 <img id="arrow-on-the-y-axis" src="images/arrow_y.png">
              </div>
              <div id="rateTableFrame">
                <div id="rateTableScreenCapture">
                <div id="containmentWrapper"></div>
                  <?php meta_function_to_process_the_users_search_and_create_balls(); ?>
                  <img id="rateTable" src="images/rateTableWhite.png">
                </div><!-- important divs that keep the draggables in the same parent element -->
              </div> <!-- end screen capture -->
              <div id="box-around-xaxis-input">
                <p id="widget-x-axis-name"><?php echo (isset($_GET['xAxis'])? $_GET['xAxis']:"Change Me X")?><?php; ?></p>
              </div>
              <img id="arrow-on-the-x-axis" src="images/arrow_x.png">
          </div><!-- end container for table and arrows -->
<div id="box-around-ratenowbutton"> 
                 <button id="rateNowButtonForCustomWidget">Rate It!</button>

</div>

                  <h6 id="ratings-powered-by-tagline">Ratings powered by <a href="http://www.ratestuf.org">Ratestuf&trade;<a></h6>
      </div>

              <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12"></div>
    </div>  <!-- end of row containing ratetable         --> 
     </div>
<div class="row">
            <div class="col-lg-12 col-md-12 hidden-sm hidden-xs"></div>
</div>
        <div class="row">
            <div class="col-lg-1 col-md-1 hidden-sm hidden-xs"></div>  
            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12"></div>
            <div class="col-lg-1 col-md-1 hidden-sm hidden-xs"></div>  
        </div>
      <div class="row">
        <div id="blankRow2"></div>
      </div>
      <div class="row">
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"> 

</div>




        <div class="col-lg-5 col-md-5 hidden-xs hidden-sm">


                  </div>
          </div>
      </div>


<!-- close container -->
    </div>
<!-- javascript -->
<script src="js/app.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
    </body>
</html>
