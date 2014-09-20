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
  // alert('container height: '+ containerHeight);
  // alert('position from top: '+ positionFromTop);
  // alert('container width: '+ containerWidth);
  // alert('position from left: '+ positionFromLeft);
  // alert('xRating'+ xRating);
  // alert('yRating' + yRating);

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

          // Draw Background
          ctx.beginPath();
          ctx.rect(70, 4, canvas.width-70-4, canvas.height-63);
          // ctx.fillStyle = "#CFBE6E";
          ctx.fillStyle = "rgba(207, 190, 110, 0.3)";
          ctx.fill();
          ctx.lineWidth = 4;
          ctx.strokeStyle = '#000';
          ctx.stroke();

          // // Arrow up/down
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


          // // Arrow left/right
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


          // // Input x-axis
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

          // // Input y-axis
          ctx.beginPath();
          ctx.rect(
            0, // x
            220, // y
            300,
            45
          );
          ctx.fillStyle = "white";
          ctx.fill();
          ctx.lineWidth = 2;
          ctx.strokeStyle = 'grey';
          ctx.stroke();

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


          // // Y legend
          ctx.fillStyle = "black";
          ctx.textAlign = 'center';
          ctx.font = "36px Arial";
          ctx.fillText(
            // the yaxis name will be the same for ball 2 if it exists
            canvasBalls[0].yAxis,
            152,
            254
          );

          //Draw the first ball
          ctx.beginPath();
          ctx.fillStyle = "green";
          ctx.arc((canvas.width * (1-(60/1000))) * canvasBalls[0].xRating,
                    (canvas.height * (1-(53/533))) * (1-canvasBalls[0].yRating),
                    radius, 0, 2 * Math.PI, false);
          ctx.fill();
          ctx.lineWidth = 4;
          ctx.strokeStyle = '#003300';
          ctx.stroke();
          ctx.fill();

          ctx.fillStyle = "black";
          ctx.textAlign = 'center';
          ctx.font = "normal 800 32px Arial";
          ctx.fillText(
            canvasBalls[0].name,
            (canvas.width * (1-(70/1000))) * canvasBalls[0].xRating + 20,
            (canvas.height * (1-(63/533))) * (1-canvasBalls[0].yRating) + 55
          );

  var png_image_source = $('#myCanvas')[0].toDataURL( 'image/png' );
  console.log( png_image_source );

  $.post( "ajax/upload_canvas_image.php", {
            image_source: png_image_source 
          }).done(function( data ) {
            alert( "Response from server " + data );
          });


// ********************************************************
// Dynamically Create HTHML5 Mirror of Rating Table Section
// ********************************************************
// re-enable to button which was disabled to keep duplicate pushes of data into the array
  $(this).addClass('enabled');
});

       $.ajax({ 

        data: JSON.stringify(data),
        type: "POST",
        url: "ajax/saveratings.php",
        contentType: "application/json",

        success: function(res) {
          console.log(res);
          if (res.hasOwnProperty('alreadyRated')) {
            alert("You've already rated this stuf.");
          } else {

                $.ajax({ 

              type: "GET",
              url: "ajax/upload_canvas_image.php",
              // url: "screenshot.php?s="+encodeURI($("#searchTags").val()),
              contentType: "application/json",

              success: function(res) {
                // console.log(res);

              window.open("https://www.facebook.com/dialog/feed?app_id=228744763916305&display=popup&caption=test&link=http://www.ratestuf.org/&",'_parent');

// ratestuf.org?i="+res.imageName+"&redirect_uri=https://www.facebook.com",ratestuf.org&redirect_uri=https://www.facebook.com",'_parent');
              },
              error: function(res) {
                // console.log(res);
              }
              ,dataType:'json'});


          alert("Got it! Thanks for adding your rating. You are awesome! Now share it with your friends on the facebook.");
          // alert("Got it! Thanks for adding your ratings to our database. You are awesome!");

      // HERE IS THE RELOAD
          location.reload();
          }
          // Location.reload(true);

        },
        error: function(res) {
          // console.log(res);
        }
        ,dataType:'json'});

 });  // end ratenowbutton click event







