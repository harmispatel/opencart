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
                                <h2 class="card-title pt-2 m-0" style="color: black">
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
                                        <a href="{{ route('addproduct') }}" class="btn btn-sm btn-success ml-auto"><i
                                                class="fa fa-plus"></i></a>
                                    @endif

                                    @if (check_user_role(61) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table Start --}}
                                <div class="table-responsive">
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

                                        </thead>
                                        {{-- End Table Head --}}

                                        {{-- Table Body --}}
                                        <tbody class="text-center table1">
                                            {{-- <tr>
                                                <td colspan="6"></td>
                                                <td class="text-center"><button type="button" onclick="addProduct();"
                                                        data-toggle="tooltip" title="Add Product"
                                                        class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                                </td>
                                            </tr> --}}
                                        </tbody>
                                        {{-- End Table Body --}}
                                    </table>
                                </div>

                                {{-- End Table --}}
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
    var toppingType = '';
    var sizes = '';
    var data = '';
    $(document).ready(function() {
        var categoryval = $('#categorys :selected').val();

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
                category_id: categoryval
            },
            success: function(result) {
                $('.table').html('');
                $('.table').html(result.html);
            }

        });
    });

    $('#categorys').change(function() {
        var categoryval = this.value;

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
                category_id: categoryval
            },
            success: function(result) {
                $('.table').html('');
                $('.table').html(result.html);
                sizes = result.sizes;
                toppingType = result.toppingType;
                data = result.data;


                var checkdata = $('input[name=typetopping]:checked').val();
                if (checkdata == 'checkbox') {
                    radiocheck();
                } else {
                    radiocheck();
                }
            }

        });
    });

    function radiocheck() {
        var data = $('input[name=typetopping]:checked').val();

        var html = '';
        if (data == 'select') {
            $("#text").html('');
        } else if (data == 'checkbox') {
            $("#text").html('');
        }

        if (data == 'checkbox') {
            html += '<div><lable>Default selected</lable></div>';
            html += '<div><table><tbody><tr><td><input type="checkbox" name></td><td>hello</td></tbody></table></div>';

        } else if (data == 'select') {

            html += '<div><lable>Default selected</lable></div>';
            html += '<select  class="form-control" name="select[0][name]"><option></option></select>';

        }
        $("#text").append(html);
    }




    var product_row = 0;
    
    function addbulkproduct() {
    
        html = '';
        html += '<tr id="bulkproduct' + product_row + '">';
        html += '<td style="vertical-align: middle;"><input type="text" class="form-control" name="product[' + product_row + '][name]"></td>';
        html += '<td style="vertical-align: middle;"><textarea type="text" name="product" class="form-control"></textarea></td>';
        html += '<td style="vertical-align: middle;"><input type="text" name="price" class="form-control"></td>';
        var count=sizes.length;
         for(var i=0; i < count; i++){
            html += '<td style="vertical-align: middle;"><input type="text" name="abc" class="form-control"></td>';
         }
        html += '<td style="vertical-align: middle;"><input type="file" name="image" class="form-control"></td>';
        html += '<td style="vertical-align: middle;">';

        if (data.product_id == toppingType.id_product){
            html += '<h3> ' + toppingType.name_topping + '</h3>';
            html +=
                '<div style="margin-bottom: 10px;"><input type="radio" class="typetopping" name="typetopping[' +
                product_row + '][name]" onclick="radiochecked();" value="select"';

            if (toppingType.typetopping == "select") {
                html += 'checked';
            }
            html += '> Select<input type="radio" class="typetopping" name="typetopping[' + product_row +
                '][name]" onclick="radiochecked();" value="checkbox"';
            if (toppingType.typetopping == "checkbox") {
                html += 'checked';
            }
            html += '> Checkbox</div>';
            html +=
                '<div><input type="radio" name="product[' + product_row + '][enable]" value="1"';
            if (toppingType.enable == 1) {
                html += 'checked';
            }
            html += '> Enable<input type="radio"  name="product[' + product_row + '][enable]" value="0"';
            if (toppingType.enable == 0) {
                html += 'checked';
            }
            html += '>Disable</div>';
            html +=
                '<div class="form-floating"><label for="rename" class="form-label">Rename to</label><input type="text" name="renamegroup" class="form-control"></div>';
            html += '<div id="text"></div>';
        } else {
            html += 'No Topping';
        }

        html += '</td>';
        html +=
            '<td class="text-right" style="vertical-align: middle;"><button type="button"  data-toggle="tooltip" onclick="$(\'#bulkproduct' +
            product_row +
            '\').remove()" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';
        $(".table").append(html);
        product_row++;
    }

    // function radiochecked() {
    //     var data = $('input[name=product[' +
    //             product_row + '][typetopping]]:checked').val();

    //     var html = '';
    //     if (data == 'select') {
    //         $("#text1").html('');
    //     } else if (data == 'checkbox') {
    //         $("#text1").html('');
    //     }

    //     if (data == 'checkbox') {
    //         html += '<div><lable>Default selected</lable></div>';
    //         html += '<div><table><tbody><tr><td><input type="checkbox"></td><td>hello</td></tbody></table></div>';

    //     } else if (data == 'select') {

    //         html += '<div><lable>Default selected</lable></div>';
    //         html += '<select  class="form-control" name="select[0][name]"><option></option></select>';

    //     }
    //     $("#text1").append(html);
    // }
</script>
