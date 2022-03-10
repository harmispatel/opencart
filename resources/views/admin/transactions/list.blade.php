@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Transactions --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
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
        {{-- End Header Section --}}

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

                                <div class="container" style="text-align: right">
                                    <input type="text" name="daterange" value=""/>
                                </div>

                            </div>
                            {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <table class="table table-bordered" id="transaction">
                                        @if(Session::has('success'))
                                        <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                                                {{ Session::get('success') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                                        <tbody class="text-center cat-list">
                                            <tr class="bg-secondary">
                                                <td colspan="7">
                                                    Comming Soon
                                                </td>
                                            </tr>
                                        </tbody>
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



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

// $(document).ready(function() {
//     $('#transaction').DataTable();
// } );

// Date Range Picker
$(function() {
    $('input[name="daterange"]').daterangepicker();
});


</script>
