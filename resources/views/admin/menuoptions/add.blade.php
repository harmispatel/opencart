@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .pr-list tbody td{vertical-align: middle !important;}
</style>


{{-- Section of Add Product --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Topping</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('option') }}">MenuOption</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
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
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fas fa-pencil-alt"></i>
                                    Add Topping
                                </h3>
                                <div class="container" style="text-align: right;">
                                    <button type="submit" form="catform" class="btn btn-sm btn-primary"><i
                                            class="fa fa-save"></i> Save</button>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left">
                                            Back</i></a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Start --}}
                            <form action="#" method="POST" id="catform" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">

                                    <table class="table">
                                        <tr>
                                            <td style="width:180px;"><span class="required">*</span>Group Name
                                            </td>
                                            <td><input type="text" name="name_topping" value="" class="form-control"/></td>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <td align="right" onclick="showItems(this);" class="toppingsTab active">
                                                Items</td>
                                            <td align="right" onclick="showOptions(this);" class="toppingsTab">
                                                Options</td>
                                        </tr>
                                    </table>
                                    <table id="size-value" class="list showItems table pr-list" border="2">
                                        <thead>
                                            <tr align="center">
                                                <td class="left">Name</td>
                                                <td class="left">Price Main</td>
                                                <td>Order</td>
                                                <td class="suboption-row">Sub Options</td>
                                                <td class="topping-del">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody class="size-value-row_12" id="listTopping">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="left">

                                                    <input type="number" name="addNumber" value="1" min="1"
                                                        style="width:45px;"  />

                                                    <button type="button" style="margin-left: 20px"
                                                        onclick="addoption();" data-toggle="tooltip"
                                                        title="Add Option Value" class="btn btn-primary"><i
                                                            class="fa fa-plus-circle"></i>
                                                    </button>
                                                </td>
                                                <td colspan="4"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="showOptions">
                                        <table class="form">
                                            <tbody>
                                                <tr>
                                                    <td><label>Group Title:</label></td>
                                                    <td><input name="show_group_title" type="radio" value="1"
                                                            class="" /> Enable
                                                            <input name="show_group_title" type="radio" value="0"
                                                            checked /> Disable</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Font Color:</label></td>
                                                    <td><input class="form-control" type="color"
                                                            name="group_title_color" value=""></td>
                                                </tr>
                                                <tr>
                                                    <td><label>Message:</label></td>
                                                    <td><input type="text" style="max-width:300px;"
                                                            name="topping_header_message" value="" class="form-control" / ></td>
                                                </tr>
                                                <tr>
                                                    <td><label>Footer Message:</label></td>
                                                    <td><input type="text" name="topping_footer_message" value=""  class="form-control"/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- End Card Body --}}
                            </form>
                            {{-- Form End --}}
                        </div>
                        {{-- Card End --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/color-js/1.0.1/color.min.js"></script> 


<script>
    var number_option = 0;
    $('.showOptions').hide();

    function addoption() {
        var add_number = $('input[name="addNumber"]').val();
        for (i = 0; i < add_number; i++) {
            number_option++;
            var html = '<tr class="option_' + number_option +
                '"><td class="left"><input type="text" value="" name="name[]" class="form-control" /></td><td class="left">';
            html += '<input type="text" value="" name="price_main[]" class="form-control" />';
            html += '</td><td class="left"><input type="text" value="" class="form-control" name="order[]" /></td>';
            html += '<td><select name="sub_option[]" multiple="multiple"class="form-control"><option value=0>abc</option><option value=0>abcd</option></select></td>';
            html += '<td class="text-right"><a onclick="$(\'.option_' + number_option +
                '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
            $('#listTopping').append(html);
        }
    }

    function showOptions(e) {
        $('.toppingsTab').removeClass('active');
        $('.showOptions').show();
        $('.showItems').hide();
        $(e).addClass('active');
    }

    function showItems(e) {
        $('.toppingsTab').removeClass('active');
        $('.showItems').show();
        $('.showOptions').hide();
        $(e).addClass('active');
    }
</script>
