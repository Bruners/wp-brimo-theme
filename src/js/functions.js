/**
 * File functions.js.
 *
 * Custom scripts for the theme
 *
 */

// Add bg-dark on navbar on scroll
var nav = document.querySelector("nav");
var logo_color = document.getElementById("logo_color");
var logo_white = document.getElementById("logo_white");

window.addEventListener("scroll", function () {
  if (window.pageYOffset > 100) {
    nav.classList.add("bg-dark", "shadow");
    logo_color.classList.remove("d-none");
    logo_color.classList.add("d-inline-block");
    logo_white.classList.remove("d-inline-block");
    logo_white.classList.add("d-none");
  } else {
    nav.classList.remove("bg-dark", "shadow");
    logo_color.classList.remove("d-inline-block");
    logo_color.classList.add("d-none");
    logo_white.classList.remove("d-none");
    logo_white.classList.add("d-inline-block");
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

  scrolldown.onclick = function (e) {
    e.preventDefault();
    document.getElementById("content").scrollIntoView({
      behavior: 'smooth',
    });
  }
});

