new WOW({
    mobile: true,
    live: true,
}).init();

$(function() {

    let width = $(window).width();


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
