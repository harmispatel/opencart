<!DOCTYPE html>
<html>
   <head>
      <title>Checkout</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <style type="text/css">
         .panel-title {
         display: inline;
         font-weight: bold;
         }
         .display-table {
         display: table;
         }
         .display-tr {
         display: table-row;
         }
         .display-td {
         display: table-cell;
         vertical-align: middle;
         width: 61%;
         }
      </style>
   </head>
   <body class="vh-100">
    @php

        // Get Current URL
        $currentURL = URL::to("/");


        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        // Get Currency Details
        $currency = getCurrencySymbol($store_setting['config_currency']);

        $servicecharge = paymentdetails();
        // dynamic stripe key
        $stripekey = $servicecharge["stripe"]["stripe_publickey"] ? $servicecharge["stripe"]["stripe_publickey"] : '';

        $stripe_charge = $servicecharge["stripe"]["stripe_charge_payment"] ? $servicecharge["stripe"]["stripe_charge_payment"] : '0.00';
        $paypal_charge = $servicecharge["paypal"]["pp_charge_payment"] ? $servicecharge["paypal"]["pp_charge_payment"] : '0.00';
        $cod_charge = $servicecharge["cod"]["cod_charge_payment"] ? $servicecharge["cod"]["cod_charge_payment"] : '0.00';


        $ordertotal = session()->has('total') ? session('total') : '';
        $total = $ordertotal + $stripe_charge;
    @endphp
      <div class="container">
         <div class="row justify-content-center h-100 align-item-center">
            <div class="col-md-6 col-md-offset-3">
               <div class="panel panel-default credit-card-box">
                  <div class="panel-heading display-table" >
                     <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                     </div>
                  </div>
                  <div class="panel-body">
                     @if (Session::has('success'))
                     <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                     </div>
                     @endif
                     <form
                        role="form"
                        action="{{ route('stripe.post') }}"
                        method="post"
                        class="require-validation"
                        data-cc-on-file="false"
                        data-stripe-publishable-key="{{ $stripekey }}"
                        id="payment-form">
                        @csrf
                        <div class='form-row row'>
                           <div class='col-xs-12 form-group required'>
                              <label class='control-label'>Name on Card</label> <input
                                 class='form-control' size='4' type='text'>
                           </div>
                        </div>
                        <div class='form-row row'>
                           <div class='col-xs-12 form-group card required'>
                              <label class='control-label'>Card Number</label> <input
                                 autocomplete='off' class='form-control card-number' size='20'
                                 type='text'>
                           </div>
                        </div>
                        <div class='form-row row'>
                           <div class='col-xs-12 col-md-4 form-group cvc required'>
                              <label class='control-label'>CVC</label> <input autocomplete='off'
                                 class='form-control card-cvc' placeholder='ex. 311' size='4'
                                 type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Month</label> <input
                                 class='form-control card-expiry-month' placeholder='MM' size='2'
                                 type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Year</label> <input
                                 class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                 type='text'>
                                 <input type="hidden" value="{{ $total }}" name="total">
                                 <input type="hidden" value="{{ $store_setting['config_currency'] }}" name="currency_code">
                                 <input type="hidden" value="{{ $stripe_charge }}" name="stripe_service_charge">
                           </div>
                        </div>
                        <div class='form-row row'>
                           <div class='col-md-12 error form-group hide'>
                              {{-- <div class='alert-danger alert'>Please correct the errors and try again.</div> --}}
                              <div class='alert-danger alert'></div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-xs-12">
                              <button class="btn btn-primary btn-lg btn-block" type="submit">Pay {{ $currency }} {{ $total }}</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
   <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
   <script type="text/javascript">
      $(function() {
    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                'input[type=text]', 'input[type=file]',
                'textarea'
            ].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            // alert(form.data('stripe-publishable-key')
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .addClass('')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});
   </script>
</html>
