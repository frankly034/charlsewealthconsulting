$(document).ready(function () {
  $(".menu-toggle").click(function () {
    $("nav").toggleClass("active");
  });
  
  var owl = $('.owl-carousel');
  owl.owlCarousel({
    items: 2,
    loop: true,
    margin: 20,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true
  });
  $('.play').on('click', function () {
    owl.trigger('play.owl.autoplay', [1000])
  })
  $('.stop').on('click', function () {
    owl.trigger('stop.owl.autoplay')
  })
});
