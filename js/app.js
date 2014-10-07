// $(document).ready(function() {
// $("#rateTableFrame").css('border', '2px solid blue');
// $('.draggable').parent().css('border', '1px solid red');
// });

$(document).ready(function() {
  if (getUrlParameter('rs') != null) {
  window.location.href="http://www.ratestuf.org?s="+getUrlParameter('rs');
  }
});


$('#update_widget_code_button').click(function(event) {
  event.preventDefault();
  $('#update_widget_code_button').toggle();
  $('#clear_widget_code_button').show();
  //update iframe code
  $('#widget_text_area').text('<iframe src="http://www.ratestuf.org/widget-custom.php?s='+encodeURIComponent($('#inputsTerm').val())+'&xAxis='+encodeURIComponent($('#inputxAxis').val())+'&yAxis='+encodeURIComponent($('#inputyAxis').val())+'"'+' height="440px" width="500px" style="border:0px;"></iframe>');
});

$('#clear_widget_code_button').click(function() {
  event.preventDefault();
  $('#update_widget_code_button').show();
  $('#clear_widget_code_button').toggle(); 
  $('#widget_text_area').text('<iframe src="http://www.ratestuf.org/widget-standard.php" height="660px" width="680px" style="border:0px;"></ifrmae>');
});

$(document).ready(function() {
  $('#hidden_widget_sharing_area').hide();
  $('#clear_widget_code_button').hide();
});
$('#view_the_widget_button').click(function(){
  $('#hidden_widget_sharing_area').toggle();
});

// $('#copy_to_clipboard_button').click(function(){
//   $('#copy_to_clipboard_button').toggle(); 
//   $('#widget_text_area').html('stuf copied - now get out there and get some ratings!');
//   $('#update_widget_code_button').toggle();
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

    if (!$("#shareNowButton").hasClass('disabled')) {
return;
}  
    $(".draggable").click(function() {
        $("#arrowUp").fadeIn(2000);
    });
    $(".draggable").hover(function() {
        $("#arrowUp").fadeIn(2000);
    });

    $("#shareNowButton").click(function() {
        $("#arrowUp").fadeIn(2000);
    });
    $("#shareNowButton").click(function() {
        $("#arrowUp").fadeOut(600);
    });
    $("loginFacebook").click(function() {
        $("#arrowUp").fadeOut(100);
    });
    $("#shareNowButton").hover(function() {
        $("#arrowUp").fadeOut(200);
    });

    $("#shareNowButton").hover(function() {
        $("#loginFacebook").fadeIn(50).css('border', '10px solid #1cff2c');
        $("#loginFacebook").css('borderRadius','10px');
        $("#loginFacebook").css('margin-top','22px');
    });
    // $("#shareNowButton").click(function() {
    //     $("#loginFacebook").css('border', 'none');
    // });
    $("#shareNowButton").mouseout(function() {
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

$(function() {
  // if (userloggedin) {
  $(".yinput_draggable").draggable();
// } 
  });


// ********************************************************************
// INSERT RATINGS INTO DATABASE AND CREATE HTML CANVAS DYNAMICALLY
// ********************************************************************

//create a global variable and an empty javascript object {}
  var data ={};
//craete a javascript numerical array
  data.items = [];
//craete a javascript numerical array
  canvasBalls = [];
$("#shareNowButton").click(function(){

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
  xAxis = $('.input-value-on-the-x-axis').val().trim();
  yAxis = $('.input-value-on-the-y-axis').val().trim();
  positionFromLeft = ($(this).position().left);
  positionFromTop = ($(this).position().top);
  xRating = (Math.round((positionFromLeft / containerWidth) * 100 )/ 100);
  yRating = (Math.round((1-(positionFromTop / containerHeight))* 100 )/ 100);
  domain = location.hostname;
  // testing code
  console.log('container height: '+ containerHeight);
  console.log('position from top: '+ positionFromTop);
  console.log('container width: '+ containerWidth);
  console.log('position from left: '+ positionFromLeft);
  console.log('xRating'+ xRating);
  console.log('yRating' + yRating);

  data.items.push({"name": itemName, "itemId": itemId, "xAxis": xAxis, "xRating":xRating, "yAxis":yAxis, "yRating":yRating, "domain":domain});

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

                    var canvas = $("canvas")[0];

          var radius = 25;
          var x = 75;
          var y = 13;
          var rightMargin = 10;
          var width = canvas.width-x;
          var height = canvas.height-63;

          function drawRatingTable() {

            ctx.beginPath();
            ctx.moveTo(x, y);
            ctx.lineTo((canvas.width - rightMargin), y);
            // ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
            ctx.lineTo((canvas.width - rightMargin), y + height - 10);
            // ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
            ctx.lineTo(x, y + height - 10);
            // ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
            ctx.lineTo(x, y);
            // ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.closePath();
                    ctx.fillStyle = "rgba(207, 190, 110, 0.3)";
                    ctx.fill();
                    ctx.lineWidth = 2;
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

                    ctx.moveTo(35, 0 + 10);
                    ctx.lineTo(10, 50 + 10);
                    ctx.lineTo(60, 50 + 10);
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
                    ctx.moveTo(1000 - rightMargin, 505); //point
                    ctx.lineTo(940 - rightMargin, 480);
                    ctx.lineTo(940 - rightMargin, 525);
                    ctx.fill();
          } drawLeftRightArrow();

          function drawInputOnXAxis() {
                    ctx.beginPath();
                    ctx.rect(  350, // x
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
          } drawInputOnXAxis();


          function drawTextIntoXAxisInputField() {
                              // // X legend
                    ctx.shadowBlur = 0;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 0;
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

          function drawFirstBall() {
                    //Draw the first ball
                    ctx.beginPath();
                    ctx.fillStyle = "#00ff00";
                    ctx.arc(((canvas.width * (1-(60/1000))) * canvasBalls[0].xRating)+x+radius,
                              ((canvas.height * (1-(53/533))) * (1-canvasBalls[0].yRating))+y+15,
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
                      (((canvas.width * (1-(60/1000))) * canvasBalls[0].xRating)+x+radius) + 37,
                      (((canvas.height * (1-(53/533))) * (1-canvasBalls[0].yRating))+y) + 63
                    );
                    ctx.closePath();
          } drawItemNameBelowFirstBall();

          function drawSecondBall() {

                    if (!canvasBalls[1]) {
                      return;
                    }
                    //Draw the second ball
                    ctx.beginPath();
                    ctx.fillStyle = "#33ccff";
                    ctx.arc(((canvas.width * (1-(60/1000))) * canvasBalls[1].xRating)+x+radius,
                              ((canvas.height * (1-(53/533))) * (1-canvasBalls[1].yRating))+y+15,
                              radius, 0, 2 * Math.PI, false);
                    ctx.fill();
                    ctx.shadowColor = '#999';
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = 7;
                    ctx.shadowOffsetY = 7;
                    ctx.fill();
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
                      (((canvas.width * (1-(60/1000))) * canvasBalls[1].xRating)+x+radius) + 37,
                      (((canvas.height * (1-(53/533))) * (1-canvasBalls[1].yRating))+y) + 63
                    );
                    ctx.closePath();
          } drawItemNameBelowSecondBall();


          function drawInputOnYAxis() {
          // translate context to center of canvas
             ctx.translate(10, 210);
          // rotate 45 degrees clockwise
              ctx.rotate(-90 * Math.PI/180);
                    ctx.beginPath();
                    ctx.rect(
                      -190, // x
                      0, // y
                      300,
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
          } drawInputOnYAxis();

          function drawTextIntoYAxisInputField() {
                    // // Y legend
                    ctx.shadowBlur = 0;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 0;
                    ctx.fillStyle = "black";
                    ctx.textAlign = 'center';
                    ctx.font = "36px Arial";
                    ctx.fillText(
                      // the yaxis name will be the same for ball 2 if it exists
                      canvasBalls[0].yAxis,
                      -35,
                      35
                    );

          } drawTextIntoYAxisInputField();

          var data_url = $('#myCanvas')[0].toDataURL();
          // document.getElementById('result').src = data_url;
          console.log(data_url);

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
        error: function(response) {
        // alert("Sorry, something is not working. It must be our fault. Please check back");
        console.log(response);
              },
        dataType:'json'});

/*       var get_variable = new RegExp('[\?&amp;]s=([^&amp;#]*)').exec(window.location.href);
          //post the html5 canvas image and push it into your facebook.
            $.ajax({ 
              data: { s : get_variable[1] },
              type: "GET",
              url: "screenshots/screenshot.php",
              success: function(response) {

            window.open("https://www.facebook.com/dialog/feed?app_id=228744763916305&display=popup&caption=test&link=http://ratestuf.org/screenshots/5420f480c44d4.png",'_blank');

              },
              error: function(response) {
              console.log(response);
              }
              ,dataType:'json'});*/



        var png_image_source = $('#myCanvas')[0].toDataURL( 'image/png' );
        console.log( png_image_source );
          //post the html5 canvas image and push it into your facebook.
            $.ajax({ 
              data: { png_image_source : png_image_source},
              type: "POST",
              url: "ajax/upload_canvas_image.php",
              success: function(response) {
    window.open("https://www.facebook.com/dialog/feed?app_id=228744763916305&display=popup&name=My%20rating%20of%20"+encodeURI(getUrlParameter('s'))+"&link=http://ratestuf.org?i="+response.imageName+encodeURIComponent('&rs='+getUrlParameter('s'))+'&redirect_uri='+encodeURI('http://www.ratestuf.org/facebook-redirect.php')+"&caption="+encodeURI("Ratestuf is the easiest way to rate and share stuf.")+'&description=ratestuf.org','_blank');
              },
              error: function(response) {
                console.log(response);
              }
              ,dataType:'json',
              async:false
            });



 });  // end shareNowButton click event


function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}
  

// ******************************************
// WIDGET RATE NOW BUTTON - LOTS OF DUPLICATION - NOT DRY - NEEDS REFACTORING
// *******************************************
// These variables have same names as shareNowButton onclick event function
//create a global variable and an empty javascript object {}
  var data ={};
//craete a javascript numerical array
  data.items = [];

$("#rateNowButtonForStandardWidget").click(function(){


  if ($('.draggable').length == 0) { 
   alert("Please search for an item first.");
    return;
  }

  console.log('its working so far');
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
  // domainToken
  domainToken = $('#domainToken').val();
  if (domainToken) {
    domain = domainToken;
  }

  // testing code
  console.log("domain: "+domain);
  // console.log(itemName);
  // console.log(itemId);
  // console.log(xAxis);
  // console.log(yAxis);
  // console.log('container height: '+ containerHeight);
  // console.log('position from top: '+ positionFromTop);
  // console.log('container width: '+ containerWidth);
  // console.log('position from left: '+ positionFromLeft);
  // console.log('xRating'+ xRating);
  // console.log('yRating' + yRating);

  data.items.push({"name": itemName, "itemId": itemId, "xAxis": xAxis, "xRating":xRating, "yAxis":yAxis, "yRating":yRating, "domain":domain});

          
// re-enable to button which was disabled to keep duplicate pushes of data into the array
  $(this).addClass('enabled');
});  //end each draggable ball function

      //Send the data.items array with draggable ball info to the db via the saveratings.php script
       $.ajax({ 

        url: "ajax/saveratings.php",
        data: JSON.stringify(data),
        type: "POST",
        contentType: "application/json",
        success: function(response) {
          if (response.hasOwnProperty('alreadyRated')) {
            alert("You've already rated this stuf.");
          } else {
          // alert("Got it! Thanks for adding your rating. You are awesome!");          
          console.log("Got it! Thanks for adding your rating. You are awesome!");
          }
        },
        error: function(response) {
        // alert("Sorry, something is not working. It must be our fault. Please check back");
        console.log(response);
              },
        dataType:'json'});
          alert("Got it! Thanks for adding your rating. You are awesome!"); 
 });  // end rateNowButtonForStandardWidget click event

$("#rateNowButtonForCustomWidget").click(function(){

  if ($('.draggable').length == 0) { 
   alert("Please search for an item first.");
    return;
  }
    console.log('its working so far - custom widget');
// prevent multiple clicks due to user ADHD. Part 1 of 2. Re-enabled later on in code
  $(this).addClass('disabled');

  $('.draggable').each(function() {

  itemName = $(this).attr('name');
  itemId = $(this).attr('id');
  containerHeight = ($(this).parent().height() * 0.895 );
  containerWidth = ($(this).parent().width() * 0.9344);
  xAxis = $('#widget-x-axis-name').text().trim();
  yAxis = $('#widget-y-axis-name').text().trim();
  positionFromLeft = ($(this).position().left);
  positionFromTop = ($(this).position().top);
  xRating = (Math.round((positionFromLeft / containerWidth) * 100 )/ 100);
  yRating = (Math.round((1-(positionFromTop / containerHeight))* 100 )/ 100);
  domain = document.referrer;

  // testing code
  // console.log(itemName);
  // console.log(itemId);
  // console.log(xAxis);
  // console.log(yAxis);
  // console.log(domain);
  // console.log('container height: '+ containerHeight);
  // console.log('position from top: '+ positionFromTop);
  // console.log('container width: '+ containerWidth);
  // console.log('position from left: '+ positionFromLeft);
  // console.log('xRating'+ xRating);
  // console.log('yRating' + yRating);

  data.items.push({"name": itemName, "itemId": itemId, "xAxis": xAxis, "xRating":xRating, "yAxis":yAxis, "yRating":yRating, "domain":domain});

          
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
          // alert("Got it! Thanks for adding your rating. You are awesome!");          
          console.log("Got it! Thanks for adding your rating. You are awesome!");
          }
        },
        error: function(response) {
        // alert("Sorry, something is not working. It must be our fault. Please check back");
        console.log(response);
              },
        dataType:'json'});

        alert("Got it! Thanks for adding your rating. You are awesome!");   
 });  // end rateNowButtonForStandardWidget click event

// $(document).ready(function() {
//       $("#searchTags").autocomplete({source:'getautocomplete.php', minLength:1});
//   });
