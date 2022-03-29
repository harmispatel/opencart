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

        {{-- Insert Section Start --}}
        <section class="content">
            <div class="container-fluid">
                <div>
                    <div class="col-md-12">
                        {{-- Form Start --}}
                        <form action="{{ route('storebulkcategory') }}" method="POST" enctype="multipart/form-data" id="bulkCat">
                            {{ @csrf_field() }}
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
                                    <div class="table-responsive">
                                        <table class="table list table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="min-width: 250px;!important">Name</th>
                                                    <th style="min-width: 250px;!important">Description</th>
                                                    <th style="min-width: 250px;!important">Image</th>
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
                                                        <input type="file" name="category[0][image]" class=" p-1 form-control" required>
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
                                                                            <a class="btn btn-sm btn-success" onclick="addsizevalue(0);"><i class="fa fa-plus"></i> SIZE</a>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table><hr class="bg-primary">

                                                            <div class="form-group">
                                                                <label>Options</label><br>
                                                                <input type="radio" class="ispizza_0" value="1"  onclick="$('#base_size_0').show();" name="category[0][ispizza]">
                                                                Enable &nbsp;&nbsp;
                                                                <input type="radio" class="ispizza_0" value="0"  onclick="$('#base_size_0').hide();" name="category[0][ispizza]" checked>
                                                                Disable
                                                            </div>
                                                            <div id="groupTopping"></div>
                                                            <div id="base_size_0" style="display: none;">
                                                                <a class="btn btn-sm btn-primary" id="add_group_0" onclick="addgroup(0);return false;"><i class="fa fa-plus"></i> OPTION</a>
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
                                                        <a class="btn btn-sm btn-danger" onclick="$('.ybc_cat_0').remove();return false;">DELETE</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-right" colspan="5">
                                                        <a id="addcatbulk" onclick="addnewBulkCat()" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> ADD NEW</a>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                {{-- End Card Body --}}

                                {{-- Card Footer --}}
                                <div class="card-footer">
                                    <input type="hidden" value="{{ URL::current() }}" id="urlajax">
                                    <button id="ybcsubmit" type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> SAVE</button>
                                </div>
                                {{-- End Card Footer --}}
                            </div>
                            {{-- End Card --}}
                        </form>
                        {{-- End Form --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Insert Section --}}

    </div>
</section>
{{-- End Section of List Manufacturers --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">

    var cat_row = 0;

    function addnewBulkCat()
    {
        cat_row ++;

        $html = '<tr class="ybc_cat_'+cat_row+'">';


        $html += '<td class="align-middle">';
        $html += '<input type="text" name="category['+cat_row+'][name]" placeholder="Catgory Name" class="form-control" required>';
        $html += '</td>';

        $html += '<td class="align-middle">';
        $html += '<textarea name="category['+cat_row+'][description]" placeholder="Description" class="form-control"></textarea>';
        $html += '</td>';

        $html += '<td class="align-middle">';
        $html += '<input type="file" name="category['+cat_row+'][image]" class=" p-1 form-control" required>';
        $html += '</td>';


        $html += '<td id="option_0">';

        $html += '<div id="tab-pizza">';

        $html += '<div class="form-group">';
        $html += '<label>SIZE</label><br>';
        $html += '<input type="radio" value="1" name="category['+cat_row+'][enable_size]" onclick="$(\'#size-value_'+cat_row+'\').show();">';
        $html += 'Enable &nbsp;&nbsp;';
        $html += '<input type="radio" value="0" name="category['+cat_row+'][enable_size]" onclick="$(\'#size-value_'+cat_row+'\').hide();" checked>';
        $html += 'Disable';
        $html += '</div>';
        $html += '<table class="table table-bordered" id="size-value_'+cat_row+'" style="display: none;">';
        $html += '<thead>';
        $html += '<tr>';
        $html += '<th>Size</th>';
        $html += '<th>Sort Order</th>';
        $html += '<th>Action</th>';
        $html += '</tr>';
        $html += '</thead>';
        $html += '<tbody id="size-value-row_'+cat_row+'"></tbody>';
        $html += '<tfoot>';
        $html += '<tr>';
        $html += '<td colspan="3" class="text-center">';
        $html += '<a class="btn btn-sm btn-success" onclick="addsizevalue('+cat_row+');"><i class="fa fa-plus"></i> SIZE</a>';
        $html += '</td>';
        $html += '</tr>';
        $html += '</tfoot>';
        $html += '</table><hr class="bg-primary">';
        $html += '<div class="form-group">';
        $html += '<label>Options</label><br>';
        $html += '<input type="radio" class="ispizza_'+cat_row+'" onclick="$(\'#base_size_'+cat_row+'\').show();" value="1" name="category['+cat_row+'][ispizza]">';
        $html += 'Enable &nbsp;&nbsp;';
        $html += '<input type="radio" class="ispizza_'+cat_row+'" onclick="$(\'#base_size_'+cat_row+'\').hide();" value="0" name="category['+cat_row+'][ispizza]" checked>';
        $html += 'Disable';
        $html += '</div>';
        $html += '<div id="groupTopping"></div>';
        $html += '<div id="base_size_'+cat_row+'" style="display: none;">';
        $html += '<a class="btn btn-sm btn-primary" id="add_group_'+cat_row+'" onclick="addgroup('+cat_row+');return false;"><i class="fa fa-plus"></i> OPTION</a>';
        $html += '</div>';
        $html += '<hr class="bg-primary">';
        $html += '<div class="form-group">';
        $html += '<label>Comment Box</label><br>';
        $html += '<input type="radio" value="1" name="category['+cat_row+'][enable_comment]" onclick="$(\'#confignumbercharacter_'+cat_row+'\').show()">';
        $html += 'Enable &nbsp;&nbsp;';
        $html += '<input type="radio" value="0" name="category['+cat_row+'][enable_comment]" onclick="$(\'#confignumbercharacter_'+cat_row+'\').hide()" checked>';
        $html += 'Disable';
        $html += '</div>';
        $html += '<div id="confignumbercharacter_'+cat_row+'" style="display: none;">';
        $html += '<label>Maximum Character Allowed</label>';
        $html += '<input type="number" name="category['+cat_row+'][numbercharacter]" value="0">';
        $html += '</div>';

        $html += '<div id="ybc_group_'+cat_row+'" style="display:none;" class="group_topping">';
        $html += '<a class="btn btn-sm btn-danger" onclick="$(\'#group_'+cat_row+'_number_group'+'\').remove();return false;"><i class="fa fa-trash"></i></a>';
        $html += '<table class="table table-bordered">';
        $html += '<tbody>';
        $html += '<tr>';
        $html += '<td>Select Option Group</td>';
        $html += '<td>';
        $html += '<select name="category['+cat_row+'][group][number_group][id_group_option]">';
        $html += '@foreach($optiongroups as $optiongroup)';
        $html += '<option value="{{ $optiongroup->id_topping }}">{{ $optiongroup->name_topping }}</option>';
        $html += '@endforeach';
        $html += '</select>';
        $html += '</td>';
        $html += '</tr>';
        $html += '<tr>';
        $html += '<td>';
        $html += '<b>Select Free Group</b>';
        $html += '</td>';
        $html += '<td>';
        $html += '<input type="radio" name="category['+cat_row+'][group][number_group][set_option]" onclick="$(\'.list_'+cat_row+'_number_group'+'\').hide();" value="1" checked>';
        $html += '<label>Free</label>';
        $html += '<input type="radio" name="category['+cat_row+'][group][number_group][set_option]" onclick="$(\'.list_'+cat_row+'_number_group'+'\').hide();" value="2">';
        $html += '<label>Main Price</label>';
        $html += '<input type="radio" name="category['+cat_row+'][group][number_group][set_option]" onclick="$(\'.list_'+cat_row+'_number_group'+'\').show();" value="3">';
        $html += '<label>Set Price</label>';
        $html += '</td>';
        $html += '</tr>';
        $html += '<tr>';
        $html += '<td></td>';
        $html += '<td>';
        $html += '<input type="radio" name="category['+cat_row+'][group][number_group][set_require]" value="1">';
        $html += '<label>Required</label>';
        $html += '<input type="radio" name="category['+cat_row+'][group][number_group][set_require]" value="0" checked>';
        $html += '<label>Optional</label>';
        $html += '</td>';
        $html += '</tr>';
        $html += '</tbody>';
        $html += '</table>';
        $html += '<table class="list_'+cat_row+'_number_group table table-bordered" style="display: none;">';
        $html += '<thead>';
        $html += '<tr>';
        $html += '<th>Size</th>';
        $html += '<th>Top Price</th>';
        $html += '</tr>';
        $html += '</thead>';
        $html += '<tbody class="size_'+cat_row+'"></tbody>';
        $html += '</table>';
        $html += '</div>';

        $html += '</div>';

        $html += '</td>';

        $html += '<td class="align-middle">';
        $html += '<a class="btn btn-sm btn-danger" onclick="$(\'.ybc_cat_'+cat_row+'\').remove();return false;">DELETE</a>';
        $html += '</td>';

        $html += '</tr';

        $('#bulkcat').append($html);

    }


    // Add Size
    function addsizevalue(value)
    {
        var rowCount = $("#size-value-row_"+value+" tr").length;
        rowCount + 1;

        html = '<tr rel="'+rowCount+'" class="size size_'+value+'_'+rowCount+'">';
        html += '<td><input type="text" onchange="$(\'.ybc_'+value+'_'+rowCount+'\').html($(this).val());" name="category['+value+'][size]['+rowCount+']" value="" /></td>';
        html += '<td><input type="text" onchange="$(\'.ybc_'+value+'_'+rowCount+'\').html($(this).val());" name="category['+value+'][short_order]['+rowCount+']" value="" /></td>';
        html += '<td><a onclick="$(\'.size_'+value+'_'+rowCount+'\').remove();updatesizegroup('+value+');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

        $('#size-value-row_'+value).append(html);
        updatesizegroup(value,rowCount);

    }
    // End Add Size

    function addgroup(group_row)
    {
        var numItems = $('#base_size_'+group_row).children('div').length;
        var contentgroup = $('#ybc_group_'+group_row).html();
        html = '';
        html = '<div id="group_'+group_row+'_'+numItems+'" rel="'+numItems+'" class="group_topping">'+contentgroup.split("number_group").join(numItems);+'</div>';
        $('#add_group_'+group_row).before(html);
        updatesizegroup(group_row,numItems);
    }


    function updatesizegroup(update_row,count)
    {
        if($('.ybc_cat_'+update_row+' #base_size_'+update_row+' .group_topping').length > 0)
        {
            html = '';
            $('.ybc_cat_'+update_row+' #size-value-row_'+update_row+' .size').each(function(){
                html += '<tr class="size_row_'+$(this).attr('rel')+'">';
                html += '<td class="left ybc_'+update_row+'_'+$(this).attr('rel')+'">';
                html += $(this).find('input').val();
                html += '</td>';
                html += '<td class="left">';
                html += '<input type="number" name="category['+update_row+'][group]['+count+'][ybc_number_group][size_val]['+$(this).attr('rel')+']" value="">';
                html += '</td>';
                html += '</tr>';
            });
            $('.ybc_cat_'+update_row+' #base_size_'+update_row+' .group_topping').each(function(){
                // $(this).find('.size_'+update_row).html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                $('.list_'+update_row+'_'+count+' .size_'+update_row+'').html(html);
            });
        }
    }

</script>
