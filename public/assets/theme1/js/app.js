new WOW({
    mobile: true,
    live: true,
}).init();

$(function() {

    let width = $(window).width();

    /*** .home-slide ***/
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
    })

    /*** .categories-swiper ***/
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
    })

    /*** .popular-foods-swiper ***/
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
                slidesPerView: 5,
                slidesPerGroup: 5,
                spaceBetween: 0,
                grid: {
                    rows: 2,
                },
            },
        },
    })

    /*** .user-comments-swiper ***/
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
    })

    /*** select2 ***/
    // $('.select2').select2({
    //     language: "tr",
    //     placeholder: 'Person'
    // });

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
    // $('#date').datetimepicker({
    //     format: 'DD/MM/YYYY',
    //     // locale: moment.locale('tr'),
    //     icons: datetimepickerIcons
    // });

    // $('#time').datetimepicker({
    //     format: 'LT',
    //     // locale: moment.locale('tr'),
    //     icons: datetimepickerIcons
    // });

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
    // $(window).on('scroll', (e) => {
    //     if (window.scrollY > 200) {
    //         if (!$('body').hasClass('fixed-menu')) {
    //             $('body').addClass('fixed-menu')
    //         }
    //     } else {
    //         if ($('body').hasClass('fixed-menu')) {
    //             $('body').removeClass('fixed-menu')
    //         }
    //     }
    // })

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
