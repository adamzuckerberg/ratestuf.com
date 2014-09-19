<?php

$search_term = $_GET['s'];
$image = str_replace(' ','_',$search_term).uniqid().'.png';

escapeshellcmd('/root/phantomjs-1.9.7-linux-x86_64/bin/phantomjs ratestuf.js http://www.ratestuf.org?s='.urlencode($search_term).' '.$image);

escapeshellcmd('mv '.$image.' /home/ecstati5/public_html/screenshots/'.$image);

echo json_encode(array('imageName'=>$image));



?>