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
                                    <table border="2">
                                        <thead id="thead">
                                           
                                        </thead>
                                        <tbody id="productAdd">
                                            
                                            <tfoot>
                                                <tr class="">
                                                    <td colspan="6">
                                                        <div align="right"><button type="button" style="margin-left: 20px" onclick="addMoreProduct();" class="btn btn-primary ">
                                                                <i class="fa fa-plus-circle"></i>
                                                            </button></div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </tbody>
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
   
   $(document).ready(function() {
        var categoryval = $('#categorys :selected').val();
        getcategoryval(categoryval,"new");
    });

    $('#categorys').change(function() {
        var categoryval = this.value;
        getcategoryval(categoryval,"new");
    });

    function getcategoryval(categoryval,ctype=""){
        var total = $('.productone').length;
        var lastid = total ;
       
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
                lastid:lastid
            },
            success: function(result) {
                if(ctype != "append"){
                    $('#productAdd').html('');
                }
                $('#productAdd').append(result.html);

                // if(ctype != "append"){
                //     $('#thead').html('');
                // }
                if(ctype == "new"){
                    $('#thead').html('');
                    $('#thead').append(result.thead);  
                }
                reset_values();

            
            }

        });
    }

    var x=1;
    var count = 0;
    
    function addMoreProduct(){
        
        var total = $('.productone').length;
        if(total != 0){
            x = total + 1;
        }else{
            x = 1;
        }
        var categoryval = $("#categorys").val();
       
        getcategoryval(categoryval,"append");
        count++;
        x++;
        
    }

    $("body").on("click",".delete_option" ,function(){
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

    

   
    // var product_row = 0;

    // function addbulkproduct() {
    //     product_row++;
    //     html = '';
    //     html += '<tr id="bulkproduct' + product_row + '">';
    //     html += '<td style="vertical-align: middle;"><input type="text" class="form-control" name="product[' +
    //         product_row + '][name]"></td>';
    //     html += '<td style="vertical-align: middle;"><textarea type="text" name="product[' + product_row +
    //         '][discription]" class="form-control"></textarea></td>';
    //     html += '<td style="vertical-align: middle;"><input type="text" name="product[' + product_row +
    //         '][price]" class="form-control"></td>';


    //      $.each(sizes, function (key, value) { 
              
    //          html += '<td style="vertical-align: middle;"><input type="text" name="product[' + product_row +
    //              '][price]" class="form-control"></td>';
    //      });    
       

    //     html += '<td style="vertical-align: middle;"><input type="file" name="product[' + product_row +
    //         '][image]" class="form-control"></td>';
    //     html += '<td style="vertical-align: middle;">';

    //     if (data == '') {
    //         html += '<b>No Topping</b>';
    //     } else {

    //         if (group == null || group == '') {
    //             html += '<b>No Topping</b>';
    //         } else {
    //             $.each(group, function(key, value) {
                    
    //                 if (data.product_id == value.id_product) {
    //                     html += '<h3> ' + value.name_topping + '</h3>';
    //                     html +=
    //                         '<div style="margin-bottom: 10px;"><input type="radio" class="typetopping" name="product[' + product_row + '][typetopping]"  value="select"';

    //                     if (value.typetopping == "select") {
    //                         html += 'checked';
    //                     }

    //                     html += '> Select&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="typetopping" name="product[' + product_row + '][typetopping]"  value="checkbox"';

    //                     if (value.typetopping == "checkbox") {
    //                         html += 'checked';
    //                     }

    //                     html += '> Checkbox&nbsp;&nbsp;&nbsp;&nbsp;</div>';
    //                     html += '<div><input type="radio" name="product[' + product_row +
    //                     '][enable]" value="1"';

    //                     if (value.enable == 1) {
    //                         html += 'checked';
    //                     }

    //                     html += '> Enable&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"  name="product[' +
    //                         product_row + '][enable]" value="0"';

    //                     if (value.enable == 0) {
    //                         html += 'checked';
    //                     }

    //                     html += '>Disable</div>';
    //                     html +=
    //                         '<div class="form-floating"><label for="rename" class="form-label">Rename to</label><input type="text" name="product[' +
    //                         product_row + '][renamegroup]" class="form-control"></div>';
    //                     html += '<div id="text"></div>';
    //                 } else {
    //                     html += '<b>No Topping</b>';
    //                 }
    //             });

    //         }

    //     }


    //     $(".table").append(html);

    // }

    // function radiocheck() {
    //     var data = $('input[name=typetopping]:checked').val();

    //     var html = '';
    //     if (data == 'select') {
    //         $("#text").html('');
    //     } else if (data == 'checkbox') {
    //         $("#text").html('');
    //     }

    //     if (data == 'checkbox') {
    //         html += '<div><lable>Default selected</lable></div>';
    //         html += '<div><table><tbody><tr><td><input type="checkbox"></td><td>hello</td></tbody></table></div>';

    //     } else if (data == 'select') {

    //         html += '<div><lable>Default selected</lable></div>';
    //         html += '<select  class="form-control" name="select[0][name]"><option></option></select>';

    //     }
    //     $("#text").append(html);
    // }
</script>
