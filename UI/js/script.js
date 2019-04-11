$(document).ready(function () {
  $(".menu-toggle").click(function () {
    $("nav").toggleClass("active");
  });
  let items = 3;
  if(window.screen.width < 500){
    items = 2;
  }
  var owl = $('.owl-carousel');
  owl.owlCarousel({
    items,
    loop: true,
    margin: 20,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true
  });
  $('.play').on('click', function () {
    owl.trigger('play.owl.autoplay', [1000])
  })
  $('.stop').on('click', function () {
    owl.trigger('stop.owl.autoplay')
  })
});
