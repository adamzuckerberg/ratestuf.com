<?php
session_start();
require (__dir__."/../../inc/config.php");
require(__dir__. "/../../facebook.php");
header('Content-Type:application/json');
$json=file_get_contents('php://input');
$json=json_decode($json,true);

$facebook = new Facebook(array('appId'=>'228744763916305','secret'=>'013c80431eb1a887ce18660b430d3c7c'));
$user=$facebook->getUser();


if ($user) {
$result = array(); 
foreach ( $json['items'] as $ratingObject ) {

	$alreadyRated = mysqli_query($connection, "SELECT `ratingId` FROM `ratings_table` WHERE `userId` = '$user' AND `itemId` = '".(int)$ratingObject['itemId']."'");  
// should users be allowed to rate the same item more than once? more than twice? i want to show how a users rating changed over time though? if I allow this, then I can't use average rating since voting twice skews and average.

// WARNING i changed 0 to 10, change back to 0 to limit ratings	
	if (mysqli_num_rows($alreadyRated)>13) {
	$alreadyRatedArray = mysqli_fetch_assoc($alreadyRated);

	$query = "UPDATE `ratings_table` SET `xRating` = '".$ratingObject['xRating']."', `yRating` = '".$ratingObject['yRating']."' , `textRating` = '".(isset($ratingObject['textRating']) ? $ratingObject['textRating'] : "")."' WHERE `ratingId` = '".$alreadyRatedArray['ratingId']."'";
	mysqli_query($connection,$query);
// error_log(mysqli_error($connection));
  if (sizeof($result)==0) {
  		$result['alreadyRated']=true;
  }

	}  else {
//otherwise add the first rating for this item
	$query = "INSERT INTO `ratings_table` (`userId`, `itemId`, `xAxis`, `xRating`, `yAxis`, `yRating`, `textRating`) "; 
    $query .= "VALUES('$user', '".$ratingObject['itemId']."', '".$ratingObject['xAxis']."', '".$ratingObject['xRating']."', '".$ratingObject['yAxis']."', '".$ratingObject['yRating']."','".(isset($ratingObject['textRating']) ? $ratingObject['textRating'] : "")."' );";
	mysqli_query($connection,$query);
// error_log(mysqli_error($connection));	
		}

	}	
	echo json_encode($result);
}

?>