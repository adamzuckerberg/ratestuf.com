// $(document).ready(function() {
// // $("#rateTableFrame").css('border', '2px solid blue');
// $('.draggable').parent().css('border', '1px solid red');
// });

function capitaliseFirstLetter(text)
{
    return text.charAt(0).toUpperCase() + text.slice(1);
}

function saveratings(data) {
          $.ajax({ 
              type: "POST",
              url: "ajax/saveratings.php",
              data: JSON.stringify(data),
              contentType: "application/json",

              success: function(res) {
                console.log(res);
                if (res.hasOwnProperty('alreadyRated')) {
                  alert("You've already rated this stuf.");
                } else {
                alert("Got it! Thanks for adding your ratings to our database. You are awesome!");
                location.reload();
                }
                // Location.reload(true);
              },
              error: function(res) {
                console.log(res);
              }
              ,dataType:'json'});
}



//user is able to select a draggable ball and delete it from the screen using BACKSPSACE or DELETE
$(".draggable").click(function(){
  // if (userloggedin) {
    $(".draggable").not(this).removeClass("active");
    $(this).toggleClass("active");
  // }
});


$(document.body).keyup(function(event){
    if (event.keyCode == 46 || event.keyCode == 8) {
        event.preventDefault();
        $(".active").remove();
    }
});

$( ".draggable" ).parent().css( "background-color", "20px red" );


            $(".draggable").click(function() {
                $(this).find(".itemName").fadeIn(1000);
                return;
            });
            $(".draggable").mouseover(function() {
                $(this).find(".itemName").fadeIn(1000);
                return;
            });
            $(".draggable").mouseout(function() {
                $(this).find(".itemName").fadeOut(4000);
                return;
            });


                       //make green arrow appear
                  $(function() {

                      if (!$("#rateNowButton").hasClass('disabled')) {
    return;
  }  
                      $(".draggable").click(function() {
                          $("#arrowUp").fadeIn(2000);
                      });
                      $(".draggable").hover(function() {
                          $("#arrowUp").fadeIn(2000);
                      });


                      $("#rateNowButton").click(function() {
                          $("#arrowUp").fadeIn(2000);
                      });
                      $("#rateNowButton").click(function() {
                          $("#arrowUp").fadeOut(600);
                      });
                      $("loginFacebook").click(function() {
                          $("#arrowUp").fadeOut(100);
                      });
                      $("#rateNowButton").hover(function() {
                          $("#arrowUp").fadeOut(200);
                      });
                    });

             // draggable within a box and others
            $(function() {
              // if (userloggedin) {
              $(".draggable").draggable({ containment: "#containmentWrapper" });
            // } 
              });

// *****************************************
// INSERT RATINGS INTO DATABASE ONCLICK
// *****************************************
  var data ={};
  data.items = [];

$("#rateNowButton").click(function(){

  if ($(this).hasClass('disabled')) {
    return;
  } 
  
  if ($('.draggable').length == 0) { 
   alert("Please search for an item first.");
    return;
  }

  $('.draggable').each(function() {

  itemName = $(this).attr('name');
  itemId = $(this).attr('id');
  containerHeight = ($(this).parent().height() * 0.895 );
  containerWidth = ($(this).parent().width() * 0.9344);
  // xAxis = "QualityTest";
  // yAxis = "PriceTest";
  xAxis = $('#input-value-on-the-x-axis').val().trim();
  yAxis = $('#input-value-on-the-y-axis').val().trim();
  positionFromLeft = ($(this).position().left);
  positionFromTop = ($(this).position().top);
  xRating = (Math.round((positionFromLeft / containerWidth) * 100 )/ 100);
  yRating = (Math.round((1-(positionFromTop / containerHeight))* 100 )/ 100);

  // testing code
  // alert('container height: '+ containerHeight);
  // alert('position from top: '+ positionFromTop);
  // alert('container width: '+ containerWidth);
  // alert('position from left: '+ positionFromLeft);
  // alert('xRating'+ xRating);
  // alert('yRating' + yRating);

  data.items.push({"name": itemName, "itemId": itemId, "xAxis": xAxis, "xRating":xRating, "yAxis":yAxis, "yRating":yRating, "textRating":""});

});

// *************share on fb
              window.open("https://www.facebook.com/dialog/feed?app_id=228744763916305&display=popup&redirect_uri=https://www.facebook.com",
                '_blank');
// *************share on fb
 
 $.ajax({ 

  type: "POST",
  url: "ajax/saveratings.php",
  data: JSON.stringify(data),
  contentType: "application/json",

  success: function(res) {
    console.log(res);
    if (res.hasOwnProperty('alreadyRated')) {
      alert("You've already rated this stuf.");
    } else {

    alert("Got it! Thanks for adding your rating. You are awesome! Now share it with your friends on the facebook.");
    // alert("Got it! Thanks for adding your ratings to our database. You are awesome!");

    location.reload();
    }
    // Location.reload(true);

  },
  error: function(res) {
    // console.log(res);
  }
  ,dataType:'json'});

});










$(".draggable").each(function(){

  xPosition = (Math.round(($(this).position().left / ($(this).parent().width())) * 100));
  yPosition = (100-(Math.round(($(this).position().top / ($(this).parent().height())) * 100)));
  UpperLineSlope = 0.8965;
  yPositionOnUpperLine = ((UpperLineSlope * xPosition) + 25);
  LowerLineSlope = 0.8977;
  yPositionOnLowerLine = ((LowerLineSlope * xPosition) + 5);
  // alert('xposition: ' + xPosition + ', yposition: ' + yPosition + ' yposition of lowerline: ' + yPositionOnLowerLine + ' yposition of upperline: ' + yPositionOnUpperLine);

  if (yPosition > yPositionOnUpperLine) {
        // $(this).removeClass('bestValue');
        // $(this).removeClass('fairValue');  
        $(this).addClass('bestValue');
  }
  
  if (yPosition <= yPositionOnUpperLine && yPosition >= yPositionOnLowerLine) {
        // $(this).removeClass('worseValue');
        // $(this).removeClass('bestValue');        
        $(this).addClass('bestValue'); 
  } 
  
  if (yPosition < yPositionOnLowerLine) {
        // $(this).removeClass('worseValue');
        // $(this).removeClass('fairValue');  
        $(this).addClass('bestValue'); 
  }
}); 

  

