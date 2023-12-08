document.addEventListener('DOMContentLoaded', function () {
  window.onscroll = function () { scrollFunction() };

  function scrollFunction() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
      document.getElementById("header").style.backgroundColor = '#00035e';
      document.getElementById("header").style.maxHeight = '90px';

    }
    else {
      document.getElementById("header").style.backgroundColor = 'transparent';
    }
  }

  //slideshow

  let slideIndex = 0;
  let slideTimer;

  function plusSlides(n) {
    clearTimeout(slideTimer);
    showSlides(slideIndex += n);
  }

  function showSlides() {
    let i;
    const slides = document.getElementsByClassName("mySlides");

    if (slideIndex >= slides.length) {
      slideIndex = 0;
    }

    if (slideIndex < 0) {
      slideIndex = slides.length - 1;
    }

    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }

    slides[slideIndex].style.display = "block";
    slideIndex++;
    slideTimer = setTimeout(showSlides, 10000); // Change slide every 2 seconds
  }

  // Start the slideshow
  showSlides();




});