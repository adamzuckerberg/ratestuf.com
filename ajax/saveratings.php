<?php
session_start();
require (__dir__."/../inc/config.php");
require(__dir__. "/../facebook.php");

header('Content-Type:application/json');
$json=file_get_contents('php://input');
$json=json_decode($json,true);

$facebook = new Facebook(array('appId'=>'228744763916305','secret'=>'013c80431eb1a887ce18660b430d3c7c'));
$user=$facebook->getUser();

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
//otherwise add the first rating for this item to the MYSQL db
	$query = "INSERT INTO `ratings_table` (`userId`, `itemId`, `xAxis`, `xRating`, `yAxis`, `yRating`) "; 
    $query .= "VALUES('$user', '".$ratingObject['itemId']."', '".$ratingObject['xAxis']."', '".$ratingObject['xRating']."', '".$ratingObject['yAxis']."', '".$ratingObject['yRating']."' );";
	mysqli_query($connection,$query);
    // $query = "SELECT ratingId FROM `ratings_table` ORDER BY ratingId DESC LIMIT 1";	
    // $rating = $connection->query($query);
    // array_push($ratings_to_be_joined, $rating)
	}
//and whether or not this item has been already rated or not, create an image for sharing to facebook
		// *************************************************************************************************
		// Create an HMTL5 Canvas Image to Share on Facebook
		// *************************************************************************************************
		// A string representing the filepath 
		// where the image will be stored.
		$upload_dir = "upload/";

		// 'hidden_data' is the dataURL
		$img = $_POST['hidden_data'];

		// remove 'data:image/png:base64' from the dataURL string
		$img = str_replace('data:image/png;base64,', '', $img);

		// do some more string replace it.
		$img = str_replace(' ', '+', $img);

		// get a binary file from the dataURL string
		$data = base64_decode($img);

		// construct a string that will be a filename
		$file = $upload_dir . mktime() . ".png";

		// put the file on the server 
		// $file = filename
		// $data = binary of the .png

		$success = file_put_contents($file, $data);
		// print $success ? $file : 'Unable to save the file.';
		// *************************************************************************************************
		// Create an HMTL5 Canvas Image to Share on Facebook
		// *************************************************************************************************
	}	
	// echo json_encode($result);
}

?>