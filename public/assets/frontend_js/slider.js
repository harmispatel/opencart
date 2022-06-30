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
    });

    homeSlideV3Swiper.on('slideChange', function(event) {
        homeSlideV3SwiperTextChange(event)
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
    // ------------------------------------------------------------------------------------------------------



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
    // ------------------------------------------------------------------------------------------------------



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


    // CATEGORY 5 JS
    let bestCategoriesV5SlideCategory = new Swiper(".best-categories-v5-swiper .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 500,
        loop: false,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".best-categories-v5-swiper-control .swiper-button-next",
            prevEl: ".best-categories-v5-swiper-control .swiper-button-prev"
        },
        scrollbar: {
            el: ".best-categories-v5-swiper-control .swiper-scrollbar",
            hide: false,
        },
        pagination: {
            el: ".best-categories-v5-swiper-control .swiper-pagination",
            type: "fraction",
        },
        mousewheel: false,
        keyboard: false,
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        },
    });


    // CATEGORY 6 JS
    let popularCategoriesV6SlideCategory = new Swiper(".popular-categories-v6-swiper .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 500,
        loop: false,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: ".popular-categories-v6-swiper .swiper-pagination",
            dynamicBullets: true,
        },
        mousewheel: false,
        keyboard: false,
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            450: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
        },
    });

    $(".popular-categories-v6-swiper .__btn-list a").on("click", function(e) {
        var filter = $(this).data("filter");
        $(".popular-categories-v6-swiper .__btn-list a").removeClass("active");
        $(this).addClass("active");

        if (filter == "all") {
            $(".best-categories-v6-swiper [data-slide-filter]").removeClass("non-swiper-slide d-none").addClass("swiper-slide").show();
            popularCategoriesV6SlideCategory.destroy();
            popularCategoriesV6SlideCategory = new Swiper(".popular-categories-v6-swiper .swiper", {
                slidesPerView: 1,
                spaceBetween: 0,
                speed: 500,
                loop: false,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: ".popular-categories-v6-swiper .swiper-pagination",
                    dynamicBullets: true,
                },
                mousewheel: false,
                keyboard: false,
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    450: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 20,
                    },
                },
            })
        } else {
            $(".popular-categories-v6-swiper .swiper-slide").not("[data-slide-filter='" + filter + "']").addClass("non-swiper-slide d-none").removeClass("swiper-slide");
            $(".popular-categories-v6-swiper [data-slide-filter='" + filter + "']").removeClass("non-swiper-slide d-none").addClass("swiper-slide").attr("style", null);
            popularCategoriesV6SlideCategory.destroy();
            popularCategoriesV6SlideCategory = new Swiper(".popular-categories-v6-swiper .swiper", {
                slidesPerView: 1,
                spaceBetween: 0,
                speed: 500,
                loop: true,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: ".popular-categories-v6-swiper .swiper-pagination",
                    dynamicBullets: true,
                },
                mousewheel: false,
                keyboard: false,
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    450: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 20,
                    },
                },
            })
        }

        e.preventDefault()
    });
    // ------------------------------------------------------------------------------------------------------



    // POPULAR FOOD 1 JS
    let popularFoodsSwiper = new Swiper(".popular-foods-swiper .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 500,
        loop: false,
        // autoplay: {
        //     delay: 3000,
        //     disableOnInteraction: false,
        //     pauseOnMouseEnter: true
        // },
        mousewheel: false,
        keyboard: false,
        pagination: {
            el: ".popular-foods-swiper .swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                slidesPerGroup: 2,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 3,
                slidesPerGroup: 3,
                spaceBetween: 0,
                grid: {
                    rows: 2,
                },
            },
            1024: {
                slidesPerView: 4,
                slidesPerGroup: 5,
                spaceBetween: 0,
                grid: {
                    rows: 2,
                },
            },
        },
    });


    // POPULAR FOOD 2 JS
    let popularFoodsV2Swiper = new Swiper(".popular-foods-swiper-v2 .swiper", {
        slidesPerView: 2,
        spaceBetween: 50,
        speed: 500,
        loop: false,
        autoplay: {
            delay: 3000,
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
            el: ".popular-foods-swiper-v2 .swiper-pagination",
            clickable: true,
        },
    });


    // POPULAR FOOD 5 JS
    let popularFoodsV5SlideCategory = new Swiper(".popular-foods-v5-swiper .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 500,
        loop: false,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".popular-foods-v5-swiper-control .swiper-button-next",
            prevEl: ".popular-foods-v5-swiper-control .swiper-button-prev"
        },
        scrollbar: {
            el: ".popular-foods-v5-swiper-control .swiper-scrollbar",
            hide: false,
        },
        pagination: {
            el: ".popular-foods-v5-swiper-control .swiper-pagination",
            type: "fraction",
        },
        mousewheel: false,
        keyboard: false,
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        },
    });
    //-------------------------------------------------------------------------------------------------------



    // REVIEWS 1 JS
    let userCommentsSlideSwiper = new Swiper(".user-comments-swiper .swiper", {
        spaceBetween: 0,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: ".user-comments-swiper .swiper-pagination",
            clickable: true,
        },
        mousewheel: false,
        keyboard: false,
    });


    // REVIEWS 2 JS
    let userCommentsV2SlideSwiper = new Swiper(".user-comments-v2-swiper .swiper", {
        spaceBetween: 0,
        speed: 500,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        centeredSlides: true,
        pagination: {
            el: ".user-comments-v2-swiper .swiper-pagination",
            clickable: true,
        },
        mousewheel: false,
        keyboard: false,
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            991: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1199: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
        },
    });




    // REVIEWS 3 JS
    let userCommentsV3SlideSwiper = new Swiper(".user-comments-v3-swiper .swiper", {
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
    })



    // Reviews 4 JS
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


    // REVIEWS 5 JS
    let userCommentsV5SlideSwiper = new Swiper(".user-comments-v5-swiper .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 500,
        loop: false,
        loopFillGroupWithBlank: false,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        scrollbar: {
            el: ".user-comments-v5-swiper-control .swiper-scrollbar",
            hide: false,
        },
        pagination: {
            el: ".user-comments-v5-swiper-control .swiper-pagination",
            type: "fraction",
        },
        mousewheel: false,
        keyboard: false,
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 0,
                slidesPerGroup: 1,
                grid: {
                    rows: 1,
                },
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
                slidesPerGroup: 2,
                grid: {
                    rows: 2,
                },
            },
            1024: {
                slidesPerView: 3,
                slidesPerGroup: 3,
                spaceBetween: 20,
                grid: {
                    rows: 2,
                },
            },
        },
    });


    // REVIEWS 6 JS
    let userCommentsV6SlideSwiper = new Swiper(".user-comments-v6-swiper .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 500,
        loop: false,
        loopFillGroupWithBlank: false,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: ".user-comments-v6-swiper .swiper-pagination",
            clickable: true,
        },
        mousewheel: false,
        keyboard: false,
    });
    // ------------------------------------------------------------------------------------------------------



    // GALLARY 5 JS
    let photoGalleryV5Slide = new Swiper(".photo-gallery-v5 .swiper", {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 500,
        loop: false,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        },
        navigation: {
            nextEl: ".photo-gallery-v5-swiper-control .swiper-button-next",
            prevEl: ".photo-gallery-v5-swiper-control .swiper-button-prev"
        },
        scrollbar: {
            el: ".user-comments-v5-swiper-info .swiper-scrollbar",
            hide: false,
        },
        pagination: {
            el: ".user-comments-v5-swiper-info .swiper-pagination",
            type: "fraction",
        },
        mousewheel: false,
        keyboard: false,
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    })

});
