@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Cart Rule --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if (Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cart Rule</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Cart Rule</li>
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
                            {{-- <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Cart Rule
                                </h3>

                                <div class="container" style="text-align: right">
                                    @if (check_user_role(71) == 1)
                                        <a href="{{ route('addfreerule') }}"
                                            class="btn btn-sm btn-primary ml-auto px-1">Insert</a>
                                    @endif

                                    @if (check_user_role(73) == 1)
                                        <a href="#"
                                            class="btn btn-sm btn-danger ml-auto px-1 deletesellected">Delete</a>
                                    @endif
                                </div>
                            </div> --}}
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                <table class="table table-bordered" id="table">
                                    {{-- Alert Message Div --}}
                                    <div class="alert alert-success del-alert alert-dismissible" id="alert"
                                        style="display: none" role="alert">
                                        <p id="success-message" class="mb-0"></p>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    {{-- End Alert Message Div --}}

                                    {{-- Table Head Start --}}
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input type="checkbox" name="checkall" id="delall"></th>
                                                <th scope="col">Name Item</th>
                                                <th scope="col">Total Above</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cartrul as $rule)
                                                <tr>
                                                    <td><input type="checkbox" name="del_all" value="{{ $rule->id_rule }}" class="del_all"></td>
                                                    <td>{{ $rule->name_rule }}</td>
                                                    <td>{{ $rule->min_total }}</td>
                                                    <td><a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
{{-- End Section of List Cart Rule --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    // $(document).ready(function() {
    //     $('#table').DataTable();
    // });

    // Select All Checkbox
    $('#delall').on('click', function(e) {
        if ($(this).is(':checked', true)) {
            $(".del_all").prop('checked', true);
        } else {
            $(".del_all").prop('checked', false);
        }
    });
    // End Select All Checkbox

    // Delete Multiple User
    $('.deletesellected').click(function() {
        var checkValues = $('.del_all:checked').map(function() {
            return $(this).val();
        }).get();

        if (checkValues != '') {
            swal({
                    title: "Are you sure You want to Delete It ?",
                    text: "Once deleted, you will not be able to recover this Record",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "POST",
                            url: '{{ url('coupondelete') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': checkValues
                            },
                            dataType: 'JSON',
                            success: function(data) {
                                if (data.success == 1) {
                                    swal("Your Record has been deleted!", {
                                        icon: "success",
                                    });

                                    setTimeout(function() {
                                        location.reload();
                                    }, 1500);
                                }
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
        } else {
            swal("Please select atleast One Record", "", "warning");
        }
    });
    // End Delete User
</script>
