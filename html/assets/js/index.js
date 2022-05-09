$(function () {
  $("#btn-hamburger").on("click", function () {
    $(".menu-aside-page").toggleClass("show");
    $("body").addClass("overflow-hidden");
  });

  $(".backdrop , .menu-aside-close").on("click", function () {
    $(".menu-aside-page").removeClass("show");
    $("body").removeClass("overflow-hidden");
  });
});

$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  if (scroll >= 10) {
    $(".sidebar-pc").sticky({ topSpacing: 80, bottomSpacing: 135 });
  }
    // $(".header-page").addClass("box-shadow fixed-top");
  // } else {
  //   $(".header-page").removeClass("box-shadow fixed-top");
  // }
});

$(function () {
  $('.js-example-basic-single').select2();

  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 2,
    spaceBetween: 30,
    loop: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
})