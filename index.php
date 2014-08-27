<?php
session_start();
require("inc/config.php");
require("facebook.php");
require("inc/functions.php");
// require(ROOT_PATH . "facebook.php");
// require(ROOT_PATH . "inc/functions.php");
?>

<?php 

$facebook = new Facebook(array('appId'=>'228744763916305','secret'=>'013c80431eb1a887ce18660b430d3c7c'));
  if (isset($_GET['fblogout'])) {
    $facebook->clearAllPersistentData();
  }
  $user=$facebook->getUser();
    if ($user) {
      $user_profile = $facebook->api('/me');
    if(mysqli_query($connection, "SELECT `id` FROM `fblogin` WHERE `fb_id`='$user'")->num_rows==0){
mysqli_query($connection, "INSERT INTO `fblogin` (`fb_id`,`firstname`,`lastname`,`email`,`image`,`gender`) VALUES('$user','".$user_profile["first_name"]."','".$user_profile["last_name"]."','".$user_profile["email"]."','https://graph.facebook.com/$user/picture?type=large','".$user_profile["gender"]."')");

header("Location:http://www.ratestuf.org/?".$_SERVER['QUERY_STRING']);
    }
  }

?>

<!doctype html>
<html lang="en" xmlns:fb="http://ogp.me/ns/fb#">

<head>


  <meta charset="utf-8">
  <meta property="og:image" content="http://ratestuf.org/images/logo.jpg">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RateStuf | Top 10 Brand Map, Reviews - User-Generated Ratings</title>
<!--   <title>Ratestuf | <?php echo $_SERVER['QUERY_STRING'] . " - Reviews of The Top 10 Brands and A vs. B Ratings"; ?></title> -->
  <meta name="description" content="A dynamic user-generated brand map to help you discover the best brands in every category. Real-time user-generated ratings of the top 10 brands in any class: the best hosting services, best airlines, best rental cars, best online ride sharing services...you name it. Add your ratings of price and service quality to help others find the best-value brands or, add a new brand to our database to help others discover new, innovative products and services in any category.">
<!--   <link rel="shortcut icon" href="http://www.ratestuf.org/favicon.ico?v=2" /> -->
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
<meta property="og:site_name" content="RateStuf" />
<meta property="og:image" content="https://ratestuf.org/<?php
if (isset($product["fbimage"])) {
  echo $product["fbimage"]; 
} else {
  echo 'images/logo.jpg';
}

?>"/>
<meta property="og:type" content="website" />
<meta property="og:title" content="Hey everyone, this is what I think about <?php echo (isset($_GET['s'])? $_GET['s']:""); ?>"/>
<meta property="og:description" content="A dynamic user-generated brand map to help you discover the best brands in every category." />

<meta property="og:image" content="https://www.ratestuf.org/<?php  

// <!-- 5 stars -->
if(isset($_GET['x']) && $_GET['x'] >80 && isset($_GET['y']) && $_GET['y']>75){ 
    echo 'images/fbog/FB_OG_5stars_4dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >80 && isset($_GET['y']) && $_GET['y']>50){ 
    echo 'images/fbog/FB_OG_5stars_3dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >80 && isset($_GET['y']) && $_GET['y']>25){ 
    echo 'images/fbog/FB_OG_5stars_2dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >80 && isset($_GET['y']) && $_GET['y']>0){ 
    echo 'images/fbog/FB_OG_5stars_1dollars.png';
}

// <!-- 4 stars -->
elseif(isset($_GET['x']) && $_GET['x'] >60 && isset($_GET['y']) && $_GET['y']>75){ 
    echo 'images/fbog/FB_OG_4stars_4dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >60 && isset($_GET['y']) && $_GET['y']>50){ 
    echo 'images/fbog/FB_OG_4stars_3dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >60 && isset($_GET['y']) && $_GET['y']>25){ 
    echo 'images/fbog/FB_OG_4stars_3dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >60 && isset($_GET['y']) && $_GET['y']>0){ 
    echo 'images/fbog/FB_OG_4stars_3dollars.png';
}

// <!-- 3 stars -->
elseif(isset($_GET['x']) && $_GET['x'] >40 && isset($_GET['y']) && $_GET['y']>75){ 
    echo 'images/fbog/FB_OG_3stars_4dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >40 && isset($_GET['y']) && $_GET['y']>50){ 
    echo 'images/fbog/FB_OG_3stars_3dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >40 && isset($_GET['y']) && $_GET['y']>25){ 
    echo 'images/fbog/FB_OG_3stars_3dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >40 && isset($_GET['y']) && $_GET['y']>0){ 
    echo 'images/fbog/FB_OG_3stars_3dollars.png';
}
// <!-- 2 stars -->
elseif(isset($_GET['x']) && $_GET['x'] >20 && isset($_GET['y']) && $_GET['y']>75){ 
    echo 'images/fbog/FB_OG_2stars_4dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >20 && isset($_GET['y']) && $_GET['y']>50){ 
    echo 'images/fbog/FB_OG_2stars_3dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >20 && isset($_GET['y']) && $_GET['y']>25){ 
    echo 'images/fbog/FB_OG_2stars_3dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >20 && isset($_GET['y']) && $_GET['y']>0){ 
    echo 'images/fbog/FB_OG_2stars_3dollars.png';
}
// <!-- 1 stars -->
elseif(isset($_GET['x']) && $_GET['x'] >0 && isset($_GET['y']) && $_GET['y']>75){ 
    echo 'images/fbog/FB_OG_1stars_4dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >0 && isset($_GET['y']) && $_GET['y']>50){ 
    echo 'images/fbog/FB_OG_1stars_3dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >0 && isset($_GET['y']) && $_GET['y']>25){ 
    echo 'images/fbog/FB_OG_1stars_3dollars.png';
} elseif (isset($_GET['x']) && $_GET['x'] >0 && isset($_GET['y']) && $_GET['y']>0){ 
    echo 'images/fbog/FB_OG_1stars_3dollars.png';
}


?>"/>




</head>
  <body>
    <div class="container-fluid">
          <header class="row">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <img id="logo1" class="logo pull-left" src="images/logo.jpg" alt="RateStuf logo">
            </div>
            <div class="col-lg-7 col-md-7 hidden-sm hidden-xs"></div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <?php if(!$user){ ?>
                <a href="<?php echo $facebook->getLoginUrl(array('scope' => 'user_location,user_likes,email,user_about_me','redirect_uri'=>'http://ratestuf.org/?'.$_SERVER['QUERY_STRING'])); ?>">
                <img id="loginFacebook" src="images/facebook-login.png" alt="Log in with Facebook" title="Log in with facebook to validate your identity"/>
                <p id="fbTagline">Log in to add YOUR ratings...</p>
                </a>
<!--                 <img id="arrowUpFB" src="images/arrowUp.png" class="img-responsive"> -->
              <?php }else{ ?>
                <img id="userImage" src='https://graph.facebook.com/<?php echo $user; ?>/picture?type=large'>
                <span id="welcomeUserImage">Welcome <?php echo $user_profile['first_name'];?>!</span>
                <a href="<?php echo $facebook->getLogoutUrl(array('next'=>'http://ratestuf.org?fblogout')); ?>" id="fbLogOut">Logout</a>
              <?php } ?>
            </div>
          </div>
          </header>
          <div class="row">
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm">
                <?php
                  // $query = "SELECT COUNT(ratingId) as total FROM ratings_table"; 
                  // $ratingsCounter = mysqli_query($connection, $query);
                  // if (!$ratingsCounter) {
                  //   die("Database query ratings counted failed");
                  //   echo "not able to count ratings";
                  // }
                ?>
                <?php
                  // while ($row = mysqli_fetch_assoc($ratingsCounter)) {
                  //     echo "<h2 id='counter' title='but who&apos;s counting? ;)' >" . "OVER " . number_format($row['total']) . " RATINGS!" . "</h2>";
                  //     echo "<div id='byPeopleLikeYou' title='or maybe not like you? ;)' >"."(by users like YOU...)"."</div>";
                  //   // echo $ratingsCounter["count"] . "<br />";
                  //   }
                ?>
                <?php 
                //Step 4. Release returned data
                  // mysqli_free_result($ratingsCounter);
                ?>
              </div>
            <div class="col-lg-6 col-md-6 hidden-xs hidden-sm">
<!-- adsense -->
<div id="heightRestriction">
</div>
<!-- adsense -->
            </div>         
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
          </div>   
          <div class="row">
            <div class="col-lg-4 col-md-2 hidden-sm hidden-xs"></div>
            <div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">


              <img id="logo2" class="logo" src="images/logo.jpg" alt="RateStuf logo">

                <form id="mainForm" method="get" action="./" >
                  <div class="right-inner-addon">

                    <input type="text" id="searchTags" class="items form-control" placeholder="find, add or compare stuf" name="s" value="">
                        <i class="glyphicon glyphicon-search"></i>
                </div>
                </form>

                  <script type="text/javascript">
                      $(document).ready(function() {
                      $("#searchTags").autocomplete({source:'getautocomplete.php', minLength:1});
                  });
                  </script>
            </div>
            <div class="col-lg-3 col-md-2 hidden-sm hidden-xs"></div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-2 hidden-sm hidden-xs"></div>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12">
                <h1 id="headline" title="the best (and the worst)">

                <?php

                if (isset($_GET['s'])) {
                if (is_a_subcategory($_GET['s'])) {
                  echo 'Top 10 '.ucwords(strtolower(stripslashes($_GET['s']))).':';
                } else {
                if (position_of_vs_term_in_the_search($_GET['s']) > 0 ) {  
                echo 'User Ratings for '. substr_replace(ucwords(strtolower(stripslashes($_GET['s']))),'v',position_of_vs_term_in_the_search($_GET['s'])+1,1).':';
                } else {
                echo 'User Ratings for '.ucwords(strtolower(stripslashes($_GET['s']))).':';
                }
                  }
                }  else {
                echo "Welcome to Ratestuf".'&trade;'; 
                }

                ?>

                </h1>
            </div>  
            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs"></div>
          </div>

      <div class="row">
          <div class="col-lg-4 col-md-2 hidden-sm hidden-xs trendingBox">
            <button type="submit" id="show"> Show Filters </button><button type="submit" id="hide"> Hide Filters </button>
            <div id="filters">
                <div id="filter_headline"></div>
                <div id="filter3_headline">Price:</div>
                  <form id="filter3" action="#">
                    <input checked type="checkbox" name="price[]" value="0.25">$<br>
                    <input checked type="checkbox" name="price[]" value="0.50">$$<br>
                    <input checked type="checkbox" name="price[]" value="0.75">$$$<br>
                    <input checked type="checkbox" name="price[]" value="1.00">$$$$<br>
                  </form>
                  <hr>
                <div id="filter4_headline">Quality:</div>
                  <form id="filter4" action="#">
                    <input checked type="checkbox" name="quality[]" value="0.2">&#10025;<br>
                    <input checked type="checkbox" name="quality[]" value="0.4">&#10025;&#10025;<br>
                    <input checked type="checkbox" name="quality[]" value="0.6">&#10025;&#10025;&#10025;<br>
                    <input checked type="checkbox" name="quality[]" value="0.8">&#10025;&#10025;&#10025;&#10025;<br>
                    <input checked type="checkbox" name="quality[]" value="1.0">&#10025;&#10025;&#10025;&#10025;&#10025;<br>
                  </form>
                  <hr>
                  <div id="filter7_headline">Time:</div>
                  <form id="filter7" action="#">
                <input type="radio" name="time[]" value="30">Last 30 days<br>
                <input type="radio" name="time[]" value="180">Last 6 months<br>
                <input type="radio" name="time[]" value="365">Last 1 year<br>
                <input checked type="radio" name="time[]" value="1000000000000">Since beginning of time<br>
                  </form>
                  <hr>
                    <div id="filter8_headline">Ratings:</div>
                  <form id="filter8"  action="#">
                <input type="radio" name="mine[]" value="$GET[userId]">Only mine<br>
                <input checked type="radio" name="mine[]" value="1">All ratings<br>
                  </form>
                  <hr>
<!--                   <div id="filter6_headline">Search Item:</div>
                  <form id="filter6"  action="#">
                  <br>
                <input type="radio" name="value[]" value="Display only my search item">Show only my search item<br>
                <input checked type="radio" name="value[]" value="Display all results">Display all results<br>
                  </form> -->
<!--                  <hr> -->
              </div>

<div id="responsiveAd1">

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Large Skyscraper -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:600px"
     data-ad-client="ca-pub-1429880673944819"
     data-ad-slot="5824155682"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

</div>
                  


          </div>
            <div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
                


              <div id="rateTableFrame">
              <div class="dollarRating">
                  <div id="fourDollars"><span>$$$$</span></div>
                  <div id="threeDollars"><span>$$$</span></div>
                  <div id="twoDollars"><span>$$</span></div>
                  <div id="oneDollar"><span>$</span></div>
              </div>

<div id="dialog-message" title="">
    <span class="dialogBall" style="float:left; margin:0 7px 50px 0;"></span> 
    <span id="dialogItemName"></span>

                <textarea class="dialogTextArea"></textarea> 

<!-- <h2>Share Your Rating on Facebook: </h2> -->
<!-- this is the facebook sharing widget stuff from SpaGroups for the dialog box on RateStuf -->
<!-- src="images/share-on-facebook-nonhover.png"
 -->

<!-- This is what I think about Brand&trade;
What about (A) 2 item vs search (B) multiple items -->
<!-- <a href="#" onclick="fbs_click('https://www.facebook.com/share.php?u=https://ratestuf.org/group.php?id=<?php echo $_GET['id']; ?>')" class="fb-share-button" data-width="1000" data-type="button" id="facebookShareButtonGroup"><img src="https://spagroups.com/images/share-on-facebook-nonhover.png" onmouseover="this.setAttribute('src','https://spagroups.com/images/share-on-facebook-hover.png');" onmouseout="this.setAttribute('src','https://spagroups.com/images/share-on-facebook-nonhover.png');"/></a>  -->

<!-- <div class="fb-share-button" data-href="https://spagroups.com/group.php?id=<?php echo $_GET['id']; ?>" data-width="1000" data-type="button"></div> -->

</div>
                <div id="containmentWrapper"></div>

                <img id="rateTable" src="images/rateTable.png">

                <div class="starRating"> 
                    <span id="star1" class="star fa fa fa-star"></span>
                    <span id="star2" class="star fa fa fa-star"></span>
                    <span id="star3" class="star fa fa fa-star"></span>
                    <span id="star4" class="star fa fa fa-star"></span>
                    <span id="star5" class="star fa fa fa-star"></span>
               </div>

    
                    <?php
                    $search_term="";
                    if (isset($_GET["s"])) {
                      $search_term = trim($_GET["s"]);
                      if ($search_term != "") {
                      $position_of_vs_term = position_of_vs_term_in_the_search($search_term);
                        if ($position_of_vs_term !== 0) {
                            $firstSearchTerm = trim(substr($search_term, 0, ($position_of_vs_term) ));
                            $length_of_vs_term = length_of_vs_term_in_the_search($search_term);
                            $secondSearchTerm = trim(substr($search_term, ($position_of_vs_term + $length_of_vs_term),100));
                            $length_of_vs_term = length_of_vs_term_in_the_search($search_term);
                            get_draggable_balls($firstSearchTerm); 
                            get_draggable_balls($secondSearchTerm);   

                            // print_textratings_to_screen($firstSearchTerm);
                            // print_textratings_to_screen($secondSearchTerm);

                        } else {
                            get_draggable_balls($search_term);

                            // print_textratings_to_screen($search_term);


                            } 
                          } 
                        }
                    ?>
                    <?php
                    // is this running????
                    $item = 'citibank'; 
                      $query = "SELECT COUNT(items_table.itemId) AS votes, items_table.itemId, items_table.itemName "; 
                      $query .= "FROM ratings_table "; 
                      $query .= "JOIN items_table ON ratings_table.itemId=items_table.itemId ";
                      $query .= "WHERE items_table.itemName = '{$item}'";
                      $ratingBubble = mysqli_query($connection, $query);
                      if (!$ratingBubble) {
                        die("Database query rating bubble failed");
                        echo "not able to get rating bubble";
                      }
                    ?>
<!-- important divs that keep the draggable, stars, dollars in the same parent element for accurate ratings -->

              </div>

                  <img id="arrowUp" src="images/arrowUp.png" class="img-responsive">
                  <button id="rateNowButton" class="<?php if (!$user) {echo 'disabled '; } ?>" title="Sign up or log in to add your ratings. You will rate all visible balls, so remove any balls you don't want to rate prior to clicking this button.  To delete a ball, click to select the ball (it will be highlighted in yellow) and press the DELETE key to remove the ball.">Rate Now!</button>
              <div id="WhiteSpaceFill"></div>
              </div>

            <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12">


<div id="adBoxBelowRatenowButton">

</div>





            </div>
         </div>           
     </div>
<div class="row">
            <div class="col-lg-12 col-md-12 hidden-sm hidden-xs">
<hr class="line">
            </div>
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
  <?php
                // // Step 2. Perform database query to get the 5 most TRENDING ratings
                //   $query = "SELECT COUNT(items_table.itemId) AS count,items_table.itemId, items_table.itemName "; 
                //   $query .= "FROM ratings_table JOIN items_table ON ratings_table.itemId=items_table.itemId ";
                //   $query .= "JOIN item_subcategory_map ON items_table.itemId = item_subcategory_map.itemId JOIN subcategories_table ON subcategories_table.subcategoryId = item_subcategory_map.subcategoryId ";
                //   //switch interval from 30 to 7 to 1 etc. when site has more traffic
                //   $query .= "WHERE ratings_table.ratingDateTime >= CURDATE() - INTERVAL 30 DAY ";
                //   $query .= "GROUP BY itemName ";
                //   $query .= "ORDER BY count DESC "; 
                //   $query .= "LIMIT 5;"; 
                //   $trending = mysqli_query($connection, $query);
                // //test is there was a query error
                //   if (!$trending) {
                //     die("Database query trending failed");
                //     echo "not able to get trending data";
                //   }
                ?>
<!--                 <h3 class="trending">  Trending Items: </h3>
                <ul> -->
                <?php
                  // Step 3. Use returned data (if any)
                  // $count = 1;
                  // while ($row = mysqli_fetch_assoc($trending)) {
                ?>
<!--                 <li id="trendingStuf"><a href="<?php echo BASE_URL; ?>?s=<?php echo $row['itemName']; ?>"><?php echo $row['itemName']; ?></a></li></br> -->
                <?php
                    // echo "<li " . $row['count'] . "</li>";
                    // }
                ?>
<!--                 </ul> -->
                <?php 
                //Step 4. Release returned data
                  // mysqli_free_result($trending);
                ?>        

  <p id="DynamicRatingsSectionHeadline">
                <?php

                if (isset($_GET['s'])) {
                if (is_a_subcategory($_GET['s'])) {
                  echo 'Top 10 '.ucwords(strtolower(stripslashes($_GET['s']))).':';
                } else {
                if (position_of_vs_term_in_the_search($_GET['s']) > 0 ) {  
                echo 'User Ratings for '. substr_replace(ucwords(strtolower(stripslashes($_GET['s']))),'v',position_of_vs_term_in_the_search($_GET['s'])+1,1).':';
                } else {
                echo 'User Ratings for '.ucwords(strtolower(stripslashes($_GET['s']))).':';
                }
                  }
                }  else {
                echo ""; 
                }

                ?>

  </p>
<div id="DynamicRatingsSection">


<!-- <div class="textRatingsBallBlock">
<div id="GetTheIdFromTheRating" class="textRatingBall worseValue"></div>
<p class="textRatingItemName">itemName&trade;</p>
</div>
<div class="textRatingsTextBlock">
<img id="userImage2" src='https://graph.facebook.com/503854370/picture?type=large'>
<p class="textRatingsDollars">$$$$</p><br>
<p class="textRatingsStars">&#9734</p>
<p>"Lorem ipsum dolor sit amet, this stuff sucks bumlickidiocious."</p><a href="#"><p>Read more</p></a>
</div> -->


<!-- INSERT QUERY TO ECHO THE TEXTRATING, USER, VALUE BASED ON AVERAGE RATING ETC. -->
                    <?php
                    $search_term="";
                    if (isset($_GET["s"])) {
                      $search_term = trim($_GET["s"]);
                      if ($search_term != "") {
                      $position_of_vs_term = position_of_vs_term_in_the_search($search_term);
                        if ($position_of_vs_term !== 0) {
                            $firstSearchTerm = trim(substr($search_term, 0, ($position_of_vs_term) ));
                            $length_of_vs_term = length_of_vs_term_in_the_search($search_term);
                            $secondSearchTerm = trim(substr($search_term, ($position_of_vs_term + $length_of_vs_term),100));
                            $length_of_vs_term = length_of_vs_term_in_the_search($search_term);
                            print_textratings_to_screen($firstSearchTerm);
                            print_textratings_to_screen($secondSearchTerm);
                        } else {
                            print_textratings_to_screen($search_term);
                            } 
                          } 
                        }
                    ?>
                  


</div>
<h3 class='paragraphs'> Online Reviews </h3>
<p class='paragraphs'> RateStuf&trade; is an <strong>online review website</strong>.  Our users work together to create a dynamic, real-time brand map to help other consumers discover the best-value brands and make better purchase decisions. </p>
<h3 class='paragraphs'> What is a Brand Map? </h3>
<p class='paragraphs'> A brand map displays the competing brands in a given class that are all competing for your business.  </p>
<p class='paragraphs'> Our brand map represents the collective, user-generated <strong>reviews</strong> of any brand which our users care to add to our website.  We collect <strong>user reviews</strong> of our users’ perceived quality and perceived price of each brand.  Based on our proprietary algorithm,  we aggregate the data to display the collective opinion of our users. </p>  
<p class='paragraphs'> Our brand map is dynamic so it changes over time as users rate the changing quality and price of any brand relative to its current competitors.  Since markets are constantly shifting, brands on our map will shift to reflect the changing perceptions of our users. </p>
<h3 class='paragraphs'> Why Can’t I Move the Balls Representing the Brands? </h3>
<p class='paragraphs'> If you can’t move the balls, you’re probably not logged in.  Our site operates like a wiki – once you log in, you can add new items and add your <strong> ratings</strong> to any item in our database by moving the ball representing each brand. Use your mouse or your finger to move the brands on your desktop, your iPhone or Android device – our site is responsive! </p>
<h3 class='paragraphs'> How Do I Add a New Item to a Category? </h3>
<p class='paragraphs'> Once you login to RateStuf&trade;, you can add new items.  Our team researches all these new items and will add them to appropriate categories, if applicable and when we see that there is sufficient interest in the item (i.e. many people have added a rating to the same item). </p>
<h3 class='paragraphs'> How Does RateStuf&trade;  Help Drive Traffic to Innovative, New Companies? </h3>
<p class='paragraphs'> Let’s say there is a video rental company that charges high late fees and you have to remember to return the video to the store – let’s call it Blickluster&trade; . </p> 
<p class='paragraphs'> If they’re the only business in the market, the <strong>user reviews</strong> would represent it as a fair value on our map until a competitor emerges. </p>
<p class='paragraphs'> Let’s say a new company emerges that streams videos for a monthly fee, let’s call it NetFlux&trade;.   This new company would appear instantly on the RateStuf&trade;  website and Blucklister&trade;  would quickly start to move towards a worse value position of high price/low quality in this new market while NetFlux&trade;  would appear as the better value, displaying as a green ball in the right-hand corner of the map as a high-value, low-price brand relative to its competitors. </p>
<p class='paragraphs'> Every brand on RateStuf&trade;  is rated relative to others in its class, so as new, innovative companies emerge, our users add new brands to the site and our team researches the companies and add them to relevant categories. </p>
<h3 class='paragraphs'> A Burrito Story by Adam Zuckerberg</h3>
<p class='paragraphs'> I grew up in the Hollywood Hills and there was a new burrito place, let’s call it Poquito Menos .  The burritos were great and so was the price! </p>  
<p class='paragraphs'> But every year, I would visit Poquito Menos and the prices would go up while the burritos got smaller and smaller.  In other words, it was just OK and was becoming a worse and worse value over time.  I think they call this ‘value engineering’. I figured that as the company grew, they hired some MBA who advised them to squeeze every dollar out of the company and increase the owner’s profits by making tiny little cuts to the quality and amount of ingredients.  None of these incremental changes were noticeable by themselves, but in aggregate, over time, the burritos started to just be OK, where once they were awesome – ‘death by a thousand cuts.’  </p>
 <p class='paragraphs'> I hate this phenomenon of companies decreasing value of a product over time while riding their brand and I wanted to make a tool for consumers to rate the price and quality of products to help people discover new, innovative brands that are offering a better quality service at the same price and by keeping the legacy companies offering a great value by providing a user-generated feedback loop for companies to easily measure <strong> brand perception in the market.</strong> </p>
<p class='paragraphs'> The founder of TripAdvisor&trade;  noticed a similar phenomenon in the travel world and it’s why he started his travel review website: </p>
<blockquote>But the hotel owner that wants to run this crappy place, preying off the brand that they’re under, and maybe their location as being near to something, that person has to kind of shape up, maybe take something out of their profits and put it back into providing a good service for customers, because word is spreading and TripAdvisor™ is the conduit in the travel space for spreading that word (Kaufer, source: Founders at Work: Stories of Startups’ Early Days)</blockquote>
<p class='paragraphs'> With Ratestuf&trade;  around, I would hope Poquito Menos would see that users rated its quality lower while its price got higher each year on our brand map, thus moving it to the red ‘worse value’ zone from its original position as a best-in-class brand while other restaurants emerged that were offering a better value. </p>
<p class='paragraphs'> RateStuf&trade;  is around to help consumers discover the best brands in each class and save us the money and trouble of dealing with any brands except those that are offering a truly great value.  I personally hate spending any money on a business in order to discover that it is offering a poor value. Why? In the information age, let’s just let each other know about the best products and services and choose more wisely.  The best companies will listen to our opinions and offer great values – they call this being market-centric – and the others should fade away to be replaced by great new innovative businesses that truly offer great value to us all. </p>
<p class='paragraphs'>  - Adam Zuckerberg, 2014</p>




        </div>


        <div class="col-lg-5 col-md-5 hidden-xs hidden-sm">

<!-- ///Trending Categories -->
          <?php
          // Step 2. Perform database query to get the 5 most TRENDING ratings
            $query = "SELECT COUNT(items_table.itemId) AS count,items_table.itemId, items_table.itemName, subcategories_table.subcategoryName "; 
            $query .= "FROM ratings_table JOIN items_table ON ratings_table.itemId=items_table.itemId ";
            $query .= "JOIN item_subcategory_map ON items_table.itemId = item_subcategory_map.itemId JOIN subcategories_table ON subcategories_table.subcategoryId = item_subcategory_map.subcategoryId ";
            //switch interval from 30 to 7 to 1 etc. when site has more traffic
            $query .= "WHERE ratings_table.ratingDateTime >= CURDATE() - INTERVAL 30 DAY ";
            // excludes uncategorized items newly added and not yet verified
            $query .= "AND subcategories_table.subcategoryId <> 0 ";
            $query .= "GROUP BY subcategoryName ";
            $query .= "ORDER BY count DESC "; 
            $query .= "LIMIT 15;"; 
            $trending = mysqli_query($connection, $query);
          //test is there was a query error
            if (!$trending) {
              die("Database query trending failed");
              echo "not able to get trending data";
            }
          ?>
          <div class="trending">  Trending Top 10 Searches </div>
                <ul>
                <?php
                while ($row = mysqli_fetch_assoc($trending)) {
                ?>
                <li id="trendingStuf"><a href="?s=<?php echo $row['subcategoryName']; ?>"><?php echo 'top 10 '.$row['subcategoryName']; ?></a></li></br>
                <?php
                  echo "<li " . $row['count'] . "</li>";
                    }
                ?>
                </ul>
                <?php 
                  mysqli_free_result($trending);
                ?>
          <h3 class="trending" id="trendingVsHeadline"> Trending a vs. b Searches </h3>
                <ul>
                    <li class="trendingVS"><a href="http://ratestuf.org/?s=uber+vs.+lyft">uber vs. lyft<a></li></br>
                    <li class="trendingVS"><a href="http://ratestuf.org/?s=geico+vs.+progressive">geico vs. progressive<a></li></br>
                    <li class="trendingVS"><a href="http://ratestuf.org/?s=discover+home+loans+vs.+quicken+loans">discover home loans vs. quicken loans<a></li></br>
                    <li class="trendingVS"><a href="http://ratestuf.org/?s=geico+vs.+state+farm">geico vs. state farm<a></li></br>
                    <li class="trendingVS"><a href="http://ratestuf.org/?s=southwest+vs.+delta">southwest vs. delta<a></li></br>
                    <li class="trendingVS"><a href="http://ratestuf.org/?s=betty+ford+vs+hazelden">betty ford vs. hazelden<a></li></br>          
                </ul>

                  <?php
                    $query = "SELECT COUNT(items_table.itemId) AS count,items_table.itemId, items_table.itemName "; 
                    $query .= "FROM ratings_table JOIN items_table ON ratings_table.itemId=items_table.itemId "; 
                    $query .= "GROUP BY itemName ";
                    $query .= "ORDER BY count DESC ";
                    $query .= "LIMIT 12;"; 
                    $popular = mysqli_query($connection, $query);
                  //test is there was a query error
                    if (!$popular) {
                      die("Database query select count failed");
                      echo "not able to get popular";
                    }
                  ?>
                  <h3 class="popular">  Popular Stuf: </h3>
                  <?php
                  $itemNames = array();
                  $maximum = 0;
                    while ($row = mysqli_fetch_array($popular)) {
                      $itemName = $row['itemName'];
                      $count = $row['count'];

                  // update $maximum if this term is more popular than the previous terms
                      if ($count > $maximum) $maximum = $count;
                   
                      $itemNames[] = array('itemName' => $itemName, 'count' => $count);
                      }
                  // shuffle terms unless you want to retain the order of highest to lowest
                  shuffle($itemNames);
                  ?>
                  <div id="tagcloud">
                        <?php 
                        // start looping through the tags
                        foreach ($itemNames as $itemName):
                         // determine the popularity of this term as a percentage
                         $percent = floor(($itemName['count'] / $maximum) * 100);
                         // echo $percent.'%';
                         // determine the class for this term based on the percentage
                         if ($percent < 20): 
                           $class = 'smallest'; 
                         elseif ($percent >= 20 and $percent < 40):
                           $class = 'small'; 
                         elseif ($percent >= 40 and $percent < 60):
                           $class = 'medium';
                         elseif ($percent >= 60 and $percent < 90):
                           $class = 'large';
                         else:
                         $class = 'largest';
                         endif;
                        ?>
                        <span class="<?php echo $class; ?>">
                          <a href="?s=<?php echo urlencode($itemName['itemName']); ?>"><?php echo $itemName['itemName']; ?></a>
                        </span>
                        <?php endforeach; ?>
                  </div>

<!-- adsense -->
<br>
<br>
<br>
<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!-- Large Rectangle -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1429880673944819"
     data-ad-slot="3848115687"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br>
<br>
<br>
<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!-- Responsive1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1429880673944819"
     data-ad-slot="6801582082"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<!-- adsense -->
<br>
<br>
<br>
<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!-- Large Rectangle -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1429880673944819"
     data-ad-slot="3848115687"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br>
<br>
<br>
<!-- adsense -->

<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!-- Responsive1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1429880673944819"
     data-ad-slot="6801582082"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<!-- adsense -->                  
<br>
<br>
<br>
<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!-- Large Rectangle -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1429880673944819"
     data-ad-slot="3848115687"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<!-- adsense -->
<br>
<br>
<br>
<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!-- Responsive1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1429880673944819"
     data-ad-slot="6801582082"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<!-- adsense -->    
<br>
<br>
<br>
<!-- adsense -->

<!-- <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
<!-- Responsive1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1429880673944819"
     data-ad-slot="6801582082"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<!-- adsense -->    


          </div>
      </div>
      <footer class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <p id="footer"> Ratestuf.org &copy; <?php echo DATE('Y'); ?> <br> An Adam Zuckerberg Production </br><a href="#"></a>  42 Alan Watts Way, Topanga CA #69 <br/><div id="footerLinks" class="hidden-sm hidden-xs"> <a href="http://areas.kenan-flagler.unc.edu/Marketing/FacultyStaff/zeithaml/Selected%20Publications/Consumer%20Perceptions%20of%20Price,%20Quality,%20and%20Value-%20A%20Means-End%20Model%20and%20Snthesis%20of%20Evidence.pdf">Scholary Stuf on Perceived Value and Price</a>  | <a href="http://www.comm.ucsb.edu/faculty/flanagin/CV/FlanaginandMetzger2013(CiHB).pdf">Scholary Stuf on User-Generated Ratings</a> | <a href="http://www.demandforce.com/_assets/downloads/pdf/resources/heres-looking-out-for-you-kid-the-unselfish-reasons-why-people-write-online-reviews.pdf">The Unselfish Reasons Why People Write Online Reviews</a></p><div>
          </div>
      </footer>
<!-- close container -->
    </div>

<!-- adsense -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- adsense -->

<!-- javascript -->
<script src="js/app.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
    </body>
</html>
<?php 
// 5. Close database connection
  mysqli_close($connection);
?>