@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Menu Options --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Group Topping</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Menu Options</li>
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
                        <div class="card-header" style="background: #f6f6f6">
                            <h1 class="card-title pt-2 m-0" style="color: black">
                                New Module &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" value="1" checked> Enable &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" value="0" > Disable
                            </h1>

                            {{-- <h3>category</h3> --}}
                            <div class="container" style="text-align: right">
                                @if (check_user_role(59) == 1)
                                    <a href="{{ route('addmenuoptions') }}" class="btn btn-sm btn-success ml-auto"><i
                                            class="fa fa-plus"></i></a>
                                @endif

                                @if (check_user_role(61) == 1)
                                    <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                            class="fa fa-trash"></i></a>
                                @endif
                            </div>

                        </div>
                        {{-- End Card --}}
                        {{-- Card Body --}}
                        <div class="card-body">
                            {{-- Table Start --}}
                            <table class="table table-bordered">
                                {{-- Alert Message div --}}
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
                                {{-- End Alert Message div --}}

                                {{-- Table Head --}}
                                <thead class="text-center">
                                    <th>
                                        <input type="checkbox" name="checkall" id="delall">
                                    </th>
                                    <th id="name">Name</th>
                                    <th id="action">Action</th>
                                </thead>
                                {{-- End Table Head --}}

                                {{-- Table Body --}}
                                <tbody class="text-center cat-list">
                                    {{-- <tr>
                                        <td></td>
                                        <td></td>
                                        {{-- <td> <a href="#" class="btn btn-sm btn-primary rounded"><i
                                                    class="fa fa-edit"></i></a></td> --}}
                                    </tr>
                                </tbody>
                                {{-- End Table Body --}}
                            </table>
                            {{-- End Table --}}
                        </div>
                        {{-- End Card Body --}}
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
    $(document).ready(function() {
        $('.table').DataTable();
    });
</script>
