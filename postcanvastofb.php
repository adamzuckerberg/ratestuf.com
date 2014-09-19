<?php

if (isset($GLOBALS)["HTTP_RAW_POST_DATA"]))
{
	$rawImage=$GLOBALS['HTTP_RAW_POST_DATA'];
	$removeHeaders=substr($rawImage, strpos($rawImage, ",")+1);
	$decode=base64_decode($removeHeaders);
	$fopen = fopen( 'ims/myImage.png', 'wb' );
	fwrite( $fopen, $decode);
	fclose( $fopen );
}
?>