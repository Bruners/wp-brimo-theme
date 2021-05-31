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
  document.querySelectorAll(".lazy-bg-loaded").forEach(lazy_bg => {
    var image = lazy_bg.getAttribute('data-src');
    lazy_bg.setAttribute("style", "background-image: url(" + image + ")");
  });
});


// Document ready
var ready = callback => {
  if (document.readyState != "loading") callback();
  else document.addEventListener("DOMContentLoaded", callback);
};

ready(() => {
  /* Do things after DOM has fully loaded */
  // Scroll to content on click
  var scrolldown = document.getElementById("scroll-down");

  scrolldown.onclick = function () {
    document.getElementById("content").scrollIntoView({
      behavior: 'smooth',
    });
  }
});

