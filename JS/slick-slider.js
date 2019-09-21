$(document).ready(function(){
    $('.slider').slick({
        dots: false,
        prevArrow: false,
        nextArrow: false,
            autoplay: true,
            autoplaySpeed: 5000,
            pauseOnFocus: false,
            pauseOnHover: false,
            pauseOnDotsHover: false,
            slidesToShow: 1,
            fade: true,
            cssEase: 'linear'
      });
});