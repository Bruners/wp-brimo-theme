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

    $(".menu-kontakt-oss").click(function() {
      event.preventDefault();
      $("html, body").animate({
        scrollTop: $("#contact-us").offset().top -100
      }, "slow", "swing");
    })
  });

})(jQuery);


// Add bg-dark on navbar on scroll
var nav = document.querySelector("nav");

window.addEventListener("scroll", function () {
  if (window.pageYOffset > 100) {
    nav.classList.add("bg-dark", "shadow");
  } else {
    nav.classList.remove("bg-dark", "shadow");
  }
});

document.addEventListener('DOMContentLoaded', function() {
  var scrolldown = document.getElementById("scroll-down");

  scrolldown.onclick = function () {
    document.getElementById("content").scrollIntoView({
      behavior: 'smooth',
    });
  }
});
