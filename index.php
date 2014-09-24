<?php
// ini_set("session.cookie_lifetime",360000);
session_start();
require("inc/config.php");
require("facebook.php");
require("inc/functions.php");
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

$(document).ready(function() {
var client = new ZeroClipboard($('#copy_to_clipboard_button'));
});
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
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <?php if(!$user){ ?>
                <a href="<?php echo $facebook->getLoginUrl(array('scope' => 'user_location,user_likes,email,user_about_me','redirect_uri'=>'http://ratestuf.org/?'.$_SERVER['QUERY_STRING'])); ?>">
                <img id="loginFacebook" src="images/facebook-login.png" alt="Log in with Facebook" title="Log in with facebook to validate your identity"/>
                <p id="fbTagline">Log in to share your ratings...</p>
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
              </div>
            <div class="col-lg-6 col-md-6 hidden-xs hidden-sm"></div>         
            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm"></div>
          </div>   
          <div class="row">
            <div class="col-lg-4 col-md-2 hidden-sm hidden-xs"></div>
            <div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
              <div id="logo3-container" class="logo pull-left" alt="RateStuf logo">
                <p id="logo3">Ratestuf</p>
                <p id="logo3trademark" >&trade;</p>
                <p id="logo3tagline">rate anything and compare stuf<span style="margin-left:1px;margin-top:0px" id="logo3-falling-f">f.</span></p>
              </div>
<!-- <pre>
  <h1>
  <?php
  // print_r($_GET['s']);
  ?>
</h1>
</pre> -->
                <form id="mainForm" method="get" action="./" >
                  <div class="right-inner-addon">

                    <input type="text" id="searchTags" class="items form-control" placeholder="obama vs. batman" name="s" value="">
                        <i id="searchGlyphicon" class="glyphicon glyphicon-search"></i>
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

<!-- Google Adsense Code -->
<div id="responsiveAd1">
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
       style="display:inline-block;width:300px;height:600px"
       data-ad-client="ca-pub-1429880673944819"
       data-ad-slot="5824155682"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
 <!-- Google Adsense Code -->                 

          </div>
            <div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
              <div id="container-for-ratetable-and-arrows">
              <div id="arrow-on-the-y-axis-container">

                    <input list="suggested-list-y-axis" type="text" id="input-value-on-the-y-axis" class="items form-control" placeholder="enter stuf here" name="yaxis" value=""></input>                
                      <datalist id="suggested-list-y-axis">
                        <option value="strength">
                        <option value="electability">
                        <option value="intelligence">
                        <option value="evilness">
                        <option value="sexiness">
                        <option value="beauty">
                        <option value="wealth">
                        <option value="price">
                        <option value="value">
                        <option value="naughtiness">
                      </datalist>

                  <img id="arrow-on-the-y-axis" src="images/arrow_y.png">
              </div>

              <div id="rateTableFrame">

<div id="dialog-message" title="" data-itemId="" data-itemName="" data-xRating="" data-yRating="">
    <span class="dialogBall" style="float:left; margin:0 7px 50px 0;"></span> 
    <span id="dialogItemName"></span>

                <textarea class="dialogTextArea"></textarea> 

</div>

<div id="rateTableScreenCapture">
                <div id="containmentWrapper"></div>

                <img id="rateTable" src="images/rateTableWhite.png">

    
                    <?php
                    $search_term="";
                    if (isset($_GET["s"])) {
                      $search_term = trim($_GET["s"]);
                      // if (!isset($_SESSION['refresh'])) { 
                      // $_SESSION['refresh']=1;
                      //  }  
                      if ($search_term != "") {
                      $position_of_vs_term = position_of_vs_term_in_the_search($search_term);
                        if ($position_of_vs_term !== 0) {
                            $firstSearchTerm = trim(substr($search_term, 0, ($position_of_vs_term) ));
                            $length_of_vs_term = length_of_vs_term_in_the_search($search_term);
                            $secondSearchTerm = trim(substr($search_term, ($position_of_vs_term + $length_of_vs_term),100));
                            $length_of_vs_term = length_of_vs_term_in_the_search($search_term);
                            get_draggable_balls($firstSearchTerm); 
                            get_draggable_balls($secondSearchTerm);   
// this is the actual searchterm just trimmed vs the above which is cleaned and recreated
                          save_search_term_to_separate_table($search_term);
                        //   }
                        } else {
                            get_draggable_balls($search_term);
                            // print_textratings_to_screen($search_term);
                        // if  ($_SESSION['refresh']==1) {    
                            save_search_term_to_separate_table($search_term);
                        //   }
                        } 
                      } 
                    }
                    ?>
<!-- important divs that keep the draggable, stars, dollars in the same parent element for accurate ratings -->
              </div>
<!-- end screen capture -->
</div>

              <div id="box-around-xaxis-input">
                    <input list="suggested-list-x-axis" type="text" id="input-value-on-the-x-axis" class="items form-control" placeholder="enter stuf here" name="xaxis" value="">
                
                      <datalist id="suggested-list-x-axis">
                        <option value="strength">
                        <option value="electability">
                        <option value="intelligence">
                        <option value="evilness">
                        <option value="sexiness">
                        <option value="beauty">
                        <option value="wealth">
                        <option value="price">
                        <option value="value">
                        <option value="naughtiness">
                      </datalist>
            </div>

                <img id="arrow-on-the-x-axis" src="images/arrow_x.png">
<!-- end container for table and arrows -->
              </div>
<div id="box-around-ratenowbutton">
<!--                   <input type="image" src="images/shareonfb.png" id="rateNowButton" class="<?php if (!$user) {echo 'disabled '; } ?>" title="Log in above to share your ratings."></input> -->
                  <img src="images/shareonfb.png" id="rateNowButton" class="<?php if (!$user) {echo 'disabled '; } ?>" title="Log in above to share your ratings.">
</div>
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
  <p id="DynamicRatingsSectionHeadline">

  </p>
<div id="DynamicRatingsSection">          
</div>
<button id="view_the_widget_button"><h3 class='paragraphs' style="color:#fff;">Get The RateStuf&trade; Widget</h3></button> 
  <div id="hidden_widget_sharing_area">
      <h4>Copy and paste this code to add a RateStuf&trade; rating table to your webpage:</h4>
      <textarea id="widget_text_area">
          <iframe src="http://www.ratestuf.org/widget.php" height="310px" width="380px">
      </textarea>
<!--       <button id="copy_to_clipboard_button" data-clipboard-target="widget_text_area" class="go_button" title="Copy Embedded Code to Clipboard">Copy to Clipboard</button> -->
  </div>
<h3 class='paragraphs'> Compare & Share Stuf </h3>
<p class='paragraphs'> RateStuf&trade; is the fastest, easiest way to rate stuff and share your opinions with your friends.</p><p class='paragraphs'>You can <strong> compare anything</strong> versus anything else on any factors that YOU choose. Anything? Yes, anything you want (within socially acceptable norms of course).  Do you think Superman is hotter than Batman - rate them on 'hotness' <strong>vs</strong> 'strength'. Do you think Michelle Pfeiffer is smarter than Bill Clinton - rate them on 'smartness' vs 'acting ability'.  You decide. It's all up to you.  Then, easily share your ratings with friends. Have fun and don't forget to share your ratings on the facebook&trade; and all over the interweb.</p>
<p class='paragraphs'>  - Adam Zuckerberg (Founder), 2014</p>
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
          <div class="trending" id="trending-top10-headline">  Trending Top 10 Searches </div>
<!--                 <ul> -->
                <?php
                // while ($row = mysqli_fetch_assoc($trending)) {
                ?>
<!--                 <li id="trendingStuf"><a href="?s=<?php echo $row['subcategoryName']; ?>"><?php echo 'top 10 '.$row['subcategoryName']; ?></a></li></br> -->
                <?php
                  // echo "<li " . $row['count'] . "</li>";
                  //   }
                ?>
<!--                 </ul>
                <?php 
                  mysqli_free_result($trending);
                ?> -->
          <h3 class="trending" id="trendingVsHeadline"> Trending - Stuf vs Stuf</h3>
                <ul>
                    <li class="trendingVS"><a href="http://ratestuf.org/?s=batman+vs+superman">batman vs. superman<a></li></br>  
                    <li class="trendingVS"><a href="http://ratestuf.org/?s=chuck+norris+vs+vladimir+putin">chuck norris vs. vladimir putin<a></li></br>  
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
          </div>
      </div>

<canvas id="myCanvas"></canvas>

      <footer class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <p id="footer"> Ratestuf.org &copy; <?php echo DATE('Y'); ?> <br> An Adam Zuckerberg Production </br><a href="#"></a>  42 Alan Watts Way, Topanga CA #69 <br/><div id="footerLinks" class="hidden-sm hidden-xs"></p></div>
          </div>
      </footer>
<!-- close container -->
    </div>
<!-- javascript -->
<script src="js/app.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
    </body>
</html>
<?php 
// 5. Close database connection
  mysqli_close($connection);
?>