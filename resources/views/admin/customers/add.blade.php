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
                                    <button onclick="savecustomer()" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{ route('customers') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form id="manuForm" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Link --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="genral-tab" data-toggle="tab" href="#genral" role="tab" aria-controls="genral" aria-selected="true">General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="ip-tab" data-toggle="tab" href="#ip" role="tab" aria-controls="data" aria-selected="false">IP Addresses</a>
                                        </li>
                                    </ul>
                                    {{-- End Tabs Link --}}

                                    {{-- Tab Content --}}
                                    <div class="tab-content pt-4" id="myTabContent">

                                        {{-- Genral Tab --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel" aria-labelledby="genral-tab">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    {{-- Inner Tab Links --}}
                                                    <ul class="nav nav-pills nav-stacked list-group" style="display: grid!important" id="address">
                                                        <li class="nav-item">
                                                            <a href="#tab-customer" class="nav-link active" data-toggle="tab" role="tab" aria-controls="data">General</a>
                                                        </li>
                                                        <li class="nav-item" id="address-add">
                                                            <a href="#" class="nav-link" onclick="addAddress();">Add  Address
                                                                <i class="fa fa-plus-circle pl-4"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    {{-- End Inner Tab Links --}}
                                                </div>
                                                <div class="col-md-10">
                                                    {{-- Genral Customer Tab --}}
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab-customer">

                                                            <h3>General</h3>
                                                            <div class="form-group">
                                                                <label for="firstname">First Name</label>
                                                                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name">
                                                                <div class="invalid-feedback" style="display: none" id="fnameError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="lastname">Last Name</label>
                                                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name">
                                                                <div class="invalid-feedback" style="display: none" id="lnameError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="text" name="email" id="email" class="form-control" placeholder="E-mail">
                                                                <div class="invalid-feedback" style="display: none" id="emailError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="phone">Phone No.</label>
                                                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
                                                                <div class="invalid-feedback" style="display: none" id="phoneError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fax">Fax</label>
                                                                <input type="text" name="fax" id="fax" class="form-control" placeholder="Fax">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="password">Password</label>
                                                                <input type="password" name="password" id="password" class="form-control">
                                                                <div class="invalid-feedback" style="display: none" id="passwordError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="password">Confirm Password</label>
                                                                <input type="password" name="confirm" id="confirm" class="form-control">
                                                                <div class="invalid-feedback" style="display: none" id="confirmError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="newsletter">Newsletter</label>
                                                                <select name="newsletter" id="newsletter" class="form-control">
                                                                    <option value="1">Enabled</option>
                                                                    <option value="0" selected>Disabled</option>
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
                                                                <label for="customergroup">Customer Group</label>
                                                                <select name="customer_group_id" id="customergroup" class="form-control">
                                                                    @foreach ($customergroups as $group)
                                                                        <option value="{{ $group->customer_group_id }}">{{ $group->gname }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    {{-- End Genral Customer Tab --}}
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End Genral Tab --}}

                                        {{-- IP Tab --}}
                                        <div class="tab-pane fade show" id="ip" role="tabpanel" aria-labelledby="ip-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>IP</th>
                                                                <th>Total Accounts</th>
                                                                <th>Date Added</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="4" class="text-center">Result Not Found!</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End IP Tab --}}

                                    </div>
                                    {{-- End Tab Content --}}

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

        html  = '<div id="tab-address-' + address_row + '" class="tab-pane">';

        html += '<h3>Address '+address_row+'</h3>';
        html += '  <input type="hidden" name="address[' + address_row + '][address_id]" value="" />';

        // First Name
        html += '<div class="form-group">';
        html += '<label for="fname' + address_row + '">First Name</label>';
        html += '<input type="text" name="address[' + address_row + '][fname]" placeholder="First Name" id="fname" class="form-control" />';
        html += '</div>';

        // Last Name
        html += '<div class="form-group">';
        html += '<label for="lname' + address_row + '">Last Name</label>';
        html += '<input type="text" name="address[' + address_row + '][lname]" placeholder="Last Name" id="lname' + address_row + '" class="form-control" />';
        html += '</div>';

        // Company
        html += '<div class="form-group">';
        html += '<label for="company' + address_row + '">Company</label>';
        html += '<input type="text" name="address[' + address_row + '][company]" placeholder="Company" id="company' + address_row + '" class="form-control" />';
        html += '</div>';

        // Company ID
        html += '<div class="form-group">';
        html += '<label for="companyId' + address_row + '">Company ID</label>';
        html += '<input type="text" name="address[' + address_row + '][companyId]" placeholder="Company ID" id="companyId' + address_row + '" class="form-control" />';
        html += '</div>';

        // TAX ID
        html += '<div class="form-group">';
        html += '<label for="taxid' + address_row + '">TAX ID</label>';
        html += '<input type="text" name="address[' + address_row + '][taxid]" placeholder="TAX ID" id="taxid' + address_row + '" class="form-control" />';
        html += '</div>';

        // Address 1
        html += '<div class="form-group">';
        html += '<label for="add_1' + address_row + '">Address 1</label>';
        html += '<input type="text" name="address[' + address_row + '][add_1]" placeholder="Address 1" id="add_1' + address_row + '" class="form-control" />';
        html += '</div>';

        // Address 2
        html += '<div class="form-group">';
        html += '<label for="add_2' + address_row + '">Address 2</label>';
        html += '<input type="text" name="address[' + address_row + '][add_2]" placeholder="Address 2" id="add_2' + address_row + '" class="form-control" />';
        html += '</div>';

        // City
        html += '<div class="form-group">';
        html += '<label for="city' + address_row + '">City</label>';
        html += '<input type="text" name="address[' + address_row + '][city]" placeholder="City" id="city' + address_row + '" class="form-control" />';
        html += '</div>';

        // Post Code
        html += '<div class="form-group">';
        html += '<label for="postcode' + address_row + '">Post Code</label>';
        html += '<input type="number" name="address[' + address_row + '][postcode]" placeholder="Post Code" id="postcode' + address_row + '" class="form-control" />';
        html += '</div>';

        // Country
        html += '<div class="form-group">';
        html += '<label for="country_id' + address_row + '">Country</label>';
        html += '<select name="address[' + address_row + '][country_id]" id="country_id' + address_row + '" class="form-control" onchange="region('+address_row+')"><option value=""> -- Select Country -- </option>@foreach($countries as $country)<option value="{{ $country->country_id }}">{{ $country->name }}</option>@endforeach</select>';
        html += '</div>';

        // Region
        html += '<div class="form-group">';
        html += '<label for="region_id' + address_row + '">Region / State</label>';
        html += '<select name="address[' + address_row + '][region_id]" id="region_id' + address_row + '" class="form-control zone_id"><option value=""> -- Select Region -- </option></select>';
        html += '</div>';

        // Default Address
        html += '<div class="form-group">';
        html += '<label for="default' + address_row + '">Default Address</label><br>';
        html += '<input type="radio" value="1" name="address[' + address_row + '][default]" id="default' + address_row + '" />';
        html += '</div>';


        html += '</div>';

        $('#genral .tab-content').append(html);

        // $('select[name=\'address[' + address_row + '][country_id]\']').trigger('change');

        $('#address-add').before('<li class="nav-item"><a href="#tab-address-' + address_row + '" data-toggle="tab" class="nav-link"> Address ' + address_row + ' <i class="fa fa-minus-circle pl-4" onclick="$(\'#address a:first\').tab(\'show\'); $(\'a[href=\\\'#tab-address-' + address_row + '\\\']\').parent().remove(); $(\'#tab-address-' + address_row + '\').remove();"></i></a></li>');

        // $('#address a[href=\'#tab-address-' + address_row + '\']').tab('show');

        address_row++;
    }



    // Region
    function region(row_id){

        var country_id = $('#country_id'+row_id+' :selected').val();
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
    // End Region


// Save Customer
function savecustomer() {

    var form_data = new FormData(document.getElementById('manuForm'));

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $.ajax({
        type: "POST",
        url: "{{ url('storecustomer') }}",
        data: form_data,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            alert('Data Inserted');
            window.location.replace('customers');
        },
        error : function (message) {

            var first_name = message.responseJSON.errors.firstname;
            var last_name = message.responseJSON.errors.lastname;
            var e_mail = message.responseJSON.errors.email;
            var phone_no = message.responseJSON.errors.phone;
            var pass = message.responseJSON.errors.password;
            var conf_pass = message.responseJSON.errors.confirm;


            // FirstName
            if(first_name)
            {
                $('#fnameError').text('').show();
                $('#firstname').attr('class','form-control is-invalid');
                $('#fnameError').text(first_name);
            }
            else
            {
                $('#fnameError').text('').hide();
                $('#firstname').attr('class','form-control');
            }

            // LastName
            if(last_name)
            {
                $('#lnameError').text('').show();
                $('#lastname').addClass('is-invalid');
                $('#lnameError').text(last_name).show();
            }
            else
            {
                $('#lnameError').text('').hide();
                $('#lastname').attr('class','form-control');
            }

            // Email
            if(e_mail)
            {
                $('#emailError').text('').show();
                $('#email').addClass('is-invalid');
                $('#emailError').text(e_mail).show();
            }
            else
            {
                $('#emailError').text('').hide();
                $('#email').attr('class','form-control');
            }

            // Phone
            if(phone_no)
            {
                $('#phoneError').text('').show();
                $('#phone').addClass('is-invalid');
                $('#phoneError').text(phone_no).show();
            }
            else
            {
                $('#phoneError').text('').hide();
                $('#phone').attr('class','form-control');
            }

            // Password
            if(pass)
            {
                $('#passwordError').text('').show();
                $('#password').addClass('is-invalid');
                $('#passwordError').text(pass).show();
            }
            else
            {
                $('#passwordError').text('').hide();
                $('#password').attr('class','form-control');
            }

            // Confirm Password
            if(conf_pass)
            {
                $('#confirmError').text('').show();
                $('#confirm').addClass('is-invalid');
                $('#confirmError').text(conf_pass).show();
            }
            else
            {
                $('#confirmError').text('').hide();
                $('#confirm').attr('class','form-control');
            }



        }
    });
}


// Payment Method Hide Show
$('input[name=\'payment\']').on('change', function() {
    $('.payment').hide();
    $('#payment-' + this.value).show();
});

$('input[name=\'payment\']:checked').trigger('change');
// End Payment Method

</script>
