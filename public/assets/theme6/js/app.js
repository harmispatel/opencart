new WOW({
    mobile: true,
    live: true,
}).init();

$(function () {

    let width = $(window).width();

    /*** .home-slide-v6-swiper ***/
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
    })

    /*** .home-slide-category ***/
    let homeSlideCategory = new Swiper(".home-slide-category .swiper", {
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
            nextEl: ".home-slide-category .swiper-button-next",
            prevEl: ".home-slide-category .swiper-button-prev"
        },
        mousewheel: false,
        keyboard: false,
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            1024: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1700: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    })

    /*** .popular-categories-v6-swiper***/
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
    })

    $(".popular-categories-v6-swiper .__btn-list a").on("click", function(e){
        var filter = $(this).data("filter");
        $(".popular-categories-v6-swiper .__btn-list a").removeClass("active");
        $(this).addClass("active");

        if(filter=="all"){
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
        }
        else {
            $(".popular-categories-v6-swiper .swiper-slide").not("[data-slide-filter='"+filter+"']").addClass("non-swiper-slide d-none").removeClass("swiper-slide");
            $(".popular-categories-v6-swiper [data-slide-filter='"+filter+"']").removeClass("non-swiper-slide d-none").addClass("swiper-slide").attr("style", null);
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
        }

        e.preventDefault()
    })

    /*** .user-comments-v6-swiper ***/
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
    })

    /*** select2 ***/
    $('.select2').select2({
        language: "tr",
        placeholder: 'Person'
    });

    /*** datetimepickerIcons ***/
    const datetimepickerIcons = {
        time: 'far fa-clock',
        date: 'far fa-calendar',
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'fas fa-calendar-day',
        clear: 'far fa-trash-alt',
        close: 'far fa-times-circle'
    }

    /*** datetimepicker ***/
    $('#date').datetimepicker({
        sideBySide: true,
        locale: moment.locale('tr'),
        icons: datetimepickerIcons
    });

    /*** Fancybox ***/
    Fancybox.bind("[data-fancybox]", {});

    /*** Go Up Animate Scroll Js ***/
    $('#go-up').on('click', function (e) {
        $("html, body").animate({scrollTop: $('body').offset().top, easing: "smooth"}, 300);
        e.preventDefault();
    })

    $(window).on('scroll', (e) => {
        if (window.scrollY > (window.innerHeight / 3)) {
            if (!$('#go-up').hasClass('active')) {
                $('#go-up').addClass('active')
            }
        } else {
            if ($('#go-up').hasClass('active')) {
                $('#go-up').removeClass('active')
            }
        }
    })

    /*** Fixed Menu Js ***/
    $(window).on('scroll', (e) => {
        if (window.scrollY > 200) {
            if (!$('body').hasClass('fixed-menu')) {
                $('body').addClass('fixed-menu')
            }
        } else {
            if ($('body').hasClass('fixed-menu')) {
                $('body').removeClass('fixed-menu')
            }
        }
    })

    /*** Mobile Menu Toggle ***/
    const mobileMenu = $('sidebar.mobile-menu')
    const mobileMenuToggleOpen = $('.open-mobile-menu')
    const mobileMenuToggleClose = $('sidebar.mobile-menu .close')
    const mobileMenuShadow = $('.mobile-menu-shadow')

    mobileMenuToggleOpen.click((e) => {
        e.preventDefault()
        mobileMenu.addClass('active')
        mobileMenuShadow.addClass('active')
    })

    mobileMenuToggleClose.click((e) => {
        e.preventDefault()
        mobileMenu.removeClass('active')
        mobileMenuShadow.removeClass('active')
    })

    $(window).resize(function () {
        width = $(window).width();
    })

})
