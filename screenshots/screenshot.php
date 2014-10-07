<?php

$search_term = $_GET['s'];

$image = str_replace(' ','_',$search_term).uniqid().'.png';


echo shell_exec('./phantomjs ratestuf.js http://www.ratestuf.org?s='.urlencode($search_term).' '.$image);

// echo json_encode(array('imageName'=>$image));



?>
