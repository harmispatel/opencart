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
                                    <a href="{{ route('customers') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
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

                                                            <div class="form-group">
                                                                <label for="fax">Fax</label>
                                                                <input type="text" name="fax" id="fax" class="form-control {{ ($errors->has('fax')) ? 'is-invalid' : '' }}" placeholder="Fax" value="{{ old('fax') }}">
                                                                @if($errors->has('fax'))
                                                                    <div class="invalid-feedback">
                                                                        {{ $errors->first('fax') }}
                                                                    </div>
                                                                @endif
                                                            </div>

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
                                                                <label for="customergroup">Customer Group</label>
                                                                <select name="customer_group_id" id="customergroup" class="form-control">
                                                                    @foreach ($customergroups as $group)
                                                                        <option value="{{ $group->customer_group_id }}" {{ (old('customer_group_id') == $group->customer_group_id) ? 'selected' : '' }}>{{ $group->gname }}</option>
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
        html += '<label for="firstname' + address_row + '">First Name</label>';
        html += '<input type="text" name="address[' + address_row + '][firstname]" placeholder="First Name" id="firstname' + address_row + '" class="form-control" />';
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


// Payment Method Hide Show
$('input[name=\'payment\']').on('change', function() {
    $('.payment').hide();
    $('#payment-' + this.value).show();
});

$('input[name=\'payment\']:checked').trigger('change');
// End Payment Method

</script>
