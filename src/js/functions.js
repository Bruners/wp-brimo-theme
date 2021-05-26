/**
 * File functions.js.
 *
 * Custom scripts for the theme
 *
 */

(function ($) {
  "use strict";

  $(window).on('load', function(){

    // Resize image containers using background-image
    $(".lazy-img").each(function() {
        $(this).css("background-image", "url(" + $(this).attr("data-img") + ")");
    });

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
  });

})(jQuery);


 var nav = document.querySelector('nav');

      window.addEventListener('scroll', function () {
        if (window.pageYOffset > 100) {
          nav.classList.add('bg-dark', 'shadow');
        } else {
          nav.classList.remove('bg-dark', 'shadow');
        }
      });