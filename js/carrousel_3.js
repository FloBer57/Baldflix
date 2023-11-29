$('.box-films').slick({
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 5,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 3,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 800,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 450,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});