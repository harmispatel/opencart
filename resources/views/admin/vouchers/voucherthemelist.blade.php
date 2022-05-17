{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Voucher Themes --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Voucher Themes</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Voucher Themes</li>
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
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Voucher Themes List
                                </h3>
                                <div class="container" style="text-align: right">
                                    <a href="{{ route('voucherthemeinsert') }}" class="btn btn-sm btn-primary ml-auto">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                <table class="table table-bordered table-hover" id="table">
                                    {{-- Table Head --}}
                                    <thead class="">
                                        <tr>
                                            <th><input type="checkbox" name="del_all" id="delall"></th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body --}}
                                    <tbody class="cat-list">
                                        @foreach ($data as $voucher)
                                            <tr>
                                                <td><input type="checkbox" name="del_all" class="del_all" value="{{ $voucher->voucher_theme_id }}"></td>

                                                <td>{{ $voucher->name }}</td>

                                                <td><a class="btn btn-sm btn-primary" href=" {{ url('voucherthemeedit/'.$voucher->voucher_theme_id) }}"><i class="fa fa-edit"></i></a></td>

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
        {{-- End List Section --}}
    </div>
</section>
{{-- End Section of List Voucher Themes --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- SCRIPT --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    $(document).ready( function ()
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

    // Delete Multiple Voucher Theme
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
                            url: '{{ url('voucherthemedelete') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': checkValues
                            },
                            dataType: 'JSON',
                            success: function(data) {
                                if (data.success == 1)
                                {
                                    swal("Your Record has been deleted!",
                                    {
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
                    else
                    {
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
            swal("Please select atleast One Record", "", "warning");
        }
    });
    // End Delete Multiple Voucher Theme

</script>
{{-- END SCRIPT --}}
