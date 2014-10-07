<?php


function length_of_vs_term_in_the_search($search_term) {
$terms_that_mean_versus = array (' versus ',' vs ','versus',' vs.','vs.',' vs');

 foreach($terms_that_mean_versus as $term) {
    if (strpos($search_term, $term) !== false) {
        $StringLength = strlen($term);
        break; 
    }  
    else {        
    $StringLength = 0;
    // echo 'not a vs search' . '<br/>';
  }
}
    // echo '<h1>' . $StringLength . '</h1>' ;
    return $StringLength;
  }


function position_of_vs_term_in_the_search($search_term) {

$terms_that_mean_versus = array (' versus ',' vs ','versus',' vs.','vs.',' vs');

 foreach($terms_that_mean_versus as $term) {
    if (strpos($search_term, $term) !== false) {
        $position = strpos($search_term, $term);
        break; 
    }  
    else {        
    $position = 0;
  }
}
    return $position;
  }

function is_a_subcategory($search_term)  {

          global $connection;

          $query = "SELECT subcategories_table.subcategoryName FROM `subcategories_table` WHERE subcategoryName = '$search_term' LIMIT 1";

          $result = $connection->query($query);

          if($connection->errno > 0) {
            return;
          }
          if(mysqli_num_rows($result) > 0) {
              return true;
          } else {
              return false;
          }

          // 1. uber (item) "User Ratings for"
          // 2. uber vs. lyft "User Ratings for"
          // 3. ridesharing services -> "Top 10"
}

function save_search_term_to_separate_table($search_term) {

          global $user;
          global $connection;

        //record all users' search terms whether logged in or out (for data analysis)
        $query = "SELECT * FROM `search_terms` ORDER BY `searchDateTime` DESC LIMIT 1"; 
        $resultA = mysqli_query($connection, $query);
        if (!$resultA) {
          echo "database query error";
          echo $connection->error;
        } else {
        //stop duplicating records. if the search term is the same as the last term entered in db, then don't insert
        while($row = mysqli_fetch_assoc($resultA)) {
          // echo '<h1>'.$row["searchTerm"].'</h1>';
          // var_dump($row);
          // echo "<hr/>";
          $last_search_term = $row["searchTerm"];

          if ($search_term == $row["searchTerm"])  {
            return;
          } else {

        $query = "INSERT INTO `search_terms` (`searchTerm`, `userId`) VALUES ('$search_term', '$user')";      
        $resultB = mysqli_query($connection, $query);       
      }
    }
  }
}



function get_draggable_balls($search_term) {

          global $user;
          // to allow for widget without a fb loggin requirement:
          if (!$user) {
            $user = 9999999;
          }


          global $connection;
          $search_term = mysqli_real_escape_string($connection, strtolower($search_term));

          $query = "SELECT items_table.itemName, items_table.itemId, subcategories_table.subcategoryName FROM `items_table` JOIN item_subcategory_map ON items_table.itemId = item_subcategory_map.itemId JOIN `subcategories_table` ON subcategories_table.subcategoryId = item_subcategory_map.subcategoryId JOIN `ratings_table` ON ratings_table.itemId = items_table.itemId WHERE subcategories_table.subcategoryName = '$search_term' OR items_table.itemName = '$search_term' GROUP BY items_table.itemName LIMIT 10"; 

          $result = $connection->query($query);

      // error_log(mysqli_num_rows($result));
        $counter = 0;

      if(mysqli_num_rows($result) > 0) {

          while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $counter ++;

// left and bottom are adjusted by a factor that is added to the rating going in and out of the database to adjust for the width and height of the arrows in the box area.      
      echo '<div'.' '.'id=\''.$row["itemId"].'\''. 'class='.'\'draggable'.$counter.' '.'draggable'.' '.((!$user)? 'greyedOut' : '').'\''.'name=\''.$row["itemName"].'\''.' '.'title=\'Log in. Then move this ball to rate an item...\''.'style=\'position: absolute;'.' '.'left:'.((0.9344)*($row["xRating"])).'%'.';'.' '.'bottom: '.((0.895)*($row["yRating"])).'%'.'\''.'>'.'<a href=\''.($row["itemUrl"]).'\''.' '.'target=\'_blank\'>'.'<p'.' '.'class=\'itemName\''.'>'.stripslashes($row["itemName"]).'</p></a>'.' '.'<img class="speechBubble" src="images/speechbubble.png"><p class=\'ratings\'>'.$row["votes"].'<br>'?><?php
      if ($row["votes"] == 1) {
        echo 'rating'; 
      } else {
        echo 'ratings';
      } ?>
      <?php echo '</p>'.'</div>';} 
      

      } else {

//ADDED THIS NEW SECTION TO ALLOW PEOPLE TO RATESTUF WITHOUT LOGGING IN 

      if (!$user) {
      echo '<div'.' class='.'\'draggable'.'1'.' '.'draggable\''.' name=\''.$search_term.'\''.' '.'title=\'This is a ball. Move it to rate to rate this item.\''.'style=\'position: absolute;'.' '.'left:50%'.';'.' '.'top:50%'.'\''.'>'.'<p'.' '.'class=itemName'.'>'.stripslashes($search_term).'</p>'.' '.'<img class="speechBubble" src="images/speechbubble.png"><p class=\'ratings\'>'.'0'.'<br>ratings</p>'.'</div>';

}
      // IF THE ITEM DOESN'T EXIST (AND THE USER IS LOGGED IN) ADD THE ITEM TO THE DATABASE
      // if ($user) {

      elseif ($user) {
      $query = "INSERT INTO items_table (itemName, createdBy) VALUES ('$search_term',$user)";
      $result = $connection->query($query);
      // $itemId = $connection->insert_id;
      // error_log($connection->error);
      // RUN ANOTHER SELECT QUERY TO FIND THE ITEM IN THE DATABASE AND DISPLAY TO CAPTURE ITS FIRST RATING
      $query = "SELECT itemName, itemId FROM `items_table` WHERE itemName = '$search_term' limit 1";
      $result = $connection->query($query);
      $item = $result->fetch_assoc();
      $itemId = $item['itemId'];

      // INSERT A ROW INTO THE item_subcategory_map table so that the new item is in the "uncategorized" subcategory (i.e. subcategoryId = 0
      $query = "INSERT INTO item_subcategory_map (itemId, subcategoryId) VALUES ($itemId,0)";
      $result = $connection->query($query);
      
      echo '<div'.' '.'id='.'\''.$itemId.'\''. 'class='.'\'draggable'.'1'.' '.'draggable'.' '.((!$user)? 'greyedOut' : '').'\''.'name=\''.$search_term.'\''.' '.'title=\'This is a ball. Move it to rate to rate this item.\''.'style=\'position: absolute;'.' '.'left:50%'.';'.' '.'top:40%'.'\''.'>'.'<p'.' '.'class=itemName'.'>'.stripslashes($search_term).'</p>'.' '.'<img class="speechBubble" src="images/speechbubble.png"><p class=\'ratings\'>'.'0'.'<br>ratings</p>'.'</div>';

        } else {

          echo '<script> alert("Please log in to rate this new item")</script>';
        }
      }     
    } 



function create_search_input_for_ratetable() {

  global $connection;
  $search_term="obama vs. batman";
  if (isset($_GET["s"])) {
    $search_term = strtolower($_GET["s"]);
  }

  echo "<form id='mainForm' method='get' action='' >";
  echo "<div class='right-inner-addon'>";
  echo "<input type='text' id='searchTags' class='items form-control' placeholder=".'"'.$search_term.'"'." name='s' value=''>";
  echo "<i id='searchGlyphicon' class='glyphicon glyphicon-search'></i>";
  echo "</div>";
  echo "</form>";

}

function meta_function_to_process_the_users_search_and_create_balls() {

                    $search_term="";
                    if (isset($_GET["s"])) {
                      $search_term = trim($_GET["s"]);
                      // if (!isset($_SESSION['refresh'])) { 
                      // $_SESSION['refresh']=1;
                      //  }  
                      if ($search_term != "") {
                      $position_of_vs_term = position_of_vs_term_in_the_search($search_term);
                        if ($position_of_vs_term !== 0) {
                            $firstSearchTerm = trim(substr($search_term, 0, ($position_of_vs_term) ));
                            $length_of_vs_term = length_of_vs_term_in_the_search($search_term);
                            $secondSearchTerm = trim(substr($search_term, ($position_of_vs_term + $length_of_vs_term),100));
                            $length_of_vs_term = length_of_vs_term_in_the_search($search_term);
                            get_draggable_balls($firstSearchTerm); 
                            get_draggable_balls($secondSearchTerm);   
// this is the actual searchterm just trimmed vs the above which is cleaned and recreated
                          save_search_term_to_separate_table($search_term);
                        //   }
                        } else {
                            get_draggable_balls($search_term);
                            // print_textratings_to_screen($search_term);
                        // if  ($_SESSION['refresh']==1) {    
                            save_search_term_to_separate_table($search_term);
                        //   }
                        } 
                      } 
                    }      

}


function create_suggested_list_y_axis() {

  echo "<input list='suggested-list-y-axis' type='text' id='input-value-on-the-y-axis' class='items form-control input-value-on-the-y-axis' placeholder='enter stuf here' name='yaxis' value=''>";
  echo "<datalist id='suggested-list-y-axis'>";
create_dropdown_datalist();

}


function create_dropdown_datalist() {

    echo "<option value='strength'>";
  echo "<option value='electability'>";
  echo "<option value='intelligence'>";
  echo "<option value='evilness'>";
  echo "<option value='sexiness'>";
  echo "<option value='beauty'>";
  echo "<option value='wealth'>";
  echo "<option value='price'>";
  echo "<option value='value'>";
  echo "<option value='naughtiness'>";
  echo "</datalist>";
}

function create_suggested_list_x_axis() {

  echo "<input list='suggested-list-x-axis' type='text' id='input-value-on-the-x-axis' class='items form-control input-value-on-the-x-axis' placeholder='enter stuf here' name='xaxis' value=''>";
  echo "<datalist id='suggested-list-x-axis'>";
create_dropdown_datalist();

}

                                












?>







