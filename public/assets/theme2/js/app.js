new WOW({
    mobile: true,
    live: true,
}).init();

$(function() {

    let width = $(window).width();

    /*** .home-slide ***/


    /*** .about-us-swiper ***/


    /*** .popular-foods-v2 ***/
    let popularFoodsV2Swiper = new Swiper(".popular-foods-swiper-v2 .swiper", {
        slidesPerView: 2,
        spaceBetween: 50,
        speed: 500,
        loop: true,
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
    })

    /*** .categories-swiper-v2 ***/


    /*** .user-comments-v2-swiper ***/
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
