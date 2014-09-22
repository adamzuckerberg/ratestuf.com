// $(document).ready(function() {
// // $("#rateTableFrame").css('border', '2px solid blue');
// $('.draggable').parent().css('border', '1px solid red');
// });

$("#logo3-container").hover(function(){
    $("#logo3-falling-f").css("position", "absolute" );
    $("#logo3-falling-f").css("z-index", "-9999" );
    $("#logo3-falling-f").css("font-size", "1em" );
    $("#logo3-falling-f").css("margin", "25px 0px 0px 4px" );
    $("#logo3-falling-f").css("-webkit-transform", "rotate(55deg)" );
    $("#logo3-falling-f").css("-moz-transform", "rotate(55deg)" );
    $("#logo3-falling-f").css("-ms-transform", "rotate(55deg)" );
    $("#logo3-falling-f").css("-o-transform", "rotate(55deg)" );
});


function capitaliseFirstLetter(text)
{
    return text.charAt(0).toUpperCase() + text.slice(1);
}

// function saveratings(data) {
//           $.ajax({ 
//               type: "POST",
//               url: "ajax/saveratings.php",
//               data: JSON.stringify(data),
//               contentType: "application/json",

//               success: function(res) {
//                 console.log(res);
//                 if (res.hasOwnProperty('alreadyRated')) {
//                   alert("You've already rated this stuf.");
//                 } else {
//                 alert("Got it! Thanks for adding your ratings to our database. You are awesome!");
//                 location.reload();
//                 }
//                 // Location.reload(true);
//               },
//               error: function(res) {
//                 console.log(res);
//               }
//               ,dataType:'json'});
// }



//user is able to select a draggable ball and delete it from the screen using BACKSPSACE or DELETE
$(".draggable").dblclick(function(){
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

$(".draggable").each(function(){
$(this).addClass('bestValue');
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

                      $("#rateNowButton").hover(function() {
                          $("#loginFacebook").fadeIn(50).css('border', '10px solid #1cff2c');
                          $("#loginFacebook").css('borderRadius','10px');
                          $("#loginFacebook").css('margin-top','22px');
                      });
                      // $("#rateNowButton").click(function() {
                      //     $("#loginFacebook").css('border', 'none');
                      // });
                      $("#rateNowButton").mouseout(function() {
                          $("#loginFacebook").css('border', 'none');
                          $("#loginFacebook").css('margin-top','40px');
                      });

                    });


                      
             // draggable within a box and others
            $(function() {
              // if (userloggedin) {
              $(".draggable").draggable({ containment: "#containmentWrapper" });
            // } 
              });

// ********************************************************************
// INSERT RATINGS INTO DATABASE AND CREATE HTML CANVAS DYNAMICALLY
// ********************************************************************

  var data ={};
  data.items = [];

  canvasBalls = [];
$("#rateNowButton").click(function(){

  if ($(this).hasClass('disabled')) {
    return;
  } 
  if ($('.draggable').length == 0) { 
   alert("Please search for an item first.");
    return;
  }
// prevent multiple clicks due to user ADHD. Part 1 of 2. Re-enabled later on in code
  $(this).addClass('disabled');

  $('.draggable').each(function() {

  itemName = $(this).attr('name');
  itemId = $(this).attr('id');
  containerHeight = ($(this).parent().height() * 0.895 );
  containerWidth = ($(this).parent().width() * 0.9344);
  xAxis = $('#input-value-on-the-x-axis').val().trim();
  yAxis = $('#input-value-on-the-y-axis').val().trim();
  positionFromLeft = ($(this).position().left);
  positionFromTop = ($(this).position().top);
  xRating = (Math.round((positionFromLeft / containerWidth) * 100 )/ 100);
  yRating = (Math.round((1-(positionFromTop / containerHeight))* 100 )/ 100);

  // testing code
  console.log('container height: '+ containerHeight);
  console.log('position from top: '+ positionFromTop);
  console.log('container width: '+ containerWidth);
  console.log('position from left: '+ positionFromLeft);
  console.log('xRating'+ xRating);
  console.log('yRating' + yRating);

  data.items.push({"name": itemName, "itemId": itemId, "xAxis": xAxis, "xRating":xRating, "yAxis":yAxis, "yRating":yRating});

          // ********************************************************
          // Dynamically Create HTHML5 Mirror of Rating Table Section
          // ********************************************************

            actualContainerHeight = $(this).parent().height();
            actualContainerWidth = $(this).parent().width();
            xRatingCanvas = (Math.round((positionFromLeft / actualContainerWidth) * 100 )/ 100);
            yRatingCanvas = (Math.round((1-(positionFromTop / actualContainerHeight))* 100 )/ 100);

          // IMPORTANT - Data source and HTML Canvas measure from top left. Data sent to db is for humans which measure Cartesian from bottom left
            canvasBalls.push({"name": itemName, "itemId": itemId, "xAxis": xAxis, "xRating": xRatingCanvas, "yAxis":yAxis, "yRating": yRatingCanvas});

                    var canvas = $("canvas")[0];
                    canvas.width = 1000;
                    canvas.height = 533;

                    var ctx = canvas.getContext("2d");
                    var centerX = $("canvas").width() / 2;
                    var centerY = $("canvas").height() / 2;
                    var radius = 25;
                    var canvas = $("canvas")[0];

          var x = 70;
          var y = 4;
          var width = canvas.width-x-y;
          var height = canvas.height-63;

          function drawRatingTable() {

            ctx.beginPath();
            ctx.moveTo(x + radius, y);
            ctx.lineTo(x + width - radius, y);
            ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
            ctx.lineTo(x + width, y + height - radius);
            ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
            ctx.lineTo(x + radius, y + height);
            ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
            ctx.lineTo(x, y + radius);
            ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.closePath();
                    ctx.fillStyle = "rgba(207, 190, 110, 0.3)";
                    ctx.fill();
                    ctx.lineWidth = 4;
                    ctx.strokeStyle = '#000';
                    ctx.stroke();
          } drawRatingTable();


          function drawUpDownArrow() {
                    ctx.beginPath();
                    ctx.fillStyle = "#999";
                    ctx.fillRect(25, 50, 20,
                      canvas.height  - 110);
                    ctx.lineWidth = 2;
                    ctx.strokeStyle = '#000';
                    ctx.stroke();

                    ctx.fillStyle = "#999";

                    ctx.moveTo(35, 0);
                    ctx.lineTo(10, 50);
                    ctx.lineTo(60, 50);
                    ctx.fill();
          } drawUpDownArrow();

          function drawLeftRightArrow() {
                    ctx.fillStyle = "#999";
                    ctx.fillRect(
                      70, // x
                      canvas.height - 40, // y
                      canvas.width - 130,
                      20
                    );
                    ctx.fillStyle = "#999";
                    ctx.beginPath();
                    ctx.moveTo(1000, 505); //point
                    ctx.lineTo(940, 480);
                    ctx.lineTo(940, 525);
                    ctx.fill();
          } drawLeftRightArrow();

          function drawInputOnXAxisInputField() {
                    ctx.beginPath();
                    ctx.rect(  380, // x
                      canvas.height - 50, // y
                      300,
                      45
                    );
                    ctx.fillStyle = "white";
                    ctx.fill();
                    ctx.lineWidth = 2;
                    ctx.strokeStyle = 'grey';
                    ctx.stroke();
                    ctx.shadowColor = '#999';
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = 7;
                    ctx.shadowOffsetY = 7;
                    ctx.fill();
          } drawInputOnXAxisInputField();

          function drawInputOnYAxisInputField() {
                    ctx.beginPath();
                    ctx.rect(
                      10, // x
                      210, // y
                      320,
                      50
                    );
                    ctx.fillStyle = "white";
                    ctx.fill();
                    ctx.lineWidth = 2;
                    ctx.strokeStyle = 'grey';
                    ctx.stroke();
                    ctx.shadowColor = '#999';
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = 7;
                    ctx.shadowOffsetY = 7;
                    ctx.fill();
          } drawInputOnYAxisInputField();

          function drawTextIntoXAxisInputField() {
                              // // X legend
                    ctx.fillStyle = "black";
                    ctx.textAlign = 'center';
                    ctx.font = "36px Arial";
                    ctx.fillText(
                      // the xaxis name will be the same for ball 2 if it exists
                      canvasBalls[0].xAxis,
                      canvas.width / 2 + 27,
                      canvas.height - 17
                    );
          } drawTextIntoXAxisInputField();

          function drawTextIntoYAxisInputField() {
                    // // Y legend
                    ctx.fillStyle = "black";
                    ctx.textAlign = 'center';
                    ctx.font = "36px Arial";
                    ctx.fillText(
                      // the yaxis name will be the same for ball 2 if it exists
                      canvasBalls[0].yAxis,
                      152,
                      247
                    );
          } drawTextIntoYAxisInputField();

          function drawFirstBall() {
                    //Draw the first ball
                    ctx.beginPath();
                    ctx.fillStyle = "#00ff00";
                    ctx.arc((canvas.width * (1-(60/1000))) * canvasBalls[0].xRating,
                              (canvas.height * (1-(53/533))) * (1-canvasBalls[0].yRating),
                              radius, 0, 2 * Math.PI, false);
                    ctx.fill();
                    ctx.shadowColor = '#999';
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = 7;
                    ctx.shadowOffsetY = 7;
                    ctx.fill();
                    ctx.closePath();
           } drawFirstBall();
           
           function drawItemNameBelowFirstBall() {
                    ctx.fillStyle = "black";
                    ctx.textAlign = 'center';
                    ctx.font = "normal 800 29px Arial";
                    ctx.fillText(
                      canvasBalls[0].name,
                      (canvas.width * (1-(70/1000))) * canvasBalls[0].xRating + 37,
                      (canvas.height * (1-(63/533))) * (1-canvasBalls[0].yRating) + 63
                    );
                    ctx.closePath();
          } drawItemNameBelowFirstBall();

          function drawSecondBall() {

                    if (!canvasBalls[1]) {
                      return;
                    }
                    //Draw the first ball
                    ctx.beginPath();
                    ctx.fillStyle = "#33ccff";
                    ctx.arc((canvas.width * (1-(60/1000))) * canvasBalls[1].xRating,
                              (canvas.height * (1-(53/533))) * (1-canvasBalls[1].yRating),
                              radius, 0, 2 * Math.PI, false);
                    ctx.fill();
                    ctx.shadowColor = '#999';
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = 7;
                    ctx.shadowOffsetY = 7;
                    ctx.fill();
                    ctx.closePath();
                    ctx.fillStyle = "black";
                    ctx.textAlign = 'center';
                    ctx.font = "normal 800 29px Arial";
                    ctx.fillText(
                      canvasBalls[1].name,
                      (canvas.width * (1-(70/1000))) * canvasBalls[1].xRating + 40,
                      (canvas.height * (1-(63/533))) * (1-canvasBalls[1].yRating) + 70
                    );
                    ctx.closePath();
          } drawSecondBall();

           function drawItemNameBelowSecondBall() {
                    if (!canvasBalls[1]) {
                      return;
                    }
                    ctx.fillStyle = "black";
                    ctx.textAlign = 'center';
                    ctx.font = "normal 800 29px Arial";
                    ctx.fillText(
                      canvasBalls[1].name,
                      (canvas.width * (1-(70/1000))) * canvasBalls[1].xRating + 40,
                      (canvas.height * (1-(63/533))) * (1-canvasBalls[1].yRating) + 70
                    );
                    ctx.closePath();
          } drawItemNameBelowSecondBall();

            var png_image_source = $('#myCanvas')[0].toDataURL( 'image/png' );
            console.log( png_image_source );


          // ********************************************************
          // Dynamically Create HTHML5 Mirror of Rating Table Section
          // ********************************************************
// re-enable to button which was disabled to keep duplicate pushes of data into the array
  $(this).addClass('enabled');
});  //end each draggable ball function

      //Send the data.items array with draggable ball info to the db via the saveratings.php script
       $.ajax({ 

        data: JSON.stringify(data),
        type: "POST",
        url: "ajax/saveratings.php",
        contentType: "application/json",
        success: function(response) {
          if (response.hasOwnProperty('alreadyRated')) {
            alert("You've already rated this stuf.");
          } else {
          // alert("Got it! Thanks for adding your rating. You are awesome! Now share it with your friends!");          
          console.log("Got it! Thanks for adding your rating. You are awesome! Now share it with your friends!");
          }
        },
        dataType:'json'});

      //post the html5 canvas image and push it into your facebook.
        $.ajax({ 
          data: {imgBase64: png_image_source},
          type: "POST",
          url: "ajax/upload_canvas_image.php",
          contentType: "application/json",
          success: function(response) {
          //Open the facebook window
          window.open("https://www.facebook.com/dialog/feed?app_id=228744763916305&display=popup&caption=test&link=http://www.ratestuf.org/&png_image_source",'_parent');
          location.reload();
          },
          error: function(response) {
          }
          ,dataType:'json'});

 });  // end ratenowbutton click event








