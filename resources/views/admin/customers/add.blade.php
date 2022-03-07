@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Customers --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customers</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customers') }}">Customers</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card card-primary">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fas fa-pencil-alt mr-2"></i>
                                    Add Customers
                                </h3>
                                <div class="container" style="text-align: right">
                                    <button type="submit" form="manuForm" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{ route('information') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('storecustomer') }}" id="manuForm" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Link --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="genral-tab" data-toggle="tab" href="#genral" role="tab" aria-controls="genral" aria-selected="true">General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="affiliate-tab" data-toggle="tab" href="#affiliate" role="tab" aria-controls="data" aria-selected="false">Affiliate</a>
                                        </li>
                                    </ul>
                                    {{-- End Tabs Link --}}


                                    <div class="tab-content pt-4" id="myTabContent">

                                        {{-- Genral Tab --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel" aria-labelledby="genral-tab">

                                            <div class="row">

                                                <div class="col-md-2">
                                                    <ul class="list-group" id="address">
                                                        <li class="list-group-item active">
                                                            <a href="#tab-customer" data-toggle="tab" class="text-white">General</a>
                                                        </li>
                                                        <li class="list-group-item" id="address-add">
                                                            <a onclick="addAddress();">
                                                                <i class="fa fa-plus-circle"></i> Add Address
                                                            </a>
                                                        </li>
                                                      </ul>
                                                </div>

                                                <div class="col-md-10">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab-customer">

                                                            <h3>Customer Details</h3>
                                                            <div class="form-group">
                                                                <label for="customergroup">Customer Group</label>
                                                                <select name="customer_group_id" id="customergroup" class="form-control">
                                                                    @foreach ($customergroups as $group)
                                                                        <option value="{{ $group->customer_group_id }}" {{ (old('customer_group_id') == $group->customer_group_id) ? 'selected' : '' }}>{{ $group->gname }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="firstname">First Name</label>
                                                                <input type="text" name="firstname" id="firstname" class="form-control {{ ($errors->has('firstname')) ? 'is-invalid' : '' }}" placeholder="First Name" value="{{ old('firstname') }}">
                                                                @if($errors->has('firstname'))
                                                                    <div class="invalid-feedback">
                                                                        {{ $errors->first('firstname') }}
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="lastname">Last Name</label>
                                                                <input type="text" name="lastname" id="lastname" class="form-control {{ ($errors->has('lastname')) ? 'is-invalid' : '' }}" placeholder="Last Name" value="{{ old('lastname') }}">
                                                                @if($errors->has('lastname'))
                                                                    <div class="invalid-feedback">
                                                                        {{ $errors->first('lastname') }}
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="text" name="email" id="email" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" placeholder="E-mail" value="{{ old('email') }}">
                                                                @if($errors->has('email'))
                                                                    <div class="invalid-feedback">
                                                                        {{ $errors->first('email') }}
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="phone">Phone No.</label>
                                                                <input type="text" name="phone" id="phone" class="form-control {{ ($errors->has('phone')) ? 'is-invalid' : '' }}" placeholder="Phone" value="{{ old('phone') }}">
                                                                @if($errors->has('phone'))
                                                                    <div class="invalid-feedback">
                                                                        {{ $errors->first('phone') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <hr style="background: black;margin-top: 25px;">


                                                            <h3>Password</h3>
                                                            <div class="form-group">
                                                                <label for="password">Password</label>
                                                                <input type="password" name="password" id="password" class="form-control {{ ($errors->has('password')) ? 'is-invalid' : '' }}">
                                                                @if($errors->has('password'))
                                                                    <div class="invalid-feedback">
                                                                        {{ $errors->first('password') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="password">Confirm Password</label>
                                                                <input type="password" name="confirm" id="confirm" class="form-control {{ ($errors->has('confirm')) ? 'is-invalid' : '' }}">
                                                                @if($errors->has('confirm'))
                                                                    <div class="invalid-feedback">
                                                                        {{ $errors->first('confirm') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <hr style="background: black;margin-top: 25px;">


                                                            <h3>Other</h3>
                                                            <div class="form-group">
                                                                <label for="newsletter">Newsletter</label>
                                                                <select name="newsletter" id="newsletter" class="form-control">
                                                                    <option value="1" {{ (old('newsletter') == 1) ? 'selected' : '' }}>Enabled</option>
                                                                    <option value="0" {{ (old('newsletter') == 1) ? '' : 'selected' }}>Disabled</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="status">Status</label>
                                                                <select name="status" id="status" class="form-control">
                                                                    <option value="1">Enabled</option>
                                                                    <option value="0">Disabled</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="safe">Safe</label>
                                                                <select name="safe" id="safe" class="form-control">
                                                                    <option value="1" {{ (old('safe') == 1) ? 'selected' : '' }}>Yes</option>
                                                                    <option value="0" {{ (old('safe') == 1) ? '' : 'selected' }}>No</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>





                                            </div>

                                            {{-- <div class="form-group">
                                                <label for="infotitle" class="form-label">Information Title</label>
                                                <input type="text" name="infotitle" class="form-control {{ ($errors->has('infotitle')) ? 'is-invalid' : '' }}" id="infotitle">
                                                @if($errors->has('infotitle'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('infotitle') }}
                                                    </div>
                                                @endif
                                            </div> --}}

                                        </div>
                                        {{-- End Genral Tab --}}


                                        {{-- Affiliate Tab --}}
                                        <div class="tab-pane fade" id="affiliate" role="tabpanel" aria-labelledby="affiliate-tab">

                                            <h3>Affiliate Details</h3>
                                            <div class="form-group">
                                                <label for="company">Company</label>
                                                <input type="text" name="company" placeholder="Company" id="company" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="website">Website</label>
                                                <input type="text" name="website" placeholder="Website" id="website" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="trackcode">Tracking Code</label>
                                                <input type="text" name="trackcode" placeholder="Tracking Code" id="trackcode" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="commission">Commission (%)</label>
                                                <input type="number" name="commission" value="5" id="commission" class="form-control"/>
                                            </div>
                                            <hr style="background: black;margin-top: 25px;">


                                            <h3>Payment Details</h3>
                                            <div class="form-group">
                                                <label for="tax">Tax ID</label>
                                                <input type="text" name="tax" id="tax" placeholder="Tax ID" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="paymentmethod">Payment Method</label>
                                                <div class="form-control">

                                                    {{-- Cheque --}}
                                                    <label for="">Cheque</label>
                                                    <input type="radio" name="payment" id="payment" value="cheque" class="mr-2" checked>
                                                    {{-- End Chque --}}

                                                    {{-- Paypal --}}
                                                    <label for="">Paypal</label>
                                                    <input type="radio" name="payment" id="payment" value="paypal" class="mr-2">
                                                    {{-- End Paypal --}}

                                                     {{-- Bank Transfer --}}
                                                     <label for="">Bank Transfer</label>
                                                     <input type="radio" name="payment" id="payment" value="bank" class="mr-2">
                                                     {{-- End Bank Transfer --}}

                                                </div>
                                            </div>

                                            <div id="payment-cheque" class="payment">
                                                <div class="form-group">
                                                    <label for="cheque">Cheque Payee Name</label>
                                                    <input type="text" name="cheque" placeholder="Cheque Payee Name" id="cheque" class="form-control" />
                                                </div>
                                            </div>

                                            <div id="payment-paypal" class="payment">
                                                <div class="form-group">
                                                    <label for="paypal">PayPal Email Account</label>
                                                    <input type="text" name="paypal" placeholder="PayPal Email Account" id="paypal" class="form-control" />
                                                </div>
                                            </div>

                                            <div id="payment-bank" class="payment">
                                                <div class="form-group">
                                                    <label for="bankname">Bank Name</label>
                                                    <input type="text" name="bankname" placeholder="Bank Name" id="bankname" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="branchnumber">Branch Number</label>
                                                    <input type="text" name="branchnumber" placeholder="Branch Number" id="branchnumber" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="swiftcode">SWIFT Code</label>
                                                    <input type="text" name="swiftcode" placeholder="SWIFT Code" id="swiftcode" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="accountname">Account Name</label>
                                                    <input type="text" name="accountname" placeholder="Account Name" id="accountname" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="accountnumber">Account Number</label>
                                                    <input type="text" name="accountnumber" placeholder="Account Number" id="accountnumber" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="affiliate">Status</label>
                                                <select name="affiliate" id="affiliate" class="form-control">
                                                    <option value="1">Enabled</option>
                                                    <option value="0" selected>Disabled</option>
                                                </select>
                                            </div>

                                        </div>
                                        {{-- End Affiliate Tab --}}

                                    </div>
                                </div>
                                {{-- End Card Body --}}

                            </form>
                            {{-- Form End --}}


                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of Add Manufacturers--}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">

    var address_row = 1;

    function addAddress()
    {
        // New Address List Add
        // html  = '<li class="list-group-item pt-1 pb-1">';
        // html += '<a href="#tab-address' + address_row + '"><i class="fa fa-minus-circle" onclick="$(\'#address a:first\').tab(\'show\'); $(\'a[href=\\\'#tab-address' + address_row + '\\\']\').parent().remove(); $(\'#tab-address' + address_row + '\').remove();"></i> Address ' + address_row + '</a>';
        // html += '</li>';
        // $('#address').append(html);


        // New Textarea Add
        // textbox  = '<div class="form-group" id="tab-address'+address_row+'">';
        // textbox  += '<label>Address '+address_row+'</label>';
        // textbox  += '<textarea name="address" id="address" class="form-control" placeholder="Address '+address_row+'"></textarea>';
        // textbox  += '</div>';
        // $('#muladdress').append(textbox);
        // address_row++;



    }



    // Payment Method Hide Show
    $('input[name=\'payment\']').on('change', function() {
        $('.payment').hide();
        $('#payment-' + this.value).show();
    });

    $('input[name=\'payment\']:checked').trigger('change');
    // End Payment Method

</script>
