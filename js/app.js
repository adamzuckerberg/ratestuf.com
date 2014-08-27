$(document).ready(function() {
  verticallyAlignDollarIcons();
  horizontallyAlignStart();
});

$(document).mouseover(function() {
  verticallyAlignDollarIcons();
  horizontallyAlignStart();
  setTimeout("",20000);
});

function verticallyAlignDollarIcons() {
var dollarSpacing = ($('.dollarRating').height());
var dollarHeight = ($('#fourDollars').height() * 4.5);
var dollarPadding = ((dollarSpacing - dollarHeight)/8);

$('.dollarRating').children().css('padding-top',dollarPadding);
$('.dollarRating').children().css('padding-bottom',dollarPadding);
}

// triggers on load or resize for DOLLARS.
$(window).resize(function() {

var dollarSpacing = ($('.dollarRating').height());
var dollarHeight = ($('#fourDollars').height() * 4);
var dollarPadding = ((dollarSpacing - dollarHeight)/8);

$('.dollarRating').children().css('padding-top',dollarPadding);
$('.dollarRating').children().css('padding-bottom',dollarPadding);

}).trigger('resize');


// triggers on load or resize for STARS

function horizontallyAlignStart() {

var starSpacing = ($('.starRating').width());
var starWidth = ($('#star1').width() * 5);
var starPadding = ((starSpacing - starWidth)/11.2);

$('.starRating').children().css('padding-right',starPadding);
$('.starRating').children().css('padding-left',starPadding);

}

$(window).resize(function() {

var starSpacing = ($('.starRating').width());
var starWidth = ($('#star1').width() * 5);
var starPadding = ((starSpacing - starWidth)/11.2);

$('.starRating').children().css('padding-right',starPadding);
$('.starRating').children().css('padding-left',starPadding);

}).trigger('resize');


// $(".draggable").mouseover(function(){
//     $("#responsiveAd1").show();
// });

// $(".draggable").mouseover(function(){
//     $(this).addClass("draggableHover");
// });
// $(".draggable").mouseout(function(){
//     $(this).removeClass("draggableHover");
// });


//user is able to select a draggable ball and delete it from the screen using BACKSPSACE or DELETE
$(".draggable").dblclick(function(){
  if (userloggedin) {
    $(".draggable").not(this).removeClass("active");
    $(this).toggleClass("active");
  }
});

$(".draggable").mousemove(function(){

//STARS
    $(".star").removeClass('starhover');

    if ($(this).position().left > (($("#star1").position().left)+30)) {
      // alert("sukadik");
      $("#star1").addClass('starhover');
    } 
    if ($(this).position().left > (($("#star2").position().left)+30)) {
      // alert("sukadik");
      $("#star2").addClass('starhover');
    }
    if ($(this).position().left > (($("#star3").position().left)+30)) {
      // alert("sukadik");
      $("#star3").addClass('starhover');
    }
        if ($(this).position().left > (($("#star4").position().left)+30)) {
      // alert("sukadik");
      $("#star4").addClass('starhover');
    }
        if ($(this).position().left > (($("#star5").position().left)+-20)) {
      // alert("sukadik");
      $("#star5").addClass('starhover');
    }
//DOLLARS
    $("#fourDollars").removeClass('dollarhover');
    $("#threeDollars").removeClass('dollarhover');   
    $("#twoDollars").removeClass('dollarhover');
    $("#oneDollar").removeClass('dollarhover');

    if ($(this).offset().top < (($("#fourDollars").offset().top)+40)) {
      // alert("sukadik");
      $("#fourDollars").addClass('dollarhover');
    } 
    if ($(this).offset().top < (($("#threeDollars").offset().top)+40)) {
      // alert("sukadik");
      $("#threeDollars").addClass('dollarhover');
    }
    if ($(this).offset().top < (($("#twoDollars").offset().top)+40)) {
      // alert("sukadik");
      $("#twoDollars").addClass('dollarhover');
    }
        if ($(this).offset().top < (($("#oneDollar").offset().top)+20)) {
      // alert("sukadik");
      $("#oneDollar").addClass('dollarhover');
    }

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


          //display ratings
            // $(".draggable").mousedown(function() {
            //     $(this).find(".speechBubble").fadeIn(1000).delay(50).fadeOut(2500);
            //     $(this).find(".ratings").fadeIn(1000).delay(50).fadeOut(2500);
            //     return;
            // });




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
              if (userloggedin) {
              $(".draggable").draggable({ containment: "#containmentWrapper" });
            } 
              });


 $("#hide").click(function(){
  $("#filters").hide();
  $("#show").show();  
  $("#hide").hide(); 
});

$("#show").click(function(){
  $("#filters").show();
  $("#hide").show();  
  $("#show").hide(); 
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
  xRating = (Math.round(($(this).position().left / ($(this).parent().width())) * 100) / 100);
  yRating = (Math.round(($(this).position().top / ($(this).parent().height())) * 100) / 100);
  data.items.push({"name": itemName, "itemId": itemId, "xRating":xRating, "yRating":yRating});

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
    alert("Got it! Thanks for adding your ratings to our database. You are awesome!");
    location.reload();
    }
    // Location.reload(true);
  },
  error: function(res) {
    // console.log(res);
  }
  ,dataType:'json'});

});


// $(".draggable").each(function(){

//   if (!userloggedin) {
//     $(this).addClass('greyedOut');
//   }

//   }); 

$(".draggable").each(function(){

  xPosition = (Math.round(($(this).position().left / ($(this).parent().width())) * 100));
  yPosition = (100-(Math.round(($(this).position().top / ($(this).parent().height())) * 100)));
  UpperLineSlope = 0.8965;
  yPositionOnUpperLine = ((UpperLineSlope * xPosition) + 25);
  LowerLineSlope = 0.8977;
  yPositionOnLowerLine = ((LowerLineSlope * xPosition) + 5);
  // alert('xposition: ' + xPosition + ', yposition: ' + yPosition + ' yposition of lowerline: ' + yPositionOnLowerLine + ' yposition of upperline: ' + yPositionOnUpperLine);

  if (yPosition > yPositionOnUpperLine) {
        $(this).removeClass('bestValue');
        $(this).removeClass('fairValue');  
        $(this).addClass('worseValue');
  }
  
  if (yPosition <= yPositionOnUpperLine && yPosition >= yPositionOnLowerLine) {
        $(this).removeClass('worseValue');
        $(this).removeClass('bestValue');        
        $(this).addClass('fairValue'); 
  } 
  
  if (yPosition < yPositionOnLowerLine) {
        $(this).removeClass('worseValue');
        $(this).removeClass('fairValue');  
        $(this).addClass('bestValue'); 
  }
}); 


$(".draggable").mouseover(function(){

  xPosition = (Math.round(($(this).position().left / ($(this).parent().width())) * 100));
  yPosition = (100-(Math.round(($(this).position().top / ($(this).parent().height())) * 100)));
  UpperLineSlope = 0.8965;
  yPositionOnUpperLine = ((UpperLineSlope * xPosition) + 25);
  LowerLineSlope = 0.8977;
  yPositionOnLowerLine = ((LowerLineSlope * xPosition) + 5);
  // alert('xposition: ' + xPosition + ', yposition: ' + yPosition + ' yposition of lowerline: ' + yPositionOnLowerLine + ' yposition of upperline: ' + yPositionOnUpperLine);

  // if (userloggedin && yPosition > yPositionOnUpperLine) {
  if (yPosition > yPositionOnUpperLine) {
        $(this).removeClass('bestValue');
        $(this).removeClass('fairValue');  
        $(this).addClass('worseValue');
  }
  
  if (yPosition <= yPositionOnUpperLine && yPosition >= yPositionOnLowerLine) {
        $(this).removeClass('worseValue');
        $(this).removeClass('bestValue');        
        $(this).addClass('fairValue'); 
  } 
  
  if (yPosition < yPositionOnLowerLine) {
        $(this).removeClass('worseValue');
        $(this).removeClass('fairValue');  
        $(this).addClass('bestValue'); 
  }
}); 

// duplicate to try to get highlighting on mouseover to function more smoothly so when user releases mouse, the javascript tries again to color correctly. remove this and you need to click to get a recoloring.
$(".draggable").mouseup(function(){

  xPosition = (Math.round(($(this).position().left / ($(this).parent().width())) * 100));
  yPosition = (100-(Math.round(($(this).position().top / ($(this).parent().height())) * 100)));
  UpperLineSlope = 0.8965;
  yPositionOnUpperLine = ((UpperLineSlope * xPosition) + 25);
  LowerLineSlope = 0.8977;
  yPositionOnLowerLine = ((LowerLineSlope * xPosition) + 5);
  // alert('xposition: ' + xPosition + ', yposition: ' + yPosition + ' yposition of lowerline: ' + yPositionOnLowerLine + ' yposition of upperline: ' + yPositionOnUpperLine);

  if (yPosition > yPositionOnUpperLine) {
        $(this).removeClass('bestValue');
        $(this).removeClass('fairValue');  
        $(this).addClass('worseValue');
  }
  
  if (yPosition <= yPositionOnUpperLine && yPosition >= yPositionOnLowerLine) {
        $(this).removeClass('worseValue');
        $(this).removeClass('bestValue');        
        $(this).addClass('fairValue'); 
  } 
  
  if (yPosition < yPositionOnLowerLine) {
        $(this).removeClass('worseValue');
        $(this).removeClass('fairValue');  
        $(this).addClass('bestValue'); 
  }
}); 
  
