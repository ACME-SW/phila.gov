/**
 *
 * Custom js for our theme
 *
**/

//department filter list
new List('filter-list', {
    valueNames: ['item', 'item-desc']
});

jQuery(document).ready(function($) {

  //add search focus on tap or click
  $('.search-icon').click(function() {

    var fadeOn = $( ".fade" ).is( ":visible" );

    $('.search-field').focus();

    if ( !fadeOn ){
      $('#page').prepend('<div class="fade"></div>');
    }

    $('.fade').click(function() {
      $('.fade').remove();
    });

    var string = $('.search-field').val();

    if( string.match(/\S/) ){
      $('.search-submit').submit();
    }
  });

  var alphaAlertHeight = $("#alpha-alert").css( "height" );

  //push the custom image down, past the alpha-alert so it will not be cut/not displayed at the full height
  if (alphaAlertHeight){
    $('body.custom-background').css('background-position-y', alphaAlertHeight );
  }

  //force foudation menus to display horizontally on desktop and vertically when 'is-drilldown' is present ( aka, on mobile )
  $('.menu-icon').click(function() {
    $('.is-drilldown').find('ul').addClass('vertical');

  });
  $( window ).resize(function() {
    $('.is-drilldown').find('ul').removeClass('vertical');
  });


  //prevent enter from refreshing the page and stopping filter search
  $('#filter-list input').keypress(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

  $('.clickable-row').click(function() {
    window.location = $(this).data('href');
  });

  $('.clickable-row').hover(function() {
    $(this).addClass('is-hover');
    },
    function(){
      $(this).removeClass('is-hover');
  });

  /* Hijack mailchimp signup forms to use ajax handler */

  /*NOTE: this method requires that the form action URL from mailchimp uses subscribe/post-json */
  ajaxMailChimpForm($("#mc-embedded-subscribe-form"), $("#mc_embed_signup"));
  // Turn the given MailChimp form into an ajax version of it.
  // If resultElement is given, the subscribe result is set as html to
  // that element.
  function ajaxMailChimpForm($form, $resultElement){
    // Hijack the submission. We'll submit the form manually.
    $form.submit(function(e) {
      e.preventDefault();
      if (!isValidEmail($form)) {
        var error =  "A valid email address must be provided.";
        $resultElement.append(error);
        $resultElement.css("color", "#f99300");
      } else {
        $resultElement.css("color", "black");
        $resultElement.append("Subscribing...");
        submitSubscribeForm($form, $resultElement);
      }
    });
  }
  // Validate the email address in the form
  function isValidEmail($form) {
    var email = $form.find("input[type='email']").val();
    if (!email || !email.length) {
        return false;
    } else if (email.indexOf("@") == -1) {
        return false;
    }
    return true;
  }
  // Submit the form with an ajax/jsonp request.
  // Based on http://stackoverflow.com/a/15120409/215821
  function submitSubscribeForm($form, $resultElement) {
    $.ajax({
      type: "GET",
      url: $form.attr("action"),
      data: $form.serialize(),
      cache: false,
      dataType: "jsonp",
      jsonp: "c", // trigger MailChimp to return a JSONP response
      contentType: "application/json; charset=utf-8",
      error: function(error){
          // According to jquery docs, this is never called for cross-domain JSONP requests
      },
      success: function(data){
        if (data.result != "success") {
          var message = data.msg || "Sorry. Unable to subscribe. Please try again later.";
          $resultElement.css("color", "#f99300");
          if (data.msg && data.msg.indexOf("already subscribed") >= 0) {
            message = "You're already subscribed. Thank you.";
            $resultElement.css("color", "black");
          }else if (data.msg && data.msg.indexOf("zip code") >= 0) {
            message = "Please enter a valid zip code.";
            $resultElement.css("color", "f99300");
          }
          $resultElement.append(message);
        } else {
          $resultElement.css("color", "#58c04d");
          $resultElement.html("Thank you!<br>You must confirm the subscription in your inbox.");
        }
      }
    });
  }

  //Set Hero Header Tagline font sizes
  if( $('.intro .tagline1').length && $('.intro .tagline2').length  ) {
    var smallFontSize = 3;
    var largeFontSize = 8;
    var largeLineMaxWidth;

    if( $('.measureline1').width() > 350) {
      console.log('Test is wider that h1');
      while ( $('.measureline1').width() > 350 ) {
        smallFontSize = smallFontSize - .1;
        $('.measureline1').css('font-size', smallFontSize + 'rem');
      }
      largeLineMaxWidth = $('.measureline1').width();
    } else {
      largeLineMaxWidth  = $('.measureline1').width();
    }

    if( $('.measureline2').width() > largeLineMaxWidth ) {
      console.log('Test is wider than h1');
      while ( $('.measureline2').width() > largeLineMaxWidth ) {
        largeFontSize = largeFontSize - .1;
        $('.measureline2').css('font-size', largeFontSize + 'rem');
      }
    }

    //Append new styles to head
    $('<style type="text/css">@media screen and (min-width: 40em){ .department .department-header .intro h1 {padding:.5rem 0 0;}.department .department-header .intro h1 .tagline1, .department .department-header .intro h1 .tagline2 { display:block; width:100%; line-height:1;} .department .department-header .intro h1 .tagline1{ font-size:' + (smallFontSize/1.6) + 'rem;} .department .department-header .intro h1 .tagline2{ font-size:' + (largeFontSize/1.6) + 'rem;}} @media screen and (min-width: 48em){ .department .department-header .intro h1 .tagline1{ font-size:' + smallFontSize + 'rem;} .department .department-header .intro h1 .tagline2{ font-size:' + largeFontSize + 'rem;}} </style>').appendTo("head");

  }
});
