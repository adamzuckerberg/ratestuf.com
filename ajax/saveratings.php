<?php
session_start();
require (__dir__."/../inc/config.php");
require(__dir__. "/../facebook.php");

header('Content-Type:application/json');
$json=file_get_contents('php://input');
$json=json_decode($json,true);

$facebook = new Facebook(array('appId'=>'228744763916305','secret'=>'013c80431eb1a887ce18660b430d3c7c'));
$user=$facebook->getUser();


$ratings_to_be_joined = [];


if ($user) {
$result = array(); 
foreach ( $json['items'] as $ratingObject ) {

	$alreadyRated = mysqli_query($connection, "SELECT `ratingId` FROM `ratings_table` WHERE `userId` = '$user' AND `itemId` = '".(int)$ratingObject['itemId']."'");  

// WARNING i changed 0 to 10, change back to 0 to limit ratings	
	if (mysqli_num_rows($alreadyRated)>20) {
	$alreadyRatedArray = mysqli_fetch_assoc($alreadyRated);

	$query = "UPDATE `ratings_table` SET `xRating` = '".$ratingObject['xRating']."', `yRating` = '".$ratingObject['yRating']."' WHERE `ratingId` = '".$alreadyRatedArray['ratingId']."'";
	mysqli_query($connection,$query);
// error_log(mysqli_error($connection));
  if (sizeof($result)==0) {
  		$result['alreadyRated']=true;
  }

	}  else {
//otherwise add the first rating for this item

	$query = "INSERT INTO `ratings_table` (`userId`, `itemId`, `searchTerm`, `xAxis`, `xRating`, `yAxis`, `yRating`) "; 
    $query .= "VALUES('$user', '".$ratingObject['itemId']."', '".$ratingObject['searchTerm']."', '".$ratingObject['xAxis']."', '".$ratingObject['xRating']."', '".$ratingObject['yAxis']."', '".$ratingObject['yRating']."' );";
	mysqli_query($connection,$query);

    // $query = "SELECT ratingId FROM `ratings_table` ORDER BY ratingId DESC LIMIT 1";	
		
    // $rating = $connection->query($query);
    // array_push($ratings_to_be_joined, $rating)
		
		}

	}	

	// $query = "INSERT INTO `comparisons` (`ratingIdA`, `ratingIdB`) VALUES ('".$ratings_to_be_joined[1]."', '".$ratings_to_be_joined[2]."');";
	// mysqli_query($connection,$query);

	// echo json_encode($result);
}

?>