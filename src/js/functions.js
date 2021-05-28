/**
 * File functions.js.
 *
 * Custom scripts for the theme
 *
 */

// Add bg-dark on navbar on scroll
var nav = document.querySelector("nav");

window.addEventListener("scroll", function () {
  if (window.pageYOffset > 100) {
    nav.classList.add("bg-dark", "shadow");
  } else {
    nav.classList.remove("bg-dark", "shadow");
  }
});

// Scroll to content on click
document.addEventListener('DOMContentLoaded', function() {
  var scrolldown = document.getElementById("scroll-down");

  scrolldown.onclick = function () {
    document.getElementById("content").scrollIntoView({
      behavior: 'smooth',
    });
  }
});
