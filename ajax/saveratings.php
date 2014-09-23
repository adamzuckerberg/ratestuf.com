<?php
session_start();
require (__dir__."/../inc/config.php");
require(__dir__. "/../facebook.php");

header('Content-Type:application/json');
$json=file_get_contents('php://input');
$json=json_decode($json,true);

print_r($json);

$facebook = new Facebook(array('appId'=>'228744763916305','secret'=>'013c80431eb1a887ce18660b430d3c7c'));
$user=$facebook->getUser();

if ($user) {
$result = array();
foreach ( $json['items'] as $ratingObject ) {

	$alreadyRated = mysqli_query($connection, "SELECT `ratingId` FROM `ratings_table` WHERE `userId` = '$user' AND `itemId` = '".(int)$ratingObject['itemId']."'");

	// $heavyUser =  mysqli_query($connection, "SELECT * WHERE `userId` = '$user'");

// WARNING i changed 0 to 20, change back to 0 to limit ratings	
	if (mysqli_num_rows($alreadyRated)>20) {
	$alreadyRatedArray = mysqli_fetch_assoc($alreadyRated);

	$query = "UPDATE `ratings_table` SET `xRating` = '".$ratingObject['xRating']."', `yRating` = '".$ratingObject['yRating']."' WHERE `ratingId` = '".$alreadyRatedArray['ratingId']."'";
	mysqli_query($connection,$query);
error_log(mysqli_error($connection));
		  if (sizeof($result)==0) {
		  		$result['alreadyRated']=true;
		  }
	// 	}  elseif {
	// //limit the ability of any user to rate more than X number of times to prevent robots from filling db
	// 	if ((mysqli_num_rows($heavyUser)>100) && (!$user == 503854370)) {

	// //message...you are a heavy user
	// 	$message = "Please contact an administrator to continue rating items on RateStuf";
	// 	echo "<script type='text/javascript'>alert('$message');</script>";

	}  
	else {
//otherwise add the first rating for this item to the MYSQL db
	$query = "INSERT INTO `ratings_table` (`userId`, `itemId`, `xAxis`, `xRating`, `yAxis`, `yRating`) "; 
    $query .= "VALUES('$user', '".$ratingObject['itemId']."', '".$ratingObject['xAxis']."', '".$ratingObject['xRating']."', '".$ratingObject['yAxis']."', '".$ratingObject['yRating']."' );";
	mysqli_query($connection,$query);
error_log(mysqli_error($connection));
		}
	}	

}

