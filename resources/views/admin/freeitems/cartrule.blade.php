{{-- Header --}}
@include('header')
{{-- End Header --}}

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
                        <h1>Cart Rules</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Cart Rules</li>
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
                        {{-- Card --}}
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Cart Rules List
                                </h3>
                                <div class="container" style="text-align: right">
                                    @if (check_user_role(71) == 1)
                                        <a href="{{ route('addfreerule') }}"
                                        class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    @endif

                                    @if (check_user_role(73) == 1)
                                        <a class="btn btn-sm btn-danger ml-auto deletesellected">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                <table class="table table-bordered table-striped" id="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" name="checkall" id="delall">
                                            </th>
                                            <th>Name Item</th>
                                            <th>Total Above</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartrul as $rule)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="del_all" value="{{ $rule->id_rule }}" class="del_all">
                                                </td>
                                                <td>{{ $rule->name_rule }}</td>
                                                <td>{{ $rule->min_total }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="{{ url('editfreerule') }}/{{ $rule->id_rule }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
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


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- SCRIPT --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    $(document).ready(function()
    {
        $('#table').DataTable();
    });


    // Select All Checkbox
    $('#delall').on('click', function(e)
    {
        if ($(this).is(':checked', true))
        {
            $(".del_all").prop('checked', true);
        }
        else
        {
            $(".del_all").prop('checked', false);
        }
    });
    // End Select All Checkbox


    // Delete Multiple Cart Rules
    $('.deletesellected').click(function()
    {
        var checkValues = $('.del_all:checked').map(function()
        {
            return $(this).val();
        }).get();

        if (checkValues != '')
        {
            swal({
                    title: "Are you sure You want to Delete It ?",
                    text: "Once deleted, you will not be able to recover this Record",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) =>
                {
                    if (willDelete)
                    {
                        $.ajax({
                                type: "POST",
                                url: '{{ url('cartruledelete') }}',
                                data: {
                                        "_token": "{{ csrf_token() }}",
                                        'id': checkValues
                                },
                                dataType: 'JSON',
                                success: function(data)
                                {
                                    if (data.success == 1)
                                    {
                                        swal("Your Record has been deleted!", {
                                            icon: "success",
                                        });

                                        setTimeout(function()
                                        {
                                            location.reload();
                                        }, 1500);
                                    }
                                }
                        });
                    }
                    else {
                        swal("Cancelled", "", "error");
                        setTimeout(function()
                        {
                            location.reload();
                        }, 1000);
                    }
                });
        }
        else
        {
            swal("Please select atleast One Cart Rule", "", "warning");
        }
    });
    // End Delete Multiple Cart Rules

</script>
{{-- END SCRIPT --}}
