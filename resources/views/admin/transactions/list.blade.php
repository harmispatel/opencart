{{--
    THIS IS TRANSACTION PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    list.blade.php
    it is used for get all stores transaction Details Like -:
    ---------------------------------------------------------
    - No. of Rejected Orders
    - Rejected Orders Total
    - No. of Accepted Orders
    - Accepted Orders Total
    - Commission Total
    - Accepted Reataurant Net
    ----------------------------------------------------------------------------------------------
--}}


{{-- Header Section --}}
@include('header')
{{-- End Header Section --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Transactions --}}
<section>
    <div class="content-wrapper">
        {{-- Breadcumb Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Transactions</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Transactions </li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Breadcumb Section --}}

        {{-- List Section Start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card card-primary">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #424e64">
                                <h3 class="card-title pt-2">
                                    <i class="fa fa-list"></i>
                                    Transactions List
                                </h3>
                                <form action="daterange" method="post">
                                    <div class="container" style="text-align: right">
                                        <input type="text" name="daterange" id="daterange" value="" />
                                    </div>
                                </form>

                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                <table class="table table-bordered" id="transaction">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success del-alert alert-dismissible" id="alert"
                                            role="alert">
                                            {{ Session::get('success') }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <thead class="text-center">
                                        <th>STORE NAME</th>
                                        <th class="text-danger">NO OF REJECTED ORDERS</th>
                                        <th class="text-danger">REJECTED ORDERS TOTAL</th>
                                        <th class="text-green">NO OF ACCEPTED ORDERS</th>
                                        <th class="text-green">ACCEPTED ORDERS TOTAL</th>
                                        <th>COMMISION TOTAL</th>
                                        <th class="text-green">ACCEPTED RESTAURANT NET</th>
                                    <tbody id="customerorder">
                                        <tr id="status" style="display: none;">
                                            <td colspan="7" class="text-center"><img src="{{ asset('public/admin/gif/gif3.gif') }}" alt=""></td>
                                        </tr>
                                        <tr id="message" style="display: none">
                                            <td colspan="7" class="text-center">Transaction Not Avavilable</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="text-center cat-list">
                                        <tr class="bg-secondary">
                                            <td>TOTALS</td>
                                            <td id="rejected">0</td>
                                            <td id="rejected_amt">£0.00</td>
                                            <td id="accept">0</td>
                                            <td id="accept_tot">£0.00</td>
                                            <td id="commission">£0.00</td>
                                            <td id="totle">£0.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
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
{{-- End Section of List Trasnsactions --}}


{{-- Footer Section --}}
@include('footer')
{{-- End Footer Section --}}


{{-- SCRIPT --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        $(function() {

            $('input[id="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                $('#message').hide();
                $('#status').show();
                var startdate = start.format('YYYY-MM-DD');
                var enddate = end.format('YYYY-MM-DD');
                $.ajax({
                    type: "post",
                    url: "{{ route('daterange') }}",
                    data: {
                        'start': startdate,
                        'end': enddate,
                    },
                    success: function(response) {
                        $('#customerorder').html(response.customerorder);
                        $('#rejected').text('');
                        $('#rejected').append(response.reject);
                        $('#rejected_amt').text('');
                        $('#rejected_amt').append(response.reject_amt);
                        $('#accept').text('');
                        $('#accept').append(response.accept);
                        $('#accept_tot').text('');
                        $('#accept_tot').append(response.accept_tot);
                        $('#commission').text('');
                        $('#commission').append(response.commission);
                        $('#totle').text('');
                        $('#totle').append(response.totle);
                        $('#status').hide();
                        if (response.status == 200) {
                            $('#message').show();
                        }
                    },
                    error: function(response){
                        $('#message').show();
                    }
                });
            });
        });

    });
</script>
{{-- END SCRIPT --}}
