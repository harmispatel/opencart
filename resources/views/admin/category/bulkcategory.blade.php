@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<style>
    /* .tb-bor td, th{border:none !important;} */

</style>


{{-- Section of List Reviews --}}
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
                        <h1>Add Category</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('category') }}">Categories</a></li>
                            <li class="breadcrumb-item active">Insert</li>
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
                <div>
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-pencil-alt pr-2"></i>
                                    INSERT
                                </h3>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                <form action="" method="POST">
                                    <table class="table list table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Image</th>
                                                <th style="min-width: 500px;!important">Options</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bulkcat">
                                            <tr class="ybc_cat_0">
                                                <td class="align-middle">
                                                    <input type="text" name="category[0][name]" placeholder="Catgory Name" class="form-control" required>
                                                </td>
                                                <td class="align-middle">
                                                    <textarea name="category[0][description]" placeholder="Description" class="form-control"></textarea>
                                                </td>
                                                <td class="align-middle">
                                                    <input type="file" name="category[0][image]" class=" p-1 form-control">
                                                </td>
                                                <td id="option_0">
                                                    <div id="tab-pizza">
                                                        <div class="form-group">
                                                            <label>SIZE</label><br>
                                                            <input type="radio" value="1" name="category[0][enable_size]" onclick="$('#size-value_0').show();">
                                                            Enable &nbsp;&nbsp;
                                                            <input type="radio" value="0" name="category[0][enable_size]" onclick="$('#size-value_0').hide();" checked>
                                                            Disable
                                                        </div>
                                                        <table class="table table-bordered" id="size-value_0" style="display: none;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Size</th>
                                                                    <th>Sort Order</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="size-value-row_0">

                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="3" class="text-center">
                                                                        <a class="btn btn-sm btn-success" onclick="addsizevalue0();"><i class="fa fa-plus"></i> SIZE</a>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table><hr class="bg-primary">

                                                        <div class="form-group">
                                                            <label>Options</label><br>
                                                            <input type="radio" class="ispizza_0" value="1" name="category[0][ispizza]">
                                                            Enable &nbsp;&nbsp;
                                                            <input type="radio" class="ispizza_0" value="0" name="category[0][ispizza]" checked>
                                                            Disable
                                                        </div>
                                                        <div id="groupTopping"></div>
                                                        <div id="base_size_0" style="display: none;">
                                                            <a class="btn btn-sm btn-primary" id="add_group_0" onclick="addgroup0();return false;"><i class="fa fa-plus"></i> OPTION</a>
                                                        </div>
                                                        <hr class="bg-primary">

                                                        <div class="form-group">
                                                            <label>Comment Box</label><br>
                                                            <input type="radio" value="1" name="category[0][enable_comment]" onclick="$('#confignumbercharacter_0').show()">
                                                            Enable &nbsp;&nbsp;
                                                            <input type="radio" value="0" name="category[0][enable_comment]" onclick="$('#confignumbercharacter_0').hide()" checked>
                                                            Disable
                                                        </div>
                                                        <div id="confignumbercharacter_0" style="display: none;">
                                                            <label>Maximum Character Allowed</label>
                                                            <input type="number" name="category[0][numbercharacter]" value="0">
                                                        </div>

                                                        <div id="ybc_group_0" style="display: none;" class="group_topping">
                                                            <a class="btn btn-sm btn-danger" onclick="$('#group_0_number_group').remove();return false;"><i class="fa fa-trash"></i></a>
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Select Option Group</td>
                                                                        <td>
                                                                            <select name="category[0][group][number_group][id_group_option]" id="">
                                                                                @foreach($optiongroups as $optiongroup)
                                                                                    <option value="{{ $optiongroup->id_topping }}">{{ $optiongroup->name_topping }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <b>Select Free Group</b>
                                                                        </td>
                                                                        <td>
                                                                            <input type="radio" name="category[0][group][number_group][set_option]" onclick="$('.list_0_number_group').hide();" value="1" checked>
                                                                            <label>Free</label>

                                                                            <input type="radio" name="category[0][group][number_group][set_option]" onclick="$('.list_0_number_group').hide();" value="2">
                                                                            <label>Main Price</label>

                                                                            <input type="radio" name="category[0][group][number_group][set_option]" onclick="$('.list_0_number_group').show();" value="3">
                                                                            <label>Set Price</label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>
                                                                            <input type="radio" name="category[0][group][number_group][set_require]" value="1">
                                                                            <label>Required</label>

                                                                            <input type="radio" name="category[0][group][number_group][set_require]" value="0" checked>
                                                                            <label>Optional</label>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="list_0_number_group table table-bordered" style="display: none;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Size</th>
                                                                        <th>Top Price</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="size_0">

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <a class="btn btn-sm btn-danger" onclick="$('.ybc_cat_0').remove();return false;"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-right" colspan="5">
                                                    <a id="adcatbulk" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> ADD NEW</a>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                            </div>
                            {{-- End Card Body --}}

                            {{-- Card Footer --}}
                            <div class="card-footer">
                                <a id="ybcsubmit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> SAVE</a>
                            </div>
                            <input type="hidden" id="urlcur" value="{{ url()->current() }}">
                            {{-- End Card Footer --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Manufacturers --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">

    var bulk_cat = 0;

    // Show & Hide Option Add Button
    $('.ispizza_0').click(function()
    {
        if($(this).val() == 1)
        {
            $('#base_size_0').show();
        }
        else
        {
            $('#base_size_0').hide();
        }
    });
    // End Show & Hide Option Add Button


    // Add Size
    var size_value_row_0 = 0;
    function addsizevalue0()
    {
        size_value_row_0++;

        html = '<tr rel="'+size_value_row_0+'" class="size size_'+size_value_row_0+'">';
        html += '<td><input type="text" onchange="$(\'.ybc_0_'+size_value_row_0+'\').html($(this).val());" name="category[0][size]['+size_value_row_0+']" value="" /></td>';
        html += '<td><input type="text" onchange="$(\'.ybc_0_'+size_value_row_0+'\').html($(this).val());" name="category[0][short_order]['+size_value_row_0+']" value="" /></td>';
        html += '<td><a onclick="$(\'.size_'+size_value_row_0+'\').remove();updatesizegroup0();" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

        $('#size-value-row_0').append(html);
        updatesizegroup0();

        // html2 = '<tr class="size_' + size_value_row + '">';
        // html2 += '<td>hii</td>';
        // html2 += '<td><input type="text" name="bulk_category['+size_value_row+'][group]['+group_row+'][size]['+size_value_row+']"></td>';
        // html2 += '</tr>';
        // $('.size_val_'+size_value_row).append(html2);
    }
    // End Add Size


    var number_group_0 = 0;
    var contentgroup_0 = $('#ybc_group_0').html();
    function addgroup0()
    {
        number_group_0++;
        html = '';
        html = '<div id="group_0_'+number_group_0+'" rel="'+number_group_0+'" class="group_topping">'+contentgroup_0.split("number_group").join(number_group_0);+'</div>'; //
        $('#add_group_0').before(html);
        updatesizegroup0();
    }


    function updatesizegroup0()
    {
        if($('.ybc_cat_0 #base_size_0 .group_topping').length > 0)
        {
            html = '';
            $('.ybc_cat_0 #size-value-row_0 .size').each(function(){
                html += '<tr class="size_'+$(this).attr('rel')+'">';
                html += '<td class="left ybc_0_'+$(this).attr('rel')+'">';
                html += $(this).find('input').val();
                html += '</td>';
                html += '<td class="left">';
                html += '<input type="text" name="category[0][group][ybc_number_group][size]['+$(this).attr('rel')+']" value="">';
                html += '</td>';
                html += '</tr>';
            });
            $('.ybc_cat_0 #base_size_0 .group_topping').each(function(){
                $(this).find('.size_0').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
            });
        }
    }


    // Add Group Function
    // var group_row = 0;
    // function addGroup()
    // {
    //     group_row++;
    //     html = '<div id="group_'+group_row+'" class="mt-2">';


    //     html += '<a class="btn btn-sm btn-danger" onclick="$(\'#group_'+group_row+'\').remove()"><i class="fa fa-trash"></i></a>';


    //     html += '<table class="table mt-1 table-bordered">';
    //     html += '<tr><th>Select Option Group</th><td><select name="bulk_category['+bulk_cat+']group['+group_row+'][id_group_option]">@foreach($optiongroups as $optiongroup)<option value="{{ $optiongroup->id_topping }}">{{ $optiongroup->name_topping }}</option>@endforeach</select></td></tr>';

    //     html += '<tr><th>Select Free Group</th><td><input name="group['+group_row+'][set_option]" type="radio" value="1" onclick="$(\'.list_'+group_row+'\').hide();"  checked> <label class="pr-3">Free</label><input name="group['+group_row+'][set_option]" type="radio" value="2" onclick="$(\'.list_'+group_row+'\').hide();"> <label  class="pr-3">Main Price</label><input name="group['+group_row+'][set_option]" type="radio" value="3" onclick="$(\'.list_'+group_row+'\').show();"> <label  class="pr-3">Set Price</label></td></tr>';

    //     html += '<tr><th></th><td><input type="radio" name="group['+group_row+'][set_require]" value="1" checked> <label class="pr-3">Required</label><input type="radio" name="group['+group_row+'][set_require]" value="0"> <label class="pr-3">Optional</label></td></tr>';
    //     html += '</table>';


    //     html += '<table class="table mt-1 table-bordered list_'+group_row+'" style="display:none;">';
    //     html += '<thead>';
    //     html += '<tr><th>Size</th><th>Top Price</th></tr>';
    //     html += '</thead>';
    //     html += '<tbody class="size_val_'+group_row+'">';
    //     //
    //     html += '</tbody>';
    //     html += '</table>';


    //     html += '</div>';

    //     $('#groupTopping').append(html);
    // }
    //End Add Group Function

</script>
