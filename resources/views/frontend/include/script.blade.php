<!--
    THIS IS SCRIPT PAGE FOR FRONTEND JS
    ----------------------------------------------------------------------------------------------
    script.blade.php
    It's Included Some JS Links with diffrent themes.
    it is used for including Javscript Libraries.
    ----------------------------------------------------------------------------------------------
-->


@php

    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = layoutID($currentURL,'header_id');
    $theme_id = $current_theme_id['header_id'];
    $front_store_id =  $current_theme_id['store_id'];
    // // Get Current Theme ID & Store ID

    // Get Store Settings & Theme Settings
    // $store_theme_settings = storeThemeSettings($theme_id,$front_store_id);
    //End Get Store Settings & Theme Settings

@endphp



<!--Js Files-->
    <script src="{{ get_css_url().'public/assets/js/jquery_v3.min.js' }}"></script>
    <script src="{{  get_css_url().'public/assets/frontend_js/slider.js' }}"></script>

    <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/moment/min/moment.min.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/plugins/moment/min/moment.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/plugins/moment/min/moment.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/plugins/moment/min/moment.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/plugins/moment/min/moment.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/plugins/moment/min/moment.min.js' }}"></script> --}}


        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/moment/min/locales.min.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/plugins/moment/min/locales.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/plugins/moment/min/locales.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/plugins/moment/min/locales.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/plugins/moment/min/locales.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/plugins/moment/min/locales.min.js' }}"></script> --}}


        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/bootstrap/dist/js/bootstrap.min.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/plugins/bootstrap/dist/js/bootstrap.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/plugins/bootstrap/dist/js/bootstrap.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/plugins/bootstrap/dist/js/bootstrap.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/plugins/bootstrap/dist/js/bootstrap.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/plugins/bootstrap/dist/js/bootstrap.min.js' }}"></script> --}}


        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js' }}"></script> --}}


        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/wow/dist/wow.min.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/plugins/wow/dist/wow.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/plugins/wow/dist/wow.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/plugins/wow/dist/wow.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/plugins/wow/dist/wow.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/plugins/wow/dist/wow.min.js' }}"></script> --}}


        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/swiper-js/swiper-bundle.min.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/plugins/swiper-js/swiper-bundle.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/plugins/swiper-js/swiper-bundle.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/plugins/swiper-js/swiper-bundle.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/plugins/swiper-js/swiper-bundle.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/plugins/swiper-js/swiper-bundle.min.js' }}"></script> --}}


        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/ui/dist/fancybox.umd.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/plugins/ui/dist/fancybox.umd.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/plugins/ui/dist/fancybox.umd.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/plugins/ui/dist/fancybox.umd.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/plugins/ui/dist/fancybox.umd.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/plugins/ui/dist/fancybox.umd.js' }}"></script> --}}


        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/select2/dist/js/select2.min.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/plugins/select2/dist/js/select2.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/plugins/select2/dist/js/select2.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/plugins/select2/dist/js/select2.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/plugins/select2/dist/js/select2.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/plugins/select2/dist/js/select2.min.js' }}"></script> --}}


        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/select2/dist/js/i18n/tr.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/plugins/select2/dist/js/i18n/tr.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/plugins/select2/dist/js/i18n/tr.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/plugins/select2/dist/js/i18n/tr.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/plugins/select2/dist/js/i18n/tr.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/plugins/select2/dist/js/i18n/tr.js' }}"></script> --}}


        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/js/app.js' }}"></script>
        {{-- <script type="text/javascript" src="{{ get_css_url().'public/assets/theme2/js/app.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme3/js/app.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme4/js/app.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme5/js/app.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme6/js/app.js' }}"></script> --}}


   {{-- @else
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/jquery/dist/jquery.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/moment/min/moment.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/moment/min/locales.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/bootstrap/dist/js/bootstrap.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/wow/dist/wow.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/swiper-js/swiper-bundle.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/ui/dist/fancybox.umd.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/select2/dist/js/select2.min.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/plugins/select2/dist/js/i18n/tr.js' }}"></script>
        <script type="text/javascript" src="{{ get_css_url().'public/assets/theme1/js/app.js' }}"></script>
   @endif --}}
<script src="{{ get_css_url().'public/plugins/jquery-ui/jquery-ui.min.js' }}"></script>
<!-- End Js Files-->


<!-- Custom Script -->
<script type="text/javascript">


    // Function For Show More Description
    function ShowMoreDescription()
    {
        $('#shopDescription').css({"height":"","overflow":"none"});
        $('#readmore').hide();
        $('#readless').show();
    }
    // End Function For Show More Description


    // Function For Hide More Description
    function HideMoreDescription()
    {
        $('#shopDescription').css({"height":"300px","overflow":"hidden"});
        $('#readmore').show();
        $('#readless').hide();
    }
    // End Function For Hide More Description


    // Document Script
    $(document).ready(function()
    {
        // Collection & Delivery Button
        $('.collection_delivery_button').click(function()
        {
            var delCheckout = $(this).attr('delCheckout');

            var redirect_url = $(this).attr('uriFrom');
            var type = $(this).attr('typeAttr');
            var menuredirecturl = location.href + 'menu';

            if(delCheckout == 1)
            {
                $.ajax({
                    type: "POST",
                    url: "{{ url('checkZipCode') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        'delCheckout' : delCheckout,
                    },
                    dataType: "json",
                    success: function (response)
                    {
                        if(response.success == 1)
                        {
                            location.reload();
                        }
                    }
                });
                return false;
            }

            if(type == 'collection')
            {
                $.ajax({
                    type: "POST",
                    url: "{{ url('checkZipCode') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        'type' : type,
                    },
                    dataType: "json",
                    success: function (response)
                    {
                        if(response.success == 1)
                        {
                            if(response.checkout_type == 'collection')
                            {
                                if(redirect_url == 'home')
                                {
                                    window.location = menuredirecturl;
                                }
                                else
                                {
                                    location.reload();
                                }
                            }
                        }
                    }
                });
            }
            else if(type == 'delivery')
            {
                $('#search_result1').css('display','none');

                // Get Delivery Option
                var delivery_option = $(this).attr('delOpt');

                // Get Post Code or Area Name
                if(delivery_option == 'areaname')
                {
                    var keyword = $('select[name=search_input2] option').filter(':selected').val();
                }
                else
                {
                    var keyword = $('#search_input1').val().trim();
                }

                if(keyword == '')
                {
                    $('div.enter_postcode p').addClass('postcode-error');
                    $('#loading_icon1').css('display','none');
                    $('#search_input1').addClass('postcode-input-error');
                    $('#search_store').addClass('postcode-input-error');
                    return false;

                }
                else
                {
                    $('div.enter_postcode p').removeClass('postcode-error');
                    $('#loading_icon1').css('display','block');
                    $('#search_input1').removeClass('postcode-input-error');
                    $('#search_store').removeClass('postcode-input-error');

                    $.ajax({
                        type: "POST",
                        url: "{{ url('checkZipCode') }}",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            'type' : type,
                            'delivery_option': delivery_option,
                            'keyword': keyword,
                        },
                        dataType: "json",
                        success: function (response)
                        {
                            if(response.success == 1)
                            {
                                $('#loading_icon1').css('display','none');

                                if(response.checkout_type == 'delivery')
                                {
                                    if(redirect_url == 'home')
                                    {
                                        window.location = menuredirecturl;
                                    }
                                    else
                                    {
                                        location.reload();
                                    }
                                }
                            }

                            if(response.error == 1)
                            {
                                $('#loading_icon1').css('display','none');
                                $('#search_result1').html('');
                                $('#search_result1').html(response.message);
                                $('#search_result1').css('display','block');
                                $('.store_list').css('color','red');
                                $('div.enter_postcode p').css('display','none');
                                $('.store_list').removeClass('wrap_row');

                                setTimeout(function ()
                                {
                                    $('div.enter_postcode p').css('display','block');
                                    $('#search_result1').css('display','none');
                                    $('#search_input1').val('');
                                }, 7000);
                            }
                        }
                    });

                }

            }


        });
        // End Collection & Delivery Button


        // Auto Complete for Postcode
        $('#search_input1').autocomplete({
            delay: 200,
            minLength: 2,
            source: function(request, response)
            {
                $('span.wait').remove();
                $.ajax({
                    type : 'POST',
                    url: '{{ url("postcodes") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "keyword" : $('#search_input1').val(),
                    },
                    dataType: 'json',
                    beforeSend: function()
                    {
                        $('#loading_icon1').css('display','block');
                    },
                    success: function(json)
                    {
                        $('#loading_icon1').css('display','none');
                        $('#search_result1').css('display','none');

                        if(json.success)
                        {
                            response($.map(json.postcodes, function(item)
                            {
                                return{
                                    label: item.Postcode,
                                    value: item.Postcode,
                                }
                            }));
                        }

                        if(json.error)
                        {
                            $('.ui-autocomplete').hide();
                            $('.input-xlarge.focused').attr('style','border:1px solid red !important');
                            $('#search_result1').html(json.error);
                            $('#search_result1').css('display','block');

                            $('.store_list').css('color','red');
                            $('div.enter_postcode p').css('display','none');
                            $('.store_list').removeClass('wrap_row');
                            setTimeout(function ()
                            {
                                $('div.enter_postcode p').css('display','block');
                                $('#search_result1').css('display','none');
                            }, 5000);
                        }
                    }
                });
            },
            select: function(event, ui)
            {
                $('input#search_input1').attr('value', ui.item['value']);
            },
        });
        // End Auto Complete for Postcode


        // Customer Register
        $('#register').on('click',function()
        {
            var form_data = new FormData(document.getElementById('registerform'));

            $.ajax({
                type: "POST",
                url: "{{ url('customerregister') }}",
                data: form_data,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response)
                {
                    if(response.status == 1)
                    {
                        location.reload();
                    }
                },
                error : function (message)
                {
                    var cust_title = message.responseJSON.errors.title;
                    var name = message.responseJSON.errors.firstname;
                    var lastname = message.responseJSON.errors.lastname;
                    var e_mail = message.responseJSON.errors.email;
                    var phone_no = message.responseJSON.errors.phone;
                    var pass = message.responseJSON.errors.password;
                    var confirmpassword = message.responseJSON.errors.confirm_password;

                    // Title
                    if(cust_title)
                    {
                        $('#titleerr').text('').show();
                        $('#titleerr').text(cust_title);
                    }
                    else
                    {
                        $('#titleerr').text('').hide();
                        $('#title').attr('class','form-control');
                    }
                    // End Title

                    // FirstName
                    if(name)
                    {
                        $('#fnameerr').text('').show();
                        $('#fnameerr').text(name);
                    }
                    else
                    {
                        $('#fnameerr').text('').hide();
                        $('#firstname').attr('class','form-control');
                    }
                    // End Firstname

                    // LastName
                    if(lastname)
                    {
                        $('#lastnameerr').text('').show();
                        $('#lastnameerr').text(lastname);
                    }
                    else
                    {
                        $('#lastnameerr').text('').hide();
                        $('#lastname').attr('class','form-control');
                    }
                    // End Lastname

                    // Email
                    if(e_mail)
                    {
                        $('#emailerr').text('').show();
                        $('#emailerr').text(e_mail);
                    }
                    else
                    {
                        $('#emailerr').text('').hide();
                        $('#email').attr('class','form-control');
                    }
                    // End Email

                    // Phone
                    if(phone_no)
                    {
                        $('#phoneerr').text('').show();
                        $('#phoneerr').text(phone_no);
                    }
                    else
                    {
                        $('#phoneerr').text('').hide();
                        $('#phone').attr('class','form-control');
                    }
                    // End Phone

                    // Password
                    if(pass)
                    {
                        $('#passworderr').text('').show();
                        $('#passworderr').text(pass);
                    }
                    else
                    {
                        $('#passworderr').text('').hide();
                        $('#password').attr('class','form-control');
                    }
                    // End Password

                    // Confirm Password
                    if(confirmpassword)
                    {
                        $('#confirmpassworderr').text('').show();
                        $('#confirmpassworderr').text(confirmpassword);
                    }
                    else
                    {
                        $('#confirmpassworderr').text('').hide();
                        $('#confirmpassword').attr('class','form-control');
                    }
                    // End Confirm Password
                }
            });
        });
        // Customer Register

    });
    // End Document script


    // Customer Login
    $('#loginform').on('click',function(e)
    {
        e.preventDefault();
        var login_data = new FormData(document.getElementById('userlogin'));

        $.ajax({
            type: "POST",
            url: "{{ url('customerlogin') }}",
            data: login_data,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response)
            {
                if (response.status == 0)
                {
                    $('#loginerr').html('<div class="alert alert-sm alert-warning alert-dismissible fade show" role="alert"><strong>Warning!</strong> No match for E-Mail Address and/or Password.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                }
                else
                {
                    location.reload();
                }
            },
            error : function (message)
            {
                var e_mail = message.responseJSON.errors.Email;
                var pass = message.responseJSON.errors.Password;

                // Email
                if(e_mail)
                {
                    $('#loginemailerr').text('').show();
                    $('#loginemail').addClass('is-invalid');
                    $('#loginemailerr').text(e_mail).show();
                }
                else
                {
                    $('#loginemailerr').text('').hide();
                    $('#loginemail').attr('class','form-control');
                }
                // End Email

                // Password
                if(pass)
                {
                    $('#loginpassworderr').text('').show();
                    $('#loginpassword').addClass('is-invalid');
                    $('#loginpassworderr').text(pass).show();
                }
                else
                {
                    $('#loginpassworderr').text('').hide();
                    $('#loginpassword').attr('class','form-control');
                }
                // End Password
            }
        });
    });
    // End Customer Login


    // UpdateCart
    function updateCart(oType)
    {
        $.ajax({
            type: "post",
            url: "{{ route('updatecart')}}",
            dataType: "json",
            data:
            {
                "_token": "{{ csrf_token() }}",
                'ordertype': oType,
            },
            success: function (response)
            {
                $('.empty-box').html('');
                $('.empty-box').html(response.cart_products);

                // Sub Total
                $('.sub-total').html('');
                $('.sub-total').append(response.subtotal);

                // Total
                $('.total').html('');
                $('.total').append(response.total);

                // Total 2
                $('#total_pay').html('');
                $('#total_pay').append(response.total_2);

                // Header Total
                $('.pirce-value').text('');
                $('.pirce-value').append(response.headertotal);

                // Delivery Charge
                $('.del-charge').html('');
                $('.del-charge').append(response.delivery_charge);


                if (response.couponcode_name != '' && response.couponcode_amount != '')
                {
                    $('.coupon_code').html('');
                    $('.coupon_code').css('display','block');
                    $('.coupon_code').html('<label id="coupontext">Coupon('+ response.couponcode_name +')</label><span>-'+ response.couponcode_amount +'</span>');
                }
                else
                {
                    $('.addnewcoupon').css('display','block');
                }
            }
        });
    }


</script>
<!-- End Custom Script -->



