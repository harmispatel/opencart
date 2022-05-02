@php
    if(session()->has('theme_id'))
    {
        $theme_id = session()->get('theme_id');
    }
    else
    {
        $theme_id = 1;
    }
@endphp

<!--Js Files-->
   @if (!empty($theme_id) || $theme_id != '')
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/moment/min/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/moment/min/locales.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/wow/dist/wow.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/swiper-js/swiper-bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/ui/dist/fancybox.umd.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/select2/dist/js/i18n/tr.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/js/app.js') }}"></script>
   @else
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/moment/min/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/moment/min/locales.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/wow/dist/wow.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/swiper-js/swiper-bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/ui/dist/fancybox.umd.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/select2/dist/js/i18n/tr.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/js/app.js') }}"></script>
   @endif
<!--Js Files-->

<script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script>
    function ShowMoreDescription()
    {
        $('#shopDescription').css({"height":"","overflow":"none"});
        $('#readmore').hide();
        $('#readless').show();
    }

    function HideMoreDescription()
    {
        $('#shopDescription').css({"height":"300px","overflow":"hidden"});
        $('#readmore').show();
        $('#readless').hide();
    }
</script>

<script>
    $(document).ready(function()
    {
        $('.collection_button1').click(function()
        {
            var catpath = location.href + 'menu';
            window.location = catpath;
        });

        $('.delivery_button1').click(function()
        {
            $('#search_result1').css('display','none');

            var keyword = $('#search_input1').val() == undefined ? $('select[name=search_input2] option').filter(':selected').val() : $('#search_input1').val().trim();

            var checkbox = 1;

            if((keyword.length > 0) || (checkbox == 0))
            {
                $('#search_input1').removeClass('postcode-input-error');
                $('div.enter_postcode p').removeClass('postcode-error');
                $('#loading_icon1').css('display','block');

                $.ajax({
                    type: "POST",
                    url: "{{ url('checkZipCode') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'keyword' : keyword,
                        'checkbox' : checkbox,
                    },
                    dataType: "json",
                    success: function (data)
                    {
                        if($('.store_list').length > 0)
                            $('.store_list').remove();
                        $('#loading_icon1').css('display','none');

                        if(data.success != 'EXIST')
                        {
                            $('#search_result1').html(data.error);
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
                        else
                        {
                            var catpath = location.href + 'menu';
                            window.location = catpath;
                        }

                    },
                    error: function()
                    {
                        $('#search_result1').css('display','none');
                        $('#loading_icon1').css('display','none');

                        $('.store_list').css('color','red');
                        $('div.enter_postcode p').css('display','none');
                        $('.store_list').removeClass('wrap_row');
                    }
                });

            }
            else
            {
                $('div.enter_postcode p').addClass('postcode-error');
                $('#loading_icon1').css('display','none');
                    if($('.store_list').length > 0)
                    $('.store_list').remove();
                if(keyword.length <= 0)
                {
                    $('#search_input1').addClass('postcode-input-error');
                }
            }

        });


        // Auto Complete
        $('#search_input1').autocomplete({
            delay: 500,
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
                                return {
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
                // return false;
            },
        });


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
            success: function (response) {
                location.reload();
                // $('#registerform').trigger('reset');
                // $('#login').modal('hide');
                // alert('Login Success');
                // console.log(response);



            },
            error : function (message) {
                console.log(message.responseJSON.errors);
                var cust_title = message.responseJSON.errors.title;
                var name = message.responseJSON.errors.name;
                var surname = message.responseJSON.errors.surname;
                var e_mail = message.responseJSON.errors.email;
                var phone_no = message.responseJSON.errors.phone;
                var pass = message.responseJSON.errors.password;
                var confirmpassword = message.responseJSON.errors.confirmpassword;


                // FirstName
                if(cust_title)
                {
                    $('#titleerr').text('').show();
                    $('#title').attr('class','form-control is-invalid');
                    $('#titleerr').text(cust_title);
                }
                else
                {
                    $('#titleerr').text('').hide();
                    $('#title').attr('class','form-control');
                }

                // FirstName
                if(name)
                {
                    $('#fnameerr').text('').show();
                    $('#name').attr('class','form-control is-invalid');
                    $('#fnameerr').text(name);
                }
                else
                {
                    $('#fnameerr').text('').hide();
                    $('#firstname').attr('class','form-control');
                }

                // LastName
                if(surname)
                {
                    $('#surnameerr').text('').show();
                    $('#surname').addClass('is-invalid');
                    $('#surnameerr').text(surname).show();
                }
                else
                {
                    $('#surnameerr').text('').hide();
                    $('#surname').attr('class','form-control');
                }

                // Email
                if(e_mail)
                {
                    $('#emailerr').text('').show();
                    $('#email').addClass('is-invalid');
                    $('#emailerr').text(e_mail).show();
                }
                else
                {
                    $('#emailerr').text('').hide();
                    $('#email').attr('class','form-control');
                }

                // Phone
                if(phone_no)
                {
                    $('#phoneerr').text('').show();
                    $('#phone').addClass('is-invalid');
                    $('#phoneerr').text(phone_no).show();
                }
                else
                {
                    $('#phoneerr').text('').hide();
                    $('#phone').attr('class','form-control');
                }

                // Password
                if(pass)
                {
                    $('#passworderr').text('').show();
                    $('#password').addClass('is-invalid');
                    $('#passworderr').text(pass).show();
                }
                else
                {
                    $('#passworderr').text('').hide();
                    $('#password').attr('class','form-control');
                }

                // Confirm Password
                if(confirmpassword)
                {
                    $('#confirmpasswordwrr').text('').show();
                    $('#confirmpassword').addClass('is-invalid');
                    $('#confirmpassworderr').text(confirmpassword).show();
                }
                else
                {
                    $('#confirmpassworderr').text('').hide();
                    $('#confirmpassword').attr('class','form-control');
                }



            }
        });
    });
    $('#customersignout').click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: "{{  route('customerlogout') }}",
            // data: "_token": "{{ csrf_token() }}",
            dataType: "dataType",
            success: function (response) {

            }
        });

    });

});
</script>



