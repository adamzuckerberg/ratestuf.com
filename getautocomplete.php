<?php

// is there a way to get rid of this?
require("inc/config.php");


// $connection = mysqli_connect("localhost", "root", "root", "ratestuf") or die("Error " . mysqli_error($connection));

$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 

 $term=$_GET["term"];
 
 $query = "SELECT items_table.itemName, subcategories_table.subcategoryName FROM `items_table` JOIN item_subcategory_map ON items_table.itemId = item_subcategory_map.itemId JOIN subcategories_table ON subcategories_table.subcategoryId = item_subcategory_map.subcategoryId JOIN ratings_table ON ratings_table.itemId = items_table.itemId WHERE items_table.itemName like '%$term%' OR subcategories_table.subcategoryName like '%$term%'GROUP BY items_table.itemName ORDER BY items_table.itemName ASC" or die("Error in the consult.." . mysqli_error($link));  

 $result = $connection->query($query);

 $json=array();

 while($row = mysqli_fetch_array($result)) { 
         $json[]=array(
                    'value'=> $row["subcategoryName"],
                    'label'=> $row["itemName"]." < ".$row["subcategoryName"]
                        );
}
 
 echo json_encode($json);
 
?>