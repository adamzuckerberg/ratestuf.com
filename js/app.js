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
                      $("#rateNowButton").click(function() {
                          $("#loginFacebook").css('border', 'none');
                      });
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

  window.console && console.log(data.items);
  window.console && console.log(data);

// ********************************************************
// Dynamically Create HTHML5 Mirror of Rating Table Section
// ********************************************************

          // var comparison = [{
          //     "name": data.items.itemName,
          //     "itemId": data.items[itemId],
          //     "searchTerm": "Obama vs. Batman",
          //     "xAxis": data.items.xAxis,
          //     "xRating": data.items.xRating,
          //     "yAxis": data.items.yAxis,
          //     "yRating": data.items.yRating,
          //     "color": '#009900'
          //   },
          //     {
          //     "name": "batman",
          //     "itemId": 123,
          //     "searchTerm": "Obama vs. Batman",
          //     "xAxis": "coolness",
          //     "xRating": 0.85,
          //     "yAxis": "intelligence",
          //     "yRating": 0.4,
          //     "color": '#009900'
          //   },
          //     {
          //       "name": "obama",
          //       "itemId": 123,
          //       "searchTerm": "Obama vs. Batman",
          //       "xAxis": "coolness",
          //       "xRating": 0.5,
          //       "yAxis": "intelligence",
          //       "yRating": 0.1,
          //       "color": '#33ccff'
          //     }];

          // var canvas = $("canvas")[0];
          // canvas.width = 1000;
          // canvas.height = 533;

          // var ctx = canvas.getContext("2d");
          // var centerX = $("canvas").width() / 2;
          // var centerY = $("canvas").height() / 2;
          // var radius = 25;
          // var canvas = $("canvas")[0];

          // // Draw Background
          // ctx.beginPath();
          // ctx.rect(70, 4, canvas.width-70-4, canvas.height-63);
          // // ctx.fillStyle = "#CFBE6E";
          // ctx.fillStyle = "rgba(207, 190, 110, 0.3)";
          // ctx.fill();
          // ctx.lineWidth = 4;
          // ctx.strokeStyle = '#000';
          // ctx.stroke();

          // // // Arrow up/down
          // ctx.beginPath();
          // ctx.fillStyle = "#999";
          // ctx.fillRect(25, 50, 20,
          //   canvas.height  - 110);
          // ctx.lineWidth = 2;
          // ctx.strokeStyle = '#000';
          // ctx.stroke();

          // ctx.fillStyle = "#999";

          // ctx.moveTo(35, 0);
          // ctx.lineTo(10, 50);
          // ctx.lineTo(60, 50);
          // ctx.fill();


          // // // Arrow left/right
          // ctx.fillStyle = "#999";
          // ctx.fillRect(
          //   70, // x
          //   canvas.height - 40, // y
          //   canvas.width - 130,
          //   20
          // );
          // ctx.fillStyle = "#999";
          // ctx.beginPath();
          // ctx.moveTo(1000, 505); //point
          // ctx.lineTo(940, 480);
          // ctx.lineTo(940, 525);
          // ctx.fill();


          // // // Input x-axis
          // ctx.beginPath();
          // ctx.rect(  380, // x
          //   canvas.height - 50, // y
          //   300,
          //   45
          // );
          // ctx.fillStyle = "white";
          // ctx.fill();
          // ctx.lineWidth = 2;
          // ctx.strokeStyle = 'grey';
          // ctx.stroke();

          // // // Input y-axis
          // ctx.beginPath();
          // ctx.rect(
          //   0, // x
          //   220, // y
          //   300,
          //   45
          // );
          // ctx.fillStyle = "white";
          // ctx.fill();
          // ctx.lineWidth = 2;
          // ctx.strokeStyle = 'grey';
          // ctx.stroke();

          // // // Draw ratings and balls in a foreach loop - can we split this up to design the balls with shadow etc.
          // comparison.forEach(function (data) {
          //   ctx.beginPath();
          //   ctx.arc(canvas.width * data.xRating,
          //           canvas.height * data.yRating,
          //           radius, 0, 2 * Math.PI, false);
          //   ctx.fillStyle = data.color;
          //   ctx.fill();
          //   ctx.lineWidth = 4;
          //   ctx.strokeStyle = '#003300';
          //   ctx.stroke();
          //   ctx.fill();

          //   ctx.fillStyle = "black";
          //   ctx.textAlign = 'center';
          //   ctx.font = "normal 800 32px Arial";

          //   ctx.fillText(
          //     data.name,
          //     canvas.width * data.xRating,
          //     canvas.height * data.yRating + 55
          //   );
          // });


          // // // X legend
          // ctx.fillStyle = "black";
          // ctx.textAlign = 'center';
          // ctx.font = "36px Arial";
          // ctx.fillText(
          //   comparison[0].xAxis,
          //   canvas.width / 2 + 27,
          //   canvas.height - 17
          // );


          // // // Y legend
          // ctx.fillStyle = "black";
          // ctx.textAlign = 'center';
          // ctx.font = "36px Arial";
          // ctx.fillText(
          //   comparison[0].yAxis,
          //   152,
          //   254
          // );

          // document.getElementById('result').src = data_url;
          // console.log(data_url);


          //   var data_url = canvas.toDataURL();

          // $.post( "ajax/upload_data.php.html", function( data_url ) {
          //   console.log("Payload to server" + data_url);
          // }).done(function( data ) {
          //   alert( "Response from server " + data );
          // });

// FROM VIDEO SEND CANVAS AS URL TO SERVER

// var myDrawing = $("#myCanvas");
// var drawingString = myDrawing.toDataURL("image/png");
// var postData = "canvasData="+drawingString;
// var ajax = new XMLHttpRequest();
// ajax.open("POST",'postcanvastofb.php',true);
// ajax.setRequestHeader('Content-Type', 'canvas/upload');
// ajax.onreadystatechange=function()
// {
//   if (ajax.readyState == 4)
//     {alert("image saved");}
// }
// ajax.send(postData);




// ********************************************************
// Dynamically Create HTHML5 Mirror of Rating Table Section
// ********************************************************

});

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

                $.ajax({ 

              type: "GET",
              url: "ajax/saveratings.php",
              url: "screenshot.php?s="+encodeURI($("#searchTags").val()),
              contentType: "application/json",

              success: function(res) {
                // console.log(res);

              window.open("https://www.facebook.com/dialog/feed?app_id=228744763916305&display=popup&caption=test&link=http://www.ratestuf.org"&$file,'_parent');

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

      });








