<!--
    THIS IS REVIEW LIST FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    list.blade.php
    It Displayed All Review List & Storewise Display Review
    ----------------------------------------------------------------------------------------------
-->

{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Reviews --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if(Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Reviews</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Reviews</li>
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
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Reviews List
                                </h3>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                <table class="table table-bordered">
                                    {{-- Alert  Message Div --}}
                                    <div class="alert alert-success del-alert alert-dismissible" id="alert" style="display: none" role="alert">
                                        <p id="success-message" class="mb-0"></p>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    {{-- End Alert Message Div --}}

                                    {{-- Table Head Start --}}
                                    <thead class="text-center">
                                        <th>Review ID</th>
                                        <th>Customer Name</th>
                                        <th>Order Date</th>
                                        <th>Review Date</th>
                                        <th>Review Stars</th>
                                        <th>Review Comment</th>
                                        <th>Actions</th>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body Start --}}
                                    <tbody class="text-center review-list">
                                        @foreach ($reviews as $review )
                                            <tr>
                                                @php
                                                    $cust_name = '-';
                                                    $order_date = '-';
                                                    if(isset($review->hasOneCustomer))
                                                    {
                                                        $cust_name = $review->hasOneCustomer['firstname'].' '.$review->hasOneCustomer['lastname'];
                                                    }

                                                    if(isset($review->hasOneOrder))
                                                    {
                                                        $order_date = $review->hasOneOrder['date_added'];
                                                    }
                                                @endphp
                                                <td>{{ $review->order_id }}</td>
                                                <td>{{ $cust_name }}</td>
                                                <td>{{ date('d-m-Y',strtotime($order_date)) }}</td>
                                                <td>{{ date('d-m-Y',strtotime($review->date_added)) }}</td>
                                                <td>
                                                    @php
                                                        $cnt = $review->quality + $review->service + $review->timing;
                                                    @endphp
                                                    @if ($cnt == 15)
                                                        5
                                                    @elseif ($cnt > 13 && $cnt <= 14)
                                                        4.5
                                                    @elseif ($cnt >= 12 && $cnt <= 13 )
                                                        4
                                                    @elseif ($cnt > 10 && $cnt < 12 )
                                                        3.5
                                                    @elseif ($cnt > 8 && $cnt <= 10 )
                                                        3
                                                    @elseif ($cnt > 6 && $cnt <= 8 )
                                                        2.5
                                                    @elseif ($cnt > 4 && $cnt <= 6 )
                                                        2
                                                    @elseif ($cnt > 2 && $cnt <= 4 )
                                                        1.5
                                                    @elseif ($cnt >= 1 && $cnt <= 2 )
                                                        1
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>{{ $review->message }}</td>
                                                <td>
                                                    <div class="btn-group" role="group" style="height: 30px;" id="reviewStatus">
                                                        @if ($review->status == 1)
                                                            <button class="btn btn-xs btn-success" onclick="reviewStatus(1,{{ $review->store_review_id }})">Enabled</button>
                                                            <button class="btn btn-xs btn-secondary" onclick="reviewStatus(0,{{ $review->store_review_id }})">Disabled</button>
                                                        @else
                                                            <button class="btn btn-xs btn-secondary" onclick="reviewStatus(1,{{ $review->store_review_id }})">Enabled</button>
                                                            <button class="btn btn-xs btn-danger" onclick="reviewStatus(0,{{ $review->store_review_id }})">Disabled</button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    {{-- End Table Body --}}
                                </table>
                                {{-- End Table --}}
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
{{-- End Section of List Manufacturers --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">


    $(document).ready(function(){

        // Data Table of Manufacturers List
        $('.table').DataTable();

    });

    // Review Status Enabled Disabled
    function reviewStatus(val,rid)
    {
        $.ajax({
            type: "POST",
            url: "{{ url('reviewStatus') }}",
            data: {'val':val,"_token": "{{ csrf_token() }}",'rid':rid},
            dataType: "json",
            success: function (response) {

               if(response.success == 1)
               {
                   location.reload();
               }
            }
        });
    }
    // End Review Status Enabled Disabled

</script>


