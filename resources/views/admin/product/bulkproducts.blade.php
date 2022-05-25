@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Bulk Products --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bulk Products</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bulk Products </li>
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
                                <h2 class="card-title pt-2 m-0" style="color: black ;display: flex;
                                align-items: baseline;">
                                    <i class="fa fa-cog fw"></i>&nbsp;&nbsp;
                                    category &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="category" id="categorys" style="width: 70%">
                                        @foreach ($category as $categorys)
                                            <option value="{{ $categorys->category_id }}">{{ $categorys->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </h2>
                                {{-- <h3>category</h3> --}}
                                <div class="container" style="text-align: right">
                                    @if (check_user_role(59) == 1)
                                        <button type="submit" form="bulkP" class="btn btn-sm btn-success ml-auto"><i
                                                class="fa fa-plus"></i></button>
                                    @endif

                                    @if (check_user_role(61) == 1)
                                        <a href="{{ route('products') }}"
                                            class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                <form action="{{ route('storebulkproduct') }}" method="POST"
                                    enctype="multipart/form-data" id="bulkP">
                                    @csrf

                                    <input type="hidden" name="category" id="demo" value="">
                                    {{-- Table Start --}}
                                    <div class="table-responsive">
                                        <table border="2">
                                            <thead id="thead">
                                            </thead>
                                            <tbody id="productAdd">
                                            <tfoot>
                                                <tr class="">
                                                    <td colspan="6">
                                                        <div align="right">
                                                            <button type="button" style="margin-left: 20px"
                                                                onclick="addMoreProduct();" class="btn btn-primary ">
                                                                <i class="fa fa-plus-circle"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- End Table --}}
                                </form>
                            </div>
                            {{-- End Card Body --}}
                        </div>
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



<script>
    $(document).ready(function() {
        var categoryval = $('#categorys :selected').val();
        $("#demo").val(categoryval);
        getcategoryval(categoryval, "new");
        // radiocheck(1,1);
    });

    $('#categorys').change(function() {
        var categoryval = this.value;
        // alert(categoryval);
        $("#demo").val(categoryval);
        $('#productAdd').html('');
        getcategoryval(categoryval, "new");
    });

    function getcategoryval(categoryval, ctype = "") {
        var total = $('.productone').length;
        var lastid = total;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "post",
            url: "{{ route('getcategoryproduct') }}",
            dataType: "json",
            data: {
                category_id: categoryval,
                lastid: lastid
            },
            success: function(result) {
                if (ctype != "append") {
                    $('#productAdd').html('');
                }
                $('#productAdd').append(result.html);

                // if(ctype != "append"){
                //     $('#thead').html('');
                // }
                if (ctype == "new") {
                    $('#thead').html('');
                    $('#thead').append(result.thead);
                }
                reset_values();


            }

        });
    }

    var x = 1;
    var count = 0;

    function addMoreProduct() {

        var total = $('.productone').length;
        if (total != 0) {
            x = total + 1;
        } else {
            x = 1;
        }
        var categoryval = $("#categorys").val();

        getcategoryval(categoryval, "append");
        count++;
        x++;

    }

    $("body").on("click", ".delete_option", function() {
        $(this).closest('.productone').remove();
        count--;
        reset_values();
    });

    function reset_values() {
        var count = 1;
        $(".productone").each(function() {
            var id = $(this).attr("id", "productone" + count);
            count++;
        });
    }


    function radiocheck(lid, key) {

        var cls = '.typetopping_' + lid + '_' + key;
        var data = $("input[type='radio']" + cls + ":checked").val();

        var html = '';
        //    if (data == 'select') {
        //        $('#text_'+lid+'_'+key).html('');
        //    } else if (data == 'checkbox') {
        //        $('#text_'+lid+'_'+key).html('');
        //    }

        if (data == 'checkbox') {

            $('#checkbox_' + lid + '_' + key).show();
            $('#select_' + lid + '_' + key).hide();
        } else if (data == 'select') {

            $('#select_' + lid + '_' + key).show();
            $('#checkbox_' + lid + '_' + key).hide();
        }
    }
</script>
