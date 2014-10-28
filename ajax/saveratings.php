<?php
session_start();
require (__dir__."/../inc/config.php");
require(__dir__. "/../facebook.php");

header('Content-Type: application/json');
$json=file_get_contents('php://input');
$json=json_decode($json,true);

$facebook = new Facebook(array('appId'=>'300112593522000','secret'=>'4e096c69ce38356a77e5ad505943bce9'));
$user=$facebook->getUser();

if (!$user && $_SESSION['limit_inserts'] >= 5) {
 exit();
}

// WORKAROUND FOR WIDGETS SO THAT THERE IS ALWAYS A USER
// if ($user) {
$result = array();
foreach ( $json['items'] as $ratingObject ) {

	$alreadyRated = mysqli_query($connection, "SELECT `ratingId` FROM `ratings_table` WHERE `userId` = '$user' AND `itemId` = '".(int)$ratingObject['itemId']."'");

	// $heavyUser =  mysqli_query($connection, "SELECT * WHERE `userId` = '$user'");

// WARNING i changed 0 to 20, change back to 0 to limit ratings	
	if (mysqli_num_rows($alreadyRated)>200) {
	$alreadyRatedArray = mysqli_fetch_assoc($alreadyRated);

	$query = "UPDATE `ratings_table` SET `xRating` = '".$ratingObject['xRating']."', `yRating` = '".$ratingObject['yRating']."' WHERE `ratingId` = '".$alreadyRatedArray['ratingId']."'";
	mysqli_query($connection,$query);
error_log(mysqli_error($connection));
		  if (sizeof($result)==0) {
		  		$result['alreadyRated']=true;
		  }
	}  
	else {
//otherwise add the first rating for this item to the MYSQL db
	$query = "INSERT INTO `ratings_table` (`userId`, `itemId`, `xAxis`, `xRating`, `yAxis`, `yRating`, `domain`) "; 
    $query .= "VALUES('$user', '".$ratingObject['itemId']."', '".$ratingObject['xAxis']."', '".$ratingObject['xRating']."', '".$ratingObject['yAxis']."', '".$ratingObject['yRating']."', '".$ratingObject['domain']."' );";
	mysqli_query($connection,$query);
error_log(mysqli_error($connection));
$_SESSION['limit_inserts'] += 1;

		}
	}	

echo json_encode($result);

