/**
 * File functions.js.
 *
 * Custom scripts for the theme
 *
 */

(function ($) {
  "use strict";
  /** Viewport dimensions */
  var ww = $(window).width();
  var wh = $(window).height();

  $(window).on('load', function(){

    // Resize image containers using background-image
    $(".lazy-img").each(function() {
        $(this).css("background-image", "url(" + $(this).attr("data-img") + ")");
    });

    // Mobile menu icon swap on click
    $("#menu-toggle").click(function() {
      $("body").toggleClass("menu-open");
      $('#menu-toggle i').toggleClass('fa-times fa-bars');
      return false;
    });
    if (ww <= 1e3) {
      $("#primary-menu li a").click(function() {
        $("#menu-toggle").trigger("click");
      });
    }

    // Header scroll class
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {
        $('#masthead').addClass('header-scrolled');
      } else {
        $('#masthead').removeClass('header-scrolled');
      }
    });

    if ($(window).scrollTop() > 100) {
      $('#masthead').addClass('header-scrolled');
    }

    // Back to top button
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {
        $('.back-to-top').fadeIn('slow');
      } else {
        $('.back-to-top').fadeOut('slow');
      }
    });
    $('.back-to-top').click(function(){
      $('html, body').animate({
        scrollTop : 0
      },1000, 'swing');
    });

    // Scroll down to content
    $(".scroll-down").click(function() {
      event.preventDefault();
      $("html, body").animate({
        scrollTop: $("#content").offset().top -200
      }, "slow", "swing");
    });

    $(".menu-kontakt-oss").click(function() {
      event.preventDefault();
      $("html, body").animate({
        scrollTop: $("#contact-us").offset().top -100
      }, "slow", "swing");
    })

    // Scroll down to map
    $("#gps").click(function() {
      event.preventDefault();
      $("html, body").animate({
        scrollTop: $("#map").offset().top
      }, "slow", "swing");
    });

    // Lazy Load google maps
    $('.map').lazymap({
      //apiKey: 'AIzaSyCPvuwYOX0fKJwrKUsC_vf0UTrpDP9sEQQ'
      apiKey: 'AIzaSyCAt99Ey-65N1jo10RNk6ekqzaWoLvspfQ'
    });

    $('.brygge-plass').click(function() {
      event.preventDefault();
    })
  });

})(jQuery);