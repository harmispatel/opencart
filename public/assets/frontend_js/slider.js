$(function() {

    let width = $(window).width();

    // SLIDER 1 JS
    let homeSlideSwiper = new Swiper(".home-slide .swiper", {
        spaceBetween: 0,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".home-slide .swiper .swiper-button-next",
            prevEl: ".home-slide .swiper .swiper-button-prev"
        },
        mousewheel: false,
        keyboard: false,
    });



    //SLIDER 2 JS
    let homeSlideV2Swiper = new Swiper(".home-slide-v2.swiper", {
        spaceBetween: 0,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".home-slide-v2 .swiper-button-next",
            prevEl: ".home-slide-v2 .swiper-button-prev"
        },
        mousewheel: false,
        keyboard: false,
    });



    // SLIDER 3 JS
    const homeSlideV3SwiperTextChange = (event) => {
        let element = $(event.slides[event.activeIndex]),
            targetTitleElement = $('.home-slide-v3 .swiper-text-content strong'),
            targetTextElement = $('.home-slide-v3 .swiper-text-content p'),
            titleValue = element.data('title'),
            textValue = element.data('text');

        targetTitleElement.html(titleValue)
        targetTextElement.html(textValue)
    }

    let homeSlideV3Swiper = new Swiper(".home-slide-v3 .swiper", {
        spaceBetween: 0,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".home-slide-v3 .swiper-button-next",
            prevEl: ".home-slide-v3 .swiper-button-prev"
        },
        mousewheel: false,
        keyboard: false,
        on: {
            init: function(event) {
                homeSlideV3SwiperTextChange(event)
            },
        },
    })

    homeSlideV3Swiper.on('slideChange', function(event) {
        homeSlideV3SwiperTextChange(event)
    });

    let userCommentsV2SlideSwiper = new Swiper(".user-comments-v3-swiper .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".user-comments-v3-swiper .swiper-button-next",
            prevEl: ".user-comments-v3-swiper .swiper-button-prev"
        },
        pagination: {
            el: ".user-comments-v3-swiper .swiper-pagination",
            clickable: true,
        },
        mousewheel: false,
        keyboard: false,
    });



    // SLIDER 4 JS
    const homeSlideV3SwiperChange = (event) => {
        $('.__thumbs-item a').removeClass('active')
        $('.__thumbs-item a').eq(event.activeIndex).addClass('active')
    }

    let homeSlideV4Swiper = new Swiper(".home-slide-v4 .swiper", {
        spaceBetween: 0,
        speed: 500,
        loop: false,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        effect: "fade",
        mousewheel: false,
        keyboard: false,
        on: {
            init: function(event) {
                homeSlideV3SwiperChange(event)
            },
        },
    });

    homeSlideV4Swiper.on('slideChange', function(event) {
        homeSlideV3SwiperChange(event)
    });

    $('.__thumbs-item a').click(function(event) {
        event.preventDefault()
        homeSlideV4Swiper.slideTo($(this).data('index'))
    });

    let userCommentsV4SlideSwiper = new Swiper(".user-comments-v4-swiper .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".user-comments-v4-swiper .swiper-button-next",
            prevEl: ".user-comments-v4-swiper .swiper-button-prev"
        },
        mousewheel: false,
        keyboard: false,
    });



    // SLIDER 5 JS
    let homeSlideV5Swiper = new Swiper(".home-slide-v5-swiper.swiper", {
        spaceBetween: 0,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        mousewheel: false,
        keyboard: false,
    });



    // SLIDER 6 JS
    let homeSlideV6Swiper = new Swiper(".home-slide-v6-swiper .swiper", {
        spaceBetween: 0,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        mousewheel: false,
        keyboard: false,
    });


    // ABOUT US 2 JS
    let aboutUsSlideSwiper = new Swiper(".about-us-swiper.swiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".about-us-swiper .swiper-button-next",
            prevEl: ".about-us-swiper .swiper-button-prev"
        },
        mousewheel: false,
        keyboard: false,
    });




    // CATEGORY 1 JS
    let bestCategoriesSwiper = new Swiper(".categories-swiper .swiper", {
        slidesPerView: 1,
        spaceBetween: 10,
        speed: 500,
        loop: false,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".categories-swiper .swiper-button-next",
            prevEl: ".categories-swiper .swiper-button-prev"
        },
        mousewheel: false,
        keyboard: false,
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            991: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
            1199: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
        },
    });


    // CATEGORY 2 JS
    let bestCategoriesV2Swiper = new Swiper(".categories-swiper-v2 .swiper", {
        slidesPerView: 2,
        spaceBetween: 50,
        speed: 500,
        loop: false,
        autoplay: {
            delay: 10000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        mousewheel: false,
        keyboard: false,
        breakpoints: {
            0: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            991: {
                slidesPerView: 4,
                spaceBetween: 40,
            },
            1199: {
                slidesPerView: 5,
                spaceBetween: 50,
            },
        },
        pagination: {
            el: ".categories-swiper-v2 .swiper-pagination",
            clickable: true,
        },
    });

});
