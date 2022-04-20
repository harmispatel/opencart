new WOW({
    mobile: true,
    live: true,
}).init();

$(function() {

    let width = $(window).width();

    /*** .home-slide-v5 ***/
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

    /*** .best-categories-v5-swiper***/
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
    })

    /*** .popular-foods-v5-swiper***/
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
    })

    /*** .user-comments-v5-swiper ***/
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
    })

    /*** .photo-gallery-v5***/
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
        format: 'DD/MM/YYYY',
        // locale: moment.locale('tr'),
        icons: datetimepickerIcons
    });

    $('#time').datetimepicker({
        format: 'LT',
        // locale: moment.locale('tr'),
        icons: datetimepickerIcons
    });

    /*** Fancybox ***/
    Fancybox.bind("[data-fancybox]", {});

    /*** Go Up Animate Scroll Js ***/
    $('#go-up').on('click', function(e) {
        $("html, body").animate({ scrollTop: $('body').offset().top, easing: "smooth" }, 300);
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

    $(window).resize(function() {
        width = $(window).width();
    })

})
