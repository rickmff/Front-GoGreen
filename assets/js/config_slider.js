$(document).ready(function(){
  $('.sliders').slick({
  slidesToShow: 1,
  accessibility: false,
  slidesToScroll: 1,
  autoplay: true,
  adaptiveHeight: true,
  autoplaySpeed: 2000,
  prevArrow: ".prev",
  nextArrow: ".next",
  dots: true,
  });
});