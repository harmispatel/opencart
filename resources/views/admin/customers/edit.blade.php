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
                            <li class="breadcrumb-item active">Edit</li>
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
                                    Edit Customers
                                </h3>
                                <div class="container" style="text-align: right">
                                    <button onclick="savecustomer()" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Update</button>
                                    <a href="{{ route('customers') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Link --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="genral-tab" data-toggle="tab" href="#genral" role="tab" aria-controls="genral" aria-selected="true">General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="data" aria-selected="false" onclick="getCustomerHistory()">History</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" onclick="getCustomerTransactions()" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="data" aria-selected="false">Transactions</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" onclick="getCustomerRewardpoints()" id="reward-tab" data-toggle="tab" href="#reward" role="tab" aria-controls="data" aria-selected="false">Reward Points</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="ip-tab" data-toggle="tab" href="#ip" role="tab" aria-controls="data" aria-selected="false">IP Addresses</a>
                                        </li>
                                    </ul>
                                    {{-- End Tabs Link --}}


                                    {{-- Dynamic Address Count --}}
                                    @php
                                        $count = count($addresses);
                                        if ($count != '') {
                                            $newcount = $count + 1;
                                            echo '<input type="hidden" name="add_count" id="add_count" value="'.$newcount.'">';
                                        }
                                        else {
                                            echo '<input type="hidden" name="add_count" id="add_count" value="1">';
                                        }
                                    @endphp
                                    {{-- End Dynamic Address Count --}}

                                    {{-- Tab Content --}}
                                    <div class="tab-content pt-4" id="myTabContent">

                                        {{-- Genral Tab --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel" aria-labelledby="genral-tab">
                                            <form id="manuForm" enctype="multipart/form-data">
                                            {{ @csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-2">
                                                    {{-- Inner Tab Links --}}
                                                    <ul class="nav nav-pills nav-stacked list-group" style="display: grid!important" id="address">
                                                        <li class="nav-item">
                                                            <a href="#tab-customer" class="nav-link active" data-toggle="tab" role="tab" aria-controls="data">General</a>
                                                        </li>
                                                        @if(!empty($addresses))
                                                            @foreach ($addresses as $address)
                                                                <li class="nav-item">
                                                                    <a href="#tab-address-{{ $loop->iteration }}" data-toggle="tab" class="nav-link">
                                                                        Address {{ $loop->iteration }}
                                                                        <i class="fa fa-minus-circle pl-4" onclick="DelAddress({{ $address->address_id }})"></i>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                        <li class="nav-item" id="address-add">
                                                            <a href="#" class="nav-link" onclick="addAddress();">Add  Address
                                                                <i class="fa fa-plus-circle pl-4"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    {{-- End Inner Tab Links --}}
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="tab-content">
                                                        {{-- Genral Customer Tab --}}
                                                        <div class="tab-pane active" id="tab-customer">

                                                            <h3>General</h3>
                                                            <div class="form-group">
                                                                <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
                                                                <label for="firstname"><span class="text-danger">*</span> First Name</label>
                                                                <input type="text" name="firstname" id="firstname" class="form-control" value="{{ $customer->firstname }}">
                                                                <div class="invalid-feedback" style="display: none" id="fnameError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="lastname"><span class="text-danger">*</span> Last Name</label>
                                                                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ $customer->lastname }}">
                                                                <div class="invalid-feedback" style="display: none" id="lnameError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email"><span class="text-danger">*</span> Email</label>
                                                                <input type="text" name="email" id="email" class="form-control" value="{{ $customer->email }}">
                                                                <div class="invalid-feedback" style="display: none" id="emailError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="phone"><span class="text-danger">*</span> Phone No.</label>
                                                                <input type="text" name="phone" id="phone" class="form-control" value="{{ $customer->telephone }}">
                                                                <div class="invalid-feedback" style="display: none" id="phoneError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fax">Fax</label>
                                                                <input type="text" name="fax" id="fax" class="form-control" value="{{ $customer->fax }}">
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
                                                                    <option value="1" {{ ($customer->newsletter == 1) ? 'selected' : '' }}>Enabled</option>
                                                                    <option value="0" {{ ($customer->newsletter == 0) ? 'selected' : '' }}>Disabled</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="status">Status</label>
                                                                <select name="status" id="status" class="form-control">
                                                                    <option value="1" {{ ($customer->status == 1) ? 'selected' : '' }}>Enabled</option>
                                                                    <option value="0" {{ ($customer->status == 0) ? 'selected' : '' }}>Disabled</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="customergroup">Customer Group</label>
                                                                <select name="customer_group_id" id="customergroup" class="form-control">
                                                                    @foreach ($customergroups as $group)
                                                                        <option value="{{ $group->customer_group_id }}" {{ ($group->customer_group_id == $customer->customer_group_id) ? 'selected' : '' }}>{{ $group->gname }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                        {{-- End Genral Customer Tab --}}

                                                        {{-- Dynamic Address Tabs --}}
                                                        @if(!empty($addresses))
                                                            @foreach ($addresses as $address)
                                                                <div id="tab-address-{{ $loop->iteration }}" class="tab-pane">
                                                                    <h3>Address {{ $loop->iteration }}</h3>

                                                                    <input type="hidden" name="address[{{ $loop->iteration }}][address_id]" value="{{ $address->address_id }}">

                                                                    <div class="form-group">
                                                                        <label for="fname{{ $loop->iteration }}"><span class="text-danger">*</span> First Name</label>
                                                                        <input type="text" name="address[{{ $loop->iteration }}][fname]" id="fname{{ $loop->iteration }}" class="form-control" value="{{ $address->firstname }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="lname{{ $loop->iteration }}"><span class="text-danger">*</span> Last Name</label>
                                                                        <input type="text" name="address[{{ $loop->iteration }}][lname]" id="lname{{ $loop->iteration }}" class="form-control" value="{{ $address->lastname }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="company{{ $loop->iteration }}">Company</label>
                                                                        <input type="text" name="address[{{ $loop->iteration }}][company]" id="company{{ $loop->iteration }}" class="form-control" value="{{ $address->company }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="companyId{{ $loop->iteration }}">Company ID</label>
                                                                        <input type="text" name="address[{{ $loop->iteration }}][companyId]" id="companyId{{ $loop->iteration }}" class="form-control" value="{{ $address->company_id }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="taxid{{ $loop->iteration }}">TAX ID</label>
                                                                        <input type="text" name="address[{{ $loop->iteration }}][taxid]" id="taxid{{ $loop->iteration }}" class="form-control" value="{{ $address->tax_id }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="add_one{{ $loop->iteration }}"><span class="text-danger">*</span> Address One</label>
                                                                        <input type="text" name="address[{{ $loop->iteration }}][add_one]" id="add_one{{ $loop->iteration }}" class="form-control" value="{{ $address->address_1 }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="add_two{{ $loop->iteration }}">Address Two</label>
                                                                        <input type="text" name="address[{{ $loop->iteration }}][add_two]" id="add_two{{ $loop->iteration }}" class="form-control" value="{{ $address->address_2 }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="city{{ $loop->iteration }}"><span class="text-danger">*</span> City</label>
                                                                        <input type="text" name="address[{{ $loop->iteration }}][city]" id="city{{ $loop->iteration }}" class="form-control" value="{{ $address->city }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="postcode{{ $loop->iteration }}"><span class="text-danger">*</span> Post Code</label>
                                                                        <input type="text" name="address[{{ $loop->iteration }}][postcode]" id="postcode{{ $loop->iteration }}" class="form-control" value="{{ $address->postcode }}">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="country_id{{ $loop->iteration }}"><span class="text-danger">*</span> Country</label>
                                                                        <select name="address[{{ $loop->iteration }}][country_id]" id="country_id{{ $loop->iteration }}" class="form-control" onchange="region({{ $loop->iteration }})">
                                                                        <option value=""> -- Select Country -- </option>
                                                                        @foreach ($countries as $country)
                                                                            <option value="{{ $country->country_id }}" {{ ($address->country_id == $country->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                                                        @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="region_id{{ $loop->iteration }}"><span class="text-danger">*</span> Region / State</label>
                                                                        <select name="address[{{ $loop->iteration }}][region_id]" id="region_id{{ $loop->iteration }}" class="form-control">
                                                                            @php
                                                                                $zone_id = $address->zone_id;
                                                                                $zone = getZonebyId($zone_id);
                                                                            @endphp
                                                                            @if(!empty($zone))
                                                                                <option value="{{ $zone->zone_id }}">{{ $zone->name }}</option>
                                                                            @else
                                                                                <option value=""> -- Select Region -- </option>
                                                                            @endif
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="deafault{{ $loop->iteration }}">Default Address</label>
                                                                        <input type="radio" name="address[{{ $loop->iteration }}][default]" id="default{{ $loop->iteration }}" {{ ($customer->address_id == $address->address_id) ? 'checked' : '' }}>
                                                                    </div>

                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        {{-- End Dynamic Address Tabs --}}

                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        {{-- End Genral Tab --}}

                                        {{-- History Tab --}}
                                        <div class="tab-pane fade show" id="history" role="tabpanel" aria-labelledby="history-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered" id="custHistory">
                                                        <thead>
                                                            <tr>
                                                                <th>Date Added</th>
                                                                <th>Comment</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form enctype="multipart/form-data" id="historyForm">
                                                        <div class="form-group">
                                                            <label for="">Comment</label>
                                                            <input type="hidden" name="cid" id="cid" value="{{ $customer->customer_id }}">
                                                            <textarea name="comment" id="comment" class="form-control" placeholder="Comment"></textarea>
                                                            <div class="invalid-feedback" style="display: none" id="commentError">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <a href="#" onclick="addCustomerHistory()" class="btn btn-sm btn-primary">Add History</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End History Tab --}}

                                        {{-- Transaction Tab --}}
                                        <div class="tab-pane fade show" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered" id="custTransaction">
                                                        <thead>
                                                            <tr>
                                                                <th>Date Added</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row" id="custTransactionSum">

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form enctype="multipart/form-data" id="transactionForm">
                                                        <div class="form-group">
                                                            <label for="">Description</label>
                                                            <input type="hidden" name="trcid" id="trcid" value="{{ $customer->customer_id }}">
                                                            <textarea name="trdescription" id="trdescription" class="form-control" placeholder="Description"></textarea>
                                                            <div class="invalid-feedback" style="display: none" id="trdescriptionError">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Amount</label>
                                                            <input type="number" name="tramount" id="tramount" class="form-control" placeholder="1000">
                                                            <div class="invalid-feedback" style="display: none" id="tramountError">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <a href="#" onclick="addCustomerTransaction()" class="btn btn-sm btn-primary">Add Transaction</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End Transaction Tab --}}

                                        {{-- Reward Points Tab --}}
                                        <div class="tab-pane fade show" id="reward" role="tabpanel" aria-labelledby="reward-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered" id="custRewardpoints">
                                                        <thead>
                                                            <tr>
                                                                <th>Date Added</th>
                                                                <th>Description</th>
                                                                <th>Points</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row" id="custRewardpointsSum">

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form enctype="multipart/form-data" id="rewardForm">
                                                        <div class="form-group">
                                                            <label for="">Description</label>
                                                            <input type="hidden" name="rcid" id="rcid" value="{{ $customer->customer_id }}">
                                                            <textarea name="rdescription" id="rdescription" class="form-control" placeholder="Description"></textarea>
                                                            <div class="invalid-feedback" style="display: none" id="rdescriptionError">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Points</label>
                                                            <input type="number" name="rpoints" id="rpoints" class="form-control" placeholder="350">
                                                            <div class="invalid-feedback" style="display: none" id="rpointsError">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <a href="#" onclick="addCustomerRewardpoint()" class="btn btn-sm btn-primary">Add Reward Points</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End Reward Points Tab --}}

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
                                                            @if (count($ips) > 0)
                                                                @foreach ($ips as $ip)
                                                                    <tr>
                                                                        <td>{{ $ip->ip }}</td>
                                                                        <td>
                                                                            @php
                                                                                $searchip = $ip->ip;
                                                                                $total_ip = gettotalip($searchip);
                                                                            @endphp
                                                                            {{ $total_ip }}
                                                                        </td>
                                                                        <td>
                                                                            {{ date('d/m/Y',strtotime( $ip->date_sadded)) }}
                                                                        </td>
                                                                        <td id="banip{{$ip->customer_ip_id}}">
                                                                            @php
                                                                                $cip = $ip->ip;
                                                                                $check_ban_ip = checkBanIp($cip);
                                                                            @endphp
                                                                            @if (!empty($check_ban_ip))
                                                                                [<a href="#" class="text-danger" onclick="removeBanIP('{{$cip}}',{{ $ip->customer_ip_id }})">Remove Ban IP</a>]
                                                                            @else
                                                                                [<a href="#" class="text-success" onclick="addBanIP('{{$cip}}',{{ $ip->customer_ip_id }})">Add Ban IP</a>]
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else

                                                                <tr>
                                                                    <td colspan="4" class="text-center">Ip Not Found</td>
                                                                </tr>

                                                            @endif
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

    var address_row = $('#add_count').val();

    function addAddress()
    {

        html  = '<div id="tab-address-' + address_row + '" class="tab-pane">';

        html += '<h3>Address '+address_row+'</h3>';
        html += '  <input type="hidden" name="address[' + address_row + '][address_id]" value="" />';

        // First Name
        html += '<div class="form-group">';
        html += '<label for="fname' + address_row + '"><span class="text-danger">*</span> First Name</label>';
        html += '<input type="text" name="address[' + address_row + '][fname]" placeholder="First Name" id="fname" class="form-control" />';
        html += '</div>';

        // Last Name
        html += '<div class="form-group">';
        html += '<label for="lname' + address_row + '"><span class="text-danger">*</span> Last Name</label>';
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
        html += '<label for="add_one' + address_row + '"><span class="text-danger">*</span> Address One</label>';
        html += '<input type="text" name="address[' + address_row + '][add_one]" placeholder="Address One" id="add_one' + address_row + '" class="form-control" />';
        html += '</div>';

        // Address 2
        html += '<div class="form-group">';
        html += '<label for="add_two' + address_row + '">Address Two</label>';
        html += '<input type="text" name="address[' + address_row + '][add_two]" placeholder="Address Two" id="add_two' + address_row + '" class="form-control" />';
        html += '</div>';

        // City
        html += '<div class="form-group">';
        html += '<label for="city' + address_row + '"><span class="text-danger">*</span> City</label>';
        html += '<input type="text" name="address[' + address_row + '][city]" placeholder="City" id="city' + address_row + '" class="form-control" />';
        html += '</div>';

        // Post Code
        html += '<div class="form-group">';
        html += '<label for="postcode' + address_row + '"><span class="text-danger">*</span> Post Code</label>';
        html += '<input type="number" name="address[' + address_row + '][postcode]" placeholder="Post Code" id="postcode' + address_row + '" class="form-control" />';
        html += '</div>';

        // Country
        html += '<div class="form-group">';
        html += '<label for="country_id' + address_row + '"><span class="text-danger">*</span> Country</label>';
        html += '<select name="address[' + address_row + '][country_id]" id="country_id' + address_row + '" class="form-control" onchange="region('+address_row+')"><option value=""> -- Select Country -- </option>@foreach($countries as $country)<option value="{{ $country->country_id }}">{{ $country->name }}</option>@endforeach</select>';
        html += '</div>';

        // Region
        html += '<div class="form-group">';
        html += '<label for="region_id' + address_row + '"><span class="text-danger">*</span> Region / State</label>';
        html += '<select name="address[' + address_row + '][region_id]" id="region_id' + address_row + '" class="form-control"><option value=""> -- Select Region -- </option></select>';
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
                $('#region_id'+row_id).text('');
                $('#region_id'+row_id).append(response);
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
        url: "{{ url('updatecustomer') }}",
        data: form_data,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert('Customer Updated');
            // location.reload();
            window.location.href = response;
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


$(document).ready(function(){
    // getCustomerHistory();
});


// Get Customer History
function getCustomerHistory()
{
    var cust_id = $('#cid').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('getcustomerhistory') }}",
        data: { cust_id : cust_id },
        dataType: "json",
        success: function (response) {
            $('#custHistory tbody').html('');
            $('#custHistory tbody').html(response);
            $('#custHistory').DataTable();
        }
    });
}


// Add Customer History
function addCustomerHistory()
{

    var form_data = new FormData(document.getElementById('historyForm'));

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('storecustomerhistory') }}",
        data: form_data,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            getCustomerHistory();
            $('#historyForm').trigger('reset');
            $('#commentError').text('').hide();
            $('#comment').attr('class','form-control');
        },
        error : function (message) {

            var comment = message.responseJSON.errors.comment;

            // Comment
            if(comment)
            {
                $('#commentError').text('').show();
                $('#comment').attr('class','form-control is-invalid');
                $('#commentError').text(comment);
            }
            else
            {
                $('#commentError').text('').hide();
                $('#comment').attr('class','form-control');
            }

        }
    });

}


// Get Customer Transactions
function getCustomerTransactions()
{
    var cust_id = $('#cid').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('getcustomertransactions') }}",
        data: { cust_id : cust_id },
        dataType: "json",
        success: function (response) {
            $('#custTransaction tbody').html('');
            $('#custTransaction tbody').html(response.transaction);
            $('#custTransactionSum').html('');
            $('#custTransactionSum').html(response.sum);
            $('#custTransaction').DataTable();
        }
    });
}



// Add Customer Transaction
function addCustomerTransaction()
{

    var form_data = new FormData(document.getElementById('transactionForm'));

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('storecustomertransaction') }}",
        data: form_data,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            getCustomerTransactions();
            $('#transactionForm').trigger('reset');
            $('#trdescriptionError').text('').hide();
            $('#trdescription').attr('class','form-control');
            $('#tramountError').text('').hide();
            $('#tramount').attr('class','form-control');
        },
        error : function (message) {

            var description = message.responseJSON.errors.trdescription;
            var amount = message.responseJSON.errors.tramount;

            // Description
            if(description)
            {
                $('#trdescriptionError').text('').show();
                $('#trdescription').attr('class','form-control is-invalid');
                $('#trdescriptionError').text(description);
            }
            else
            {
                $('#trdescriptionError').text('').hide();
                $('#trdescription').attr('class','form-control');
            }

            // Amount
            if(amount)
            {
                $('#tramountError').text('').show();
                $('#tramount').attr('class','form-control is-invalid');
                $('#tramountError').text(amount);
            }
            else
            {
                $('#tramountError').text('').hide();
                $('#tramount').attr('class','form-control');
            }

        }
    });

}



// Get Customer Reward Points
function getCustomerRewardpoints()
{
    var cust_id = $('#cid').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('getcustomerrewardpoints') }}",
        data: { cust_id : cust_id },
        dataType: "json",
        success: function (response) {
            $('#custRewardpoints tbody').html('');
            $('#custRewardpoints tbody').html(response.rewards);
            $('#custRewardpointsSum').html('');
            $('#custRewardpointsSum').html(response.sum);
            $('#custRewardpoints').DataTable();
        }
    });
}


function addCustomerRewardpoint()
{
    var form_data = new FormData(document.getElementById('rewardForm'));

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('storecustomerrewardpoint') }}",
        data: form_data,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            getCustomerRewardpoints();
            $('#rewardForm').trigger('reset');
            $('#rdescriptionError').text('').hide();
            $('#rdescription').attr('class','form-control');
            $('#rpointsError').text('').hide();
            $('#rpoints').attr('class','form-control');
        },
        error : function (message) {

            var description = message.responseJSON.errors.rdescription;
            var points = message.responseJSON.errors.rpoints;

            // Description
            if(description)
            {
                $('#rdescriptionError').text('').show();
                $('#rdescription').attr('class','form-control is-invalid');
                $('#rdescriptionError').text(description);
            }
            else
            {
                $('#rdescriptionError').text('').hide();
                $('#rdescription').attr('class','form-control');
            }

            // Amount
            if(points)
            {
                $('#rpointsError').text('').show();
                $('#rpoints').attr('class','form-control is-invalid');
                $('#rpointsError').text(points);
            }
            else
            {
                $('#rpointsError').text('').hide();
                $('#rpoints').attr('class','form-control');
            }

        }
    });
}



// Add Ban IP
function addBanIP(ip,tdid)
{
    var ban_ip = ip;
    var td_id = tdid;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('addcustomerbanip') }}",
        data: { ip : ban_ip, td_id : td_id },
        dataType: "json",
        success: function (response) {
            $('#banip'+td_id).html('');
            $('#banip'+td_id).html(response);
        }
    });

}


// Remove Ban IP
function removeBanIP(ip,tdid)
{
    var ban_ip = ip;
    var td_id = tdid;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ url('removecustomerbanip') }}",
        data: { ip : ban_ip, td_id : td_id },
        dataType: "json",
        success: function (response) {
            $('#banip'+td_id).html('');
            $('#banip'+td_id).html(response);
        }
    });

}


// Delete Customer Address
function DelAddress(addId)
{
    var addId = addId;

    swal({
            title: "Are you sure You want to Delete It ?",
            text: "Once deleted, you will not be able to recover this Record",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete)
            {

                $.ajax({
                        type: "POST",
                        url: "{{ url('delCustomerAddress') }}",
                        data: {"_token": "{{ csrf_token() }}",'add_id':addId},
                        dataType : 'JSON',
                        success: function (data)
                        {
                            if(data.success == 1)
                            {
                                swal("Your Record has been deleted!", {
                                    icon: "success",
                                });

                                setTimeout(function(){
                                    location.reload();
                                }, 1500);
                            }
                        }
                });

            }
            else
            {
                swal("Cancelled", "", "error");
                setTimeout(function(){
                    location.reload();
                }, 1000);
            }
        });


}


</script>
