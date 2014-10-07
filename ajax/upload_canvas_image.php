<?php

	define('UPLOAD_DIR', '../screenshots/');
	$img = $_POST['png_image_source'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	
	$fileName = uniqid() . '.png';

	$file = UPLOAD_DIR . $fileName;
	$success = file_put_contents($file, $data);
	// print $success ? $file : 'Unable to save the file.';
	echo JSON_encode(array('imageName'=>$fileName));



?>