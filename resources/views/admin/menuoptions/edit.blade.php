{{--
    THIS IS HEADER MenuOptionedit PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    edit.blade.php
    This for Edit MenuOption
    ----------------------------------------------------------------------------------------------
--}}


{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{--Style Section--}}
<style>
    .radioenable {
        display: none;
    }
    .radiodisable {
        display: none;
    }

    .radioenable:checked+label {
        background: green !important;
        color: #fff !important;
    }
    .radiodisable:checked+label {
        background: red !important;
        color: #fff !important;
    }
</style>

{{--End Style Section--}}


{{-- Section of Edit Topping --}}
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
                            <li class="breadcrumb-item"><a href="{{ route('option') }}">Menu Options</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Edit Topping Section --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card">
                            {{-- Form --}}
                            <form action="{{ route('updatetopping') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fas fa-pencil-alt pr-2"></i>
                                        EDIT
                                    </h3>
                                    <div class="container" style="text-align: right;">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a href="{{ route('option') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id_topping" value="{{ $topping->id_topping }}">
                                        <label for="groupName"><span class="text-danger">*</span> Group Name</label>
                                        <input type="text" name="groupName" id="groupName" class="form-control {{ ($errors->has('groupName')) ? 'is-invalid' : '' }}" value="{{ $topping->name_topping }}">
                                        @if ($errors->has('groupName'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('groupName') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {{-- Tabs Link --}}
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link" id="items-tab" data-toggle="tab" href="#items" role="tab" aria-controls="items" aria-selected="false">Items</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="options-tab" data-toggle="tab" href="#options" role="tab" aria-controls="options" aria-selected="false">Options</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" id="mappings-tab" data-toggle="tab" href="#mappings" role="tab" aria-controls="mappings" aria-selected="true">Mappings</a>
                                            </li>
                                        </ul>
                                        {{-- End Tabs Link --}}

                                        {{-- Tab Content --}}
                                        <div class="tab-content pt-4" id="myTabContent">
                                            {{-- Items Tab --}}
                                            <div class="tab-pane fade show" id="items" role="tabpanel" aria-labelledby="items-tab">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Price Main</th>
                                                                    <th>Order</th>
                                                                    <th>Sub Options</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="size-value-row_12" id="listTopping">

                                                                {{-- Dynamic Topping Option Count --}}
                                                                    @php
                                                                    $count = count($toppingoptions);
                                                                    if ($count != '') {
                                                                        // $newcount = $count + 1;
                                                                        echo '<input type="hidden" name="number_option" id="number_option" value="'.$count.'">';
                                                                    }
                                                                    else {
                                                                        echo '<input type="hidden" name="number_option" id="number_option" value="1">';
                                                                    }
                                                                @endphp
                                                                {{-- End Dynamic Topping Option Count --}}

                                                                @foreach ($toppingoptions as $toppingoption)
                                                                    <tr class="option_{{ $loop->iteration }}">
                                                                        <td class="align-middle">
                                                                            <input type="hidden" name="optiontopping[{{ $loop->iteration }}][id_topping_option]" value="{{ $toppingoption->id_topping_option }}">
                                                                            <input type="text" name="optiontopping[{{ $loop->iteration }}][name]" class="form-control" value="{{ $toppingoption->name }}">
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <input type="text" name="optiontopping[{{ $loop->iteration }}][price_main]" class="form-control" value="{{ $toppingoption->price_main }}">
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <input type="text" name="optiontopping[{{ $loop->iteration }}][order]" class="form-control" value="{{ $toppingoption->order }}">
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <select name="optiontopping[{{ $loop->iteration }}][sub_option][]" class="form-control" multiple="multiple">
                                                                                @foreach ($suboptions as $suboption)
                                                                                    @php
                                                                                        $sub_opt = unserialize($toppingoption->sub_option);
                                                                                    @endphp
                                                                                    @if(!empty($sub_opt) || $sub_opt != '')
                                                                                        <option value="{{ $suboption->id_topping }}" {{ (in_array($suboption->id_topping,$sub_opt) == $suboption->id_topping) ? 'selected' : '' }}>{{ $suboption->name_topping }}</option>
                                                                                    @else
                                                                                        <option value="{{ $suboption->id_topping }}">{{ $suboption->name_topping }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <a class="btn btn-danger" onclick="DelTopping({{ $toppingoption->id_topping_option }})">
                                                                                <i class="fa fa-minus-circle"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="5" class="text-center">
                                                                        <div class="btn-group">
                                                                            <input type="number" name="addNumber" value="1" min="1"/>

                                                                            <button type="button" style="margin-left: 20px" onclick="addoption();" class="btn btn-primary">
                                                                                <i class="fa fa-plus-circle"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Items Tab --}}

                                            {{-- Options Tab --}}
                                            <div class="tab-pane fade show" id="options" role="tabpanel" aria-labelledby="options-tab">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-stripped table-hover">
                                                            <tr>
                                                                <th><label>Print Group Title</label></th>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <input type="radio" class="radioenable" id="enable" name="show_group_title" value="1" {{ ($topping->show_group_title == 1) ? 'checked' : '' }}/>
                                                                        <label class="btn btn-sm" style="background: black;color:white;" for="enable">Enable</label>
                                                                        <input type="radio" class="radiodisable" id="disable" name="show_group_title" value="0" {{ ($topping->show_group_title == 0) ? 'checked' : '' }} />
                                                                        <label class="btn btn-sm" style="background: black;color: white;" for="disable">Disable</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <label for="group_title_color">Title Front Color</label>
                                                                </th>
                                                                <td>
                                                                    <input class="form-control" type="color"
                                                                    name="group_title_color" value="#{{ $topping->group_title_color }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <label for="topping_header_message">Header Message</label>
                                                                </th>
                                                                <td>
                                                                    <input type="text" name="topping_header_message" value="{{ $topping->topping_header_message }}" class="form-control" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <label for="topping_footer_message">Footer Message:</label>
                                                                </th>
                                                                <td>
                                                                    <input type="text" name="topping_footer_message" value="{{ $topping->topping_footer_message }}"  class="form-control"/>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Options Tab --}}
                            </form>
                            {{-- End Form --}}

                                            {{-- Mappings Tab --}}
                                            <div class="tab-pane fade show active" id="mappings" role="tabpanel" aria-labelledby="mappings-tab">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <a class="btn btn-sm btn-success" id="mybtn1" onclick="show_add_form()">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                        <a class="btn btn-sm btn-danger deletesellected" id="mybtn2">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <form method="POST" enctype="multipart/form-data" id="mappingForm">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <th><input type="checkbox" name="checkall" id="delall"></th>
                                                                        <th>Order Type</th>
                                                                        <th>Category</th>
                                                                        <th>Product</th>
                                                                        <th>Rename</th>
                                                                        <th>Size</th>
                                                                        <th>Min Item</th>
                                                                        <th>Max Item</th>
                                                                        <th>Days</th>
                                                                        <th>Time Start</th>
                                                                        <th>Time End</th>
                                                                        <th>No. Free</th>
                                                                        <th>Price</th>
                                                                        <th>Sub Options</th>
                                                                        <th>Style</th>
                                                                        <th>Sort Order</th>
                                                                        <th>Action</th>
                                                                    </thead>
                                                                    <tbody id="mapping_optn_tbody">
                                                                        @foreach ($optionsmappings as $omapping)
                                                                            <tr class="trow{{ $omapping->id }}">
                                                                                <td>
                                                                                    <input type="checkbox" name="del_all" class="del_all" value="{{ $omapping->id }}">
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->order_type }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ isset($omapping->hasOneCategoryDescription->cname) ? $omapping->hasOneCategoryDescription->cname : '*' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ isset($omapping->hasOneProductDescription->pname) ? $omapping->hasOneProductDescription->pname : '*' }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->topping_rename }}
                                                                                </td>
                                                                                @php
                                                                                    $toppingname = isset($omapping->hasOneToppingSize->sizename) ? $omapping->hasOneToppingSize->sizename : '*';
                                                                                    $sizename = html_entity_decode($toppingname);
                                                                                @endphp
                                                                                <td>
                                                                                    {{ $sizename }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->min_item }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->max_item }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->days }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->start_time }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->end_time }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->no_free }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->price }}
                                                                                </td>
                                                                                <td>
                                                                                    @php
                                                                                        $sub_opt_names = get_sub_opt_names($omapping->sub_option);
                                                                                    @endphp
                                                                                    {{ $sub_opt_names }}
                                                                                </td>
                                                                                <td>
                                                                                    @php
                                                                                        $style_rep =  str_replace('_',' ',$omapping->style)
                                                                                    @endphp
                                                                                    {{ strtoupper($style_rep) }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $omapping->sort_order }}
                                                                                </td>
                                                                                <td>
                                                                                    <a class="btn btn-sm btn-primary" onclick="editoptionmapping({{ $omapping->id }})"><i class="fa fa-edit"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Mappings Tab --}}
                                        </div>
                                        {{-- End Tab Content --}}
                                    </div>
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
{{-- End Section of Add Category --}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


<script  src="https://cdnjs.cloudflare.com/ajax/libs/color-js/1.0.1/color.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

{{-- SCRIPT --}}
<script type="text/javascript">

    // Add Topping Option
    var number_option = $('#number_option').val();

    function addoption()
    {
        var add_number = $('input[name="addNumber"]').val();
        for (i = 0; i < add_number; i++)
        {
            number_option++;
            var html = '<tr class="option_' + number_option +
                '"><td class="align-middle"><input type="text" value="" name="optiontopping['+number_option+'][name]" class="form-control" placeholder="Item Name" /></td>';
            html += '<td class="align-middle"><input type="text" value="" name="optiontopping['+number_option+'][price_main]" class="form-control" placeholder="Price" /></td>';
            html += '<td class="align-middle"><input type="text" value="" class="form-control" name="optiontopping['+number_option+'][order]" placeholder="Sort Order" /></td>';
            html += '<td><select name="optiontopping['+number_option+'][sub_option][]" multiple="multiple" class="form-control">@foreach($suboptions as $suboption)<option value="{{ $suboption->id_topping }}">{{ $suboption->name_topping }}</option>@endforeach</select></td>';
            html += '<td class="align-middle"><a onclick="$(\'.option_' + number_option +
                '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
            $('#listTopping').append(html);
        }
    }
    // End Add Topping Option


    // Delete Topping Option
    function DelTopping(topId)
    {
        var top_opt_Id = topId;

        swal({
                title: "Are you sure You want to Delete It ?",
                text: "Once deleted, you will not be able to recover this Record",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete)
                {

                    $.ajax({
                            type: "POST",
                            url: "{{ url('delToppingOption') }}",
                            data: {"_token": "{{ csrf_token() }}",'top_opt_Id':top_opt_Id},
                            dataType : 'JSON',
                            success: function (data)
                            {
                                if(data.success == 1)
                                {
                                    swal("Your Record has been deleted!", {
                                        icon: "success",
                                    });

                                    setTimeout(function(){
                                        location.reload();
                                    }, 1500);
                                }
                            }
                    });

                }
                else
                {
                    swal("Cancelled", "", "error");
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
            });
    }
    // End Delete Topping Option


    // Add Mapping
    function show_add_form()
    {
        var html = '';
        html += '<tr>';

        html += '<td></td>';

        html += '<td class="align-middle"><select name="order_type"><option value="*">*</option><option value="delivery">Delivery</option><option value="collection">Collection</option></select><input type="hidden" name="top_id" value="{{ $topping->id_topping }}"></td>';

        html += '<td class="align-middle"><select name="category" onchange="getproduct(this);"><option value=""> * </option>@foreach($categoriesbystore as $category)<option value="{{ isset($category->hasOneCategoryDescription->category_id) ? $category->hasOneCategoryDescription->category_id : '' }}">{{ isset($category->hasOneCategoryDescription->cname) ? $category->hasOneCategoryDescription->cname : '' }}</option>@endforeach</select></td>';

        html += '<td class="align-middle"><select class="product" name="product"><option value=""> * </option>@foreach($productsbystore as $product)<option value="{{ $product->hasOneProductDescription->product_id }}">{{ isset($product->hasOneProductDescription->pname) ? $product->hasOneProductDescription->pname : '' }}</option>@endforeach</select></td>';

        html += '<td class="align-middle"><input type="text" name="topping_rename"></td>';

        // html += '<td class="align-middle"><select name="size"><option value="*">*</option>@foreach($toppingsizebystore as $size)<option value="{{ $size->size_id }}">{{ $size->tsize }}</option>@endforeach</select></td>';

        html += '<td class="align-middle"><select class="productsize" name="size"><option value="*">*</option>@foreach($toppingsizebystore as $size) @foreach($size->hasManyToppingSize as $tsize)<option value="{{ $tsize["id_size"] }}">{{ $tsize["size"] }}</option>@endforeach @endforeach</select></td>';

        html += '<td class="align-middle"><input type="number" name="min_item" value="1"></td>';

        html += '<td class="align-middle"><input type="number" name="max_item" value="5"></td>';

        html += '<td class="align-middle"><select name="days[]" multiple><option value="Sun">Sunday</option><option value="Mon">Monday</option><option value="Tue">Tuesday</option><option value="Wed">Wedensday</option><option value="Thu">Thursday</option><option value="Fri">Friday</option><option value="Sat">Saturday</option></select></td>';

        html += '<td class="align-middle"><input type="time" name="start_time"></td>';

        html += '<td class="align-middle"><input type="time" name="end_time"></td>';

        html += '<td class="align-middle"><input type="number" name="num_free"></td>';

        html += '<td class="align-middle"><input type="number" name="price"></td>';

        html += '<td class="align-middle"><select name="sub_option[]" multiple>@foreach($suboptions as $suboption)<option value="{{ $suboption->id_topping }}">{{ $suboption->name_topping }}</option>@endforeach</select></td>';

        html += '<td class="align-middle"><select name="style"><option value="tick_boxes">Tick Boxes</option><option value="button_box">Button Box</option></select></td>';

        html += '<td class="align-middle"><input type="number" name="sort_order"></td>';

        html += '<td class="align-middle"><a class="btn btn-sm btn-success" onclick="storeMapping()"><i class="fa fa-save"></i></a></td>'

        html += '</tr>';

        $('#mapping_optn_tbody').append(html);
        $('#mybtn1').hide();
    }
    // End Add Mapping


    // get product by category
    function getproduct(elem) {
        let cat_id = $(elem).val();

        let categoryId = (cat_id != '') ? cat_id : 0;

        $.ajax({
            type: "get",
            url: "{{ url('toppinggetproduct') }}/" + categoryId,
            dataType: "json",
            success: function (response) {
                $('.product').empty().append(response.products);
                $('.productsize').empty().append(response.productsize);
            }
        });
    }



    // Store Mapping
    function storeMapping()
    {
        var form_data = new FormData(document.getElementById('mappingForm'));

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('storemapping') }}",
            data: form_data,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
               alert('Mappings Added Successfully..');
               location.reload();
            }
        });
    }
    // End Store Mapping

    // Edit Option Mapping
    function editoptionmapping(id)
    {
        var mapping_id = id;
        var trow = '.trow'+id;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('editmapping') }}",
            data: { id : mapping_id },
            dataType: "json",
            success: function (response) {
                $(trow).remove();
                $('#mapping_optn_tbody').append(response);
                $('#mybtn1').hide();
                $('#mybtn2').hide();
            }
        });
    }
    // End Edit Option Mapping


    // Update Option Mapping
    function updateMapping(mapid)
    {
        var map_id = mapid;

        var order_type = $('#order_type_'+map_id).val();
        var category = $('#category_'+map_id).val();
        var product = $('#product_'+map_id).val();
        var rename = $('#topping_rename_'+map_id).val();
        var size = $('#size_'+map_id).val();
        var min_item = $('#min_item_'+map_id).val();
        var max_item = $('#max_item_'+map_id).val();
        var days = $('#days_'+map_id).val();
        var start_time = $('#start_time_'+map_id).val();
        var end_time = $('#end_time_'+map_id).val();
        var num_free = $('#num_free_'+map_id).val();
        var price = $('#price_'+map_id).val();
        var sub_option = $('#sub_option_'+map_id).val();
        var style = $('#style_'+map_id).val();
        var sort_order = $('#sort_order_'+map_id).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('updatemapping') }}",
            data: {
                'order_type' : order_type,
                'map_id' : map_id,
                'category' : category,
                'product' : product,
                'rename' : rename,
                'size' : size,
                'min_item' : min_item,
                'max_item' : max_item,
                'days' : days,
                'start_time' : start_time,
                'end_time' : end_time,
                'num_free' : num_free,
                'price' : price,
                'sub_option' : sub_option,
                'style' : style,
                'sort_order' : sort_order,
            },
            dataType: "json",
            success: function (response) {
                alert('Mappings Updated Successfully..');
                location.reload();
            }
        });
    }
    // End Update Option Mapping


    // Select All Checkbox
    $('#delall').on('click', function(e) {
        if($(this).is(':checked',true))
        {
            $(".del_all").prop('checked', true);
        }
        else
        {
            $(".del_all").prop('checked',false);
        }
    });
    // End Select All Checkbox

    // Delete Option Topping
    $('.deletesellected').click(function()
    {

        var checkValues = $('.del_all:checked').map(function()
        {
            return $(this).val();
        }).get();

        if(checkValues !='')
        {
            swal({
                title: "Are you sure You want to Delete It ?",
                text: "Once deleted, you will not be able to recover this Record",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete)
                {

                    $.ajax({
                            type: "POST",
                            url: '{{ url("deletemapping") }}',
                            data: {"_token": "{{ csrf_token() }}",'id':checkValues},
                            dataType : 'JSON',
                            success: function (data)
                            {
                                if(data.success == 1)
                                {
                                    swal("Your Record has been deleted!", {
                                        icon: "success",
                                    });

                                    setTimeout(function(){
                                        location.reload();
                                    }, 1500);
                                }
                            }
                    });

                }
                else
                {
                    swal("Cancelled", "", "error");
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
            });
        }
        else
        {
            swal("Please select atleast One Product Mapping", "", "warning");
        }
    });
    // End Delete Option Topping

</script>
{{-- END SCRIPT --}}
