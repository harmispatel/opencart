@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">
<link rel="stylesheet" type="text/css"
    href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />


{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Order</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('orders') }}">Category List </a></li>
                            <li class="breadcrumb-item active">All</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}

                </div>
                <div class="card-header d-flex p-2" style="background: #f6f6f6">
                    <h3 class="card-title pt-2 m-0" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Add Order
                    </h3>
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary">Save</button>
                        <a href="{{ route('orders') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            @if (count($errors) > 0)
            @if ($errors->any())
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {{ "Warning: Please check the form carefully for errors!" }}
            </div>
            @endif
            @endif
            <form action="{{ route('addneworders') }}" id="catform" method="POST" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="card-body">

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-customer-tab" data-toggle="tab"
                                href="#nav-customer" role="tab" aria-controls="nav-customer"
                                aria-selected="true">Customer Details</a>
                            <a class="nav-item nav-link" id="nav-payment-tab" data-toggle="tab" href="#nav-payment"
                                role="tab" aria-controls="nav-payment" aria-selected="false">Payment Details</a>
                            <a class="nav-item nav-link" id="nav-shipping-tab" data-toggle="tab" href="#nav-shipping"
                                role="tab" aria-controls="nav-shipping" aria-selected="false">Shipping Details</a>
                            <a class="nav-item nav-link" id="nav-product-tab" data-toggle="tab" href="#nav-product"
                                role="tab" aria-controls="nav-product" aria-selected="false">Products</a>
                            <a class="nav-item nav-link" id="nav-vouchers-tab" data-toggle="tab" href="#nav-vouchers"
                                role="tab" aria-controls="nav-vouchers" aria-selected="false">Vouchers</a>
                            <a class="nav-item nav-link" id="nav-totals-tab" data-toggle="tab" href="#nav-totals"
                                role="tab" aria-controls="nav-totals" aria-selected="false">Totals</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-customer" role="tabpanel"
                            aria-labelledby="nav-customer-tab">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Store</label>
                                <select class="form-control" name="storename">
                                    <option value="0">Default</option>
                                    @foreach ($stores as $store)
                                    <option value="{{ $store->store_id }}">{{ htmlspecialchars_decode($store->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="#search">
                                <label for="cname">Customer</label>
                                <input type="text" id="cname" name="cname" value="" class="form-control"
                                    placeholder="Customer name">
                                <input type="hidden" id="customerid" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Customer Group</label>
                                <select class="form-control" name="cgroup">
                                    @foreach ($Customers as $Customer)
                                    <option value="{{ $Customer->customer_group_id }}">{{ $Customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fname">* First Name</label>
                                <input class="form-control" name="firstname" id="fname" type="text" value=""
                                    placeholder="First name">
                                @if ($errors->has('firstname'))
                                <div style="color: red">{{ $errors->first('firstname') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="lname">* Last Name</label>
                                <input class="form-control" name="lastname" id="lname" value="" type="text"
                                    placeholder="Last name">
                                @if ($errors->has('lastname'))
                                <div style="color: red">{{ $errors->first('lastname') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">* E-Mail</label>
                                <input class="form-control" name="email" id="email" value="" type="text"
                                    placeholder="Email">
                                @if ($errors->has('email'))
                                <div style="color: red">{{ $errors->first('email') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="phone">* Telephone</label>
                                <input class="form-control" name="phone" id="phone" value="" type="text"
                                    placeholder="Telehone">
                                @if ($errors->has('phone'))
                                <div style="color: red">{{ $errors->first('phone') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="fax">Fax</label>
                                <input class="form-control" name="fax" id="fax" value="" type="text" placeholder="Fax">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                            <div class="form-group">
                                <label for="address">Choose Address</label>
                                <select class="form-control address" id="paymentaddress">
                                    <option>--None--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pfname">* First Name</label>
                                <input class="form-control" name="pfirstname" id="pfname" value="" type="text" placeholder="First name">
                                @if ($errors->has('pfirstname'))
                                <div style="color: red">{{ $errors->first('pfirstname') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="plname">* Last Name</label>
                                <input class="form-control" name="plastname" id="plname" value="" type="text" placeholder="Last name">
                                @if ($errors->has('plastname'))
                                <div style="color: red">{{ $errors->first('plastname') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="pcompany">Company</label>
                                <input class="form-control" name="pcompany" id="pcompany" value="" type="text" placeholder="Company">
                                
                            </div>
                            <div class="form-group">
                                <label for="pcompanyid">Company ID</label>
                                <input class="form-control" name="pcompanyid" id="pcompanyid" value="" type="text"
                                    placeholder="Company id">

                            </div>
                            <div class="form-group">
                                <label for="address1">* Address 1</label>
                                <input class="form-control" name="paddress1" id="address1" value="" type="text" placeholder="Address 1">
                                @if ($errors->has('paddress1'))
                                <div style="color: red">{{ $errors->first('paddress1') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="address2">Address 2</label>
                                <input class="form-control" id="address2" value="" type="text" placeholder="Address 2">
                                
                            </div>
                            <div class="form-group">
                                <label for="pcity">* City</label>
                                <input class="form-control" name="pcity" id="pcity" value="" type="text" placeholder="City">
                                @if ($errors->has('pcity'))
                                <div style="color: red">{{ $errors->first('pcity') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="pposotcode">Postcode</label>
                                <input class="form-control" name="ppostcode" id="ppostcode" type="text" placeholder="Postcode">
                            </div>
                            <div class="form-group">
                                <label for="country_id">* Country</label>
                                <select class="form-control country_id" name="pcountry" id="country_id" onchange="statespayment();">
                                    <option>Select Country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('pcountry'))
                                <div style="color: red">{{ $errors->first('pcountry') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="region">* Region / State</label>
                                <select class="form-control zone_id" name="region" id="region">
                                    <option>Select Region/State</option>
                                </select>
                                @if ($errors->has('region'))
                                <div style="color: red">{{ $errors->first('region') }}.</div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-shipping" role="tabpanel" aria-labelledby="nav-shipping-tab">
                            <div class="form-group">
                                <label for="shippingaddress">Choose Address</label>
                                <select class="form-control address" id="shippingaddress">
                                    <option>--None--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* First Name</label>
                                <input class="form-control" name="sfirstname" id="sfname" value="" name="sfname" type="text"
                                    placeholder="First name">
                                    @if ($errors->has('sfirstname'))
                                    <div style="color: red">{{ $errors->first('sfirstname') }}.</div>
                                    @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Last Name</label>
                                <input class="form-control" name="slastname" id="slname" value="" type="text" placeholder="Last name">
                                @if ($errors->has('slastname'))
                                <div style="color: red">{{ $errors->first('slastname') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Company</label>
                                <input class="form-control" name="scompany" id="scompany" value="" type="text" placeholder="Company">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Address 1</label>
                                <input class="form-control" name="saddress1" id="saddress1" value="" type="text" placeholder="Address 1">
                                @if ($errors->has('saddress1'))
                                <div style="color: red">{{ $errors->first('saddress1') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address 2</label>
                                <input class="form-control" name="saddress2" id="saddress2" value="" type="text" placeholder="Address 2">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* City</label>
                                <input class="form-control" name="scity" id="scity" value="" type="text" placeholder="City">
                                @if ($errors->has('scity'))
                                <div style="color: red">{{ $errors->first('scity') }}.</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Postcode</label>
                                <input class="form-control" name="spostcode" id="spostcode" value="" type="text" placeholder="Postcode">
                            </div>
                            <div class="form-group">
                                <label for="country_id1">* Country</label>
                                <select class="form-control country_id" name="country_id1" id="country_id1" onchange="statesshipping();">
                                    <option>Select Country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                    @endforeach
                                    @if ($errors->has('country_id1'))
                                    <div style="color: red">{{ $errors->first('country_id1') }}.</div>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="region1">* Region / State</label>
                                <select class="form-control zone_id" name="region1" id="region1">
                                    <option>Select Region/State</option>
                                </select>
                                @if ($errors->has('region1'))
                                <div style="color: red">{{ $errors->first('region1') }}.</div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
                            <div class="table-responsive">
                                <table class="list table">
                                    <thead>
                                        <tr>
                                            <td class="left">Product</td>
                                            <td class="left">Model</td>
                                            <td class="right">Quantity</td>
                                            <td class="right">Unit Price</td>
                                            <td class="right">Total</td>
                                        </tr>
                                    </thead>
                                    <tbody class="productdata">

                                    </tbody>

                                </table>
                            </div>

                            <fieldset>
                                <legend>Add Product</legend>
                                <form class="form-horizontal" id="orderhistoryform">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="productname">Product name</label>
                                        <input type="text" id="productname" name="productname" value=""
                                            class="form-control" placeholder="Product name">
                                        <input type="hidden" id="productid" class="form-control" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-comment">Quantity</label>
                                        <input class="form-control" type="text" value="1" placeholder="Default input">
                                    </div>
                                    <div class="text-right">
                                        <button id="button-history" class="btn btn-primary">Add History</button>
                                    </div>
                                </form>
                            </fieldset>
                        </div>

                        <div class="tab-pane fade show" id="nav-vouchers" role="tabpanel"
                            aria-labelledby="nav-vouchers-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="ordertable">
                                    <thead>
                                        <tr>
                                            <td class="text-left">Product</td>
                                            <td class="text-left">Model</td>
                                            <td class="text-left">Quantity</td>
                                            <td class="text-left">Unit Price</td>
                                            <td class="text-left">Total</td>
                                        </tr>
                                    </thead>
                                    <tbody class="productdata">

                                    </tbody>
                                </table>
                            </div>

                            <fieldset>
                                <legend>Add Product</legend>
                                <form class="form-horizontal" id="orderhistoryform">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="control-label" for="input-order-status">* Recipient's Name</label>
                                        <input class="form-control" name="rname" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-order-status">* Recipient's Email</label>
                                        <input class="form-control" name="remail" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-order-status">* Senders Name</label>
                                        <input class="form-control" name="sendername" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-order-status">* Senders Email</label>
                                        <input class="form-control" name="senderemail" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-comment">* Gift Certificate Theme</label>
                                        <select class="form-control" name="giftcertheme">
                                            @foreach ($voucherdesc as $voucher)
                                            <option value="{{ $voucher->voucher_theme_id }}">{{ $voucher->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-comment">Message</label>
                                        <textarea class="form-control" name="message" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-comment">* Amount</label>
                                        <input class="form-control" name="amount" type="text" value="25.00" placeholder="Default input">
                                    </div>
                                    <div class="text-right">
                                        <button id="button-history" class="btn btn-primary">Add History</button>
                                    </div>
                                </form>
                            </fieldset>

                        </div>
                        <div class="tab-pane fade show" id="nav-totals" role="tabpanel"
                            aria-labelledby="nav-totals-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="ordertable">
                                    <thead>
                                        <tr>
                                            <td class="text-left">Product</td>
                                            <td class="text-left">Model</td>
                                            <td class="text-left">Quantity</td>
                                            <td class="text-left">Unit Price</td>
                                            <td class="text-left">Total</td>
                                        </tr>
                                    </thead>
                                    <tbody class="productdata">

                                    </tbody>
                                </table>
                            </div>

                            <fieldset>
                                <legend>Add Product</legend>
                                <form class="form-horizontal" id="orderhistoryform">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="control-label" for="input-order-status">Shipping Method</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-order-status">Payment Method</label>
                                        <input class="form-control" name="paymentmethod" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-order-status">Coupon</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-order-status">Voucher</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-comment">Reward</label>
                                        <select class="form-control">
                                            <option>Default select</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-comment">Order Status</label>
                                        <select class="form-control">
                                            @foreach ($orderstatus as $status)
                                            
                                            <option value="{{ $status->order_status_id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-comment">Comment</label>
                                        <textarea class="form-control" name="comment" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="input-comment">Affiliate</label>
                                        <input class="form-control" type="text" name="affiliate" placeholder="Default input">
                                    </div>
                                    <div class="text-right">
                                        <button id="button-history" class="btn btn-primary">Update Totals</button>
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                    </div>
                </div>

            </form>

        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')

<script type="text/javascript">
    function statespayment(){

var country_id = $('#country_id :selected').val();
// alert(country_id)
$.ajax({
    type: "POST",
    url: "{{ url('getRegionbyCountry') }}",
    data: {'country_id':country_id,"_token": "{{ csrf_token() }}",},
    dataType: "json",
    success: function (response) {
        $('.zone_id').text('');
        $('.zone_id').append(response);
    }
});

}
    function statesshipping(){

var country_id = $('#country_id1 :selected').val();
// alert(country_id)
$.ajax({
    type: "POST",
    url: "{{ url('getRegionbyCountry') }}",
    data: {'country_id':country_id,"_token": "{{ csrf_token() }}",},
    dataType: "json",
    success: function (response) {
        $('.zone_id').text('');
        $('.zone_id').append(response);
    }
});

}

    $('#cname').autocomplete({
    source : function(requete, reponse){

        $.ajax({
            url :  "{{ url('autocomplete') }}",
             data: {
                term : requete.term
             },
            dataType : 'json', 
            success : function(data){

                reponse($.map(data, function(object){
                    return {
                        customer_id: object.customer_id,
                        label: object.firstname +" "+ object.lastname,
                        fname: object.firstname,
                        lname: object.lastname,
                        email: object.email,
                        fax: object.fax,
                        phone: object.telephone,
                        };
                }));
            }
        });
    },

    minLength: 1,
    delay:500,

    select: function( event, ui ) {
         console.log( ui.item.customer_id );
         $(' #fname ' ).val(  ui.item.fname ); 
         $(' #lname ' ).val(  ui.item.lname ); 
         $(' #email ' ).val(  ui.item.email ); 
         $(' #customerid ').val( ui.item.customer_id ); 
         $(' #fax ').val( ui.item.fax ); 
         $(' #phone ').val( ui.item.phone ); 
        
        // Get address
        var customerid = $(' #customerid ').val();
        $.ajax({
            type: "get",
            url: "{{ url('getaddress') }}/"+customerid,
            dataType: "json",
            success: function (response) {
                $('.address').html(response);
            }
        });
        var customerid = $(' #customerid ').val();
        $.ajax({
            type: "get",
            url: "{{ url('getproducts') }}/"+customerid,
            dataType: "json",
            success: function (response) {
                $('.productdata').html(response);
            }
        });
        $('#paymentaddress').on('change', function() {
          var paddressid = ($(this).val()); 
          $.ajax({
              type: "get",
              url: "{{url('address')}}/"+paddressid,
              dataType: "json",
              success: function (response) {
                    $('#pfname').val(response.firstname);
                    $('#plname').val(response.lastname);
                    $('#pcompany').val(response.company);
                    $('#pcompanyid').val(response.company_id);
                    $('#address1').val(response.address_1);
                    $('#address2').val(response.address_2);
                    $('#pcity').val(response.city);
                    $('#ppostcode').val(response.postcode);
              }
          });
        });

        $('#shippingaddress').on('change', function() {
            var saddressid = ($(this).val()); 
            console.log(saddressid);
            $.ajax({
                type: "get",
                url: "{{url('address')}}/"+saddressid,
                dataType: "json",
                success: function (response) {
                        $('#sfname').val(response.firstname);
                        $('#slname').val(response.lastname);
                        $('#scompany').val(response.company);
                        $('#scompanyid').val(response.company_id);
                        $('#saddress1').val(response.address_1);
                        $('#saddress2').val(response.address_2);
                        $('#scity').val(response.city);
                        $('#spostcode').val(response.postcode);
                }
            });
          });
        //  return false;
      } ,

    messages: {
        noResults: '',
        results: function() {}
    }

}); 

// for html code decode
function htmlDecode(input) {
  var doc = new DOMParser().parseFromString(input, "text/html");
  return doc.documentElement.textContent;
}

    $('#productname').autocomplete({
        source : function(requete, reponse){

        $.ajax({
            url :  "{{ url('autocompleteproduct') }}",
             data: {
                product : requete.term
             },
            dataType : 'json', 
            success : function(data){

                reponse($.map(data, function(object){
                    return {
                        // customer_id: object.,
                        label: htmlDecode(object.name),
                        proid : object.product_id
                       
                        };
                }));
            }
        });
    },

    minLength: 1,
    delay:500,

    select: function( event, ui ) {
         $(' #productid ' ).val(  ui.item.proid ); 
       //  return false;
      } ,

    messages: {
        noResults: '',
        results: function() {}
    }
}); 






</script>