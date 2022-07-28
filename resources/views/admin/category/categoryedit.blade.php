<!--
    THIS IS HEADER Categoryedit PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    categoryedit.blade.php
    This for Edit Category
    ----------------------------------------------------------------------------------------------
-->

@php
$demo = gallary_redirect_url();
@endphp
<input type="hidden" id="gallary" value="{{$demo.'/filemanager'}}">
{{-- Header --}}
@include('header')
{{-- End Header --}}
{{-- Section of Edit Category --}}
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
                        <h1>Categories</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('category') }}">Categories</a></li>
                            </a>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Edit Section --}}
        <section class="content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Warning: Please check the form carefully for errors!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card">
                            {{-- Form --}}
                            <form action="{{ route('categoryupdate') }}" id="catform" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Header --}}
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-pencil-alt pr-2"></i>
                                        EDIT
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary" type="submit" name="save_and_stay">
                                            <i class="fa fa-save"></i> Save & Stay
                                        </button>
                                        <a href="{{ route('category') }}" class="btn btn-sm btn-danger ml-1 deletesellected">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                 {{-- Card Body --}}
                                 <div class="card-body">
                                    <div class="form-group">

                                        <input type="hidden" name="id" value="{{ isset($data->category_id) ? $data->category_id : '' }}">
                                        <input type="hidden" name="top_cat_option_id" value="{{ isset($topcatoption->id) ? $topcatoption->id : '' }}">
                                        <label for="category" class="form-label"><span class="text-danger">*</span> Name</label>
                                        <input type="text" name="category" class="form-control {{ ($errors->has('category')) ? 'is-invalid' : '' }}" id="category" placeholder="Category Name" value="{{ isset($data->hasOneCategory->name) ? $data->hasOneCategory->name : '' }}">
                                        @if ($errors->has('category'))
                                            <div class="invalid-feedback">{{ $errors->first('category') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="days" class="form-label">Days Available</label><br>
                                        <div class="p-2 rounded" style="border: 1px solid rgb(197, 197, 197)">
                                            @php
                                                $days = explode(',',isset($data->availibleday) ? $data->availibleday : '');
                                            @endphp
                                            <input type="checkbox" id="inlineCheckbox1" value="0" name="availibleday[]" {{ (in_array('0',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox1">Sunday</label>

                                            <input type="checkbox" id="inlineCheckbox2" value="1" name="availibleday[]" {{ (in_array('1',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox2">Monday</label>

                                            <input type="checkbox" id="inlineCheckbox3" value="2" name="availibleday[]" {{ (in_array('2',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox3">Tuesday</label>

                                            <input type="checkbox" id="inlineCheckbox4" value="3" name="availibleday[]" {{ (in_array('3',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox4">Wedensday</label>

                                            <input type="checkbox" id="inlineCheckbox5" value="4" name="availibleday[]" {{ (in_array('4',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox5">Thursday</label>

                                            <input type="checkbox" id="inlineCheckbox6" value="5" name="availibleday[]" {{ (in_array('5',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox6">Friday</label>

                                            <input type="checkbox" id="inlineCheckbox7" value="6" name="availibleday[]" {{ (in_array('6',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox7">Saturday</label>
                                        </div>
                                    </div>

                                    @php
                                        $descr = html_entity_decode(isset($data->hasOneCategory->description) ? $data->hasOneCategory->description : '');
                                    @endphp
                                    <div class="form-group">
                                        <label for="summernote" class="form-label">Description</label>
                                        <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description">{{ strip_tags($descr) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 pb-1" style="background: #1bbc9b;">
                                                <label for="" class="m-0 p-1 text-white">OPTIONS</label>
                                            </div>
                                        </div>

                                        {{-- Dynamic Topping Size Count --}}
                                        @php
                                            $count = count($toppingsizes);
                                            if ($count != '') {
                                                // $newcount = $count + 1;
                                                echo '<input type="hidden" name="size_value_row" id="size_value_row" value="'.$count.'">';
                                            }
                                            else {
                                                echo '<input type="hidden" name="size_value_row" id="size_value_row" value="1">';
                                            }
                                        @endphp
                                        {{-- End Dynamic Topping Size Count --}}

                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                <label for="sizeval" class="pr-3">SIZE</label>
                                                @if ($topcatoption != '' || !empty($topcatoption))
                                                    <input type="radio" name="sizeval" value="1" onclick="$('#size-value').show()" {{ ($topcatoption->enable_size == 1) ? 'checked' : '' }}> Enable &nbsp;
                                                    <input type="radio" name="sizeval" value="0"  onclick="$('#size-value').hide()" {{ ($topcatoption->enable_size == 0) ? 'checked' : '' }}> Disable
                                                @else
                                                    <input type="radio" name="sizeval" value="1" onclick="$('#size-value').show()"> Enable &nbsp;
                                                    <input type="radio" name="sizeval" value="0"  onclick="$('#size-value').hide()" checked> Disable
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered" id="size-value" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th>Size</th>
                                                            <th>Sort Order</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="size-value-row">
                                                        @foreach ($toppingsizes as $toppingsize)
                                                            <tr class="size_{{ $loop->iteration }}">
                                                                <td>
                                                                    <input type="hidden" name="size[{{ $loop->iteration }}][size_id]" value="{{ $toppingsize->id_size }}">
                                                                    <input type="text" name="size[{{ $loop->iteration }}][sizename]" value="{{ html_entity_decode($toppingsize->size) }}" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="size[{{ $loop->iteration }}][short_order]" value="{{ $toppingsize->short_order }}" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <a onclick="deleteOptionSize({{ $toppingsize->id_size }})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-center">
                                                                <a class="btn btn-sm" style="background:#1bbc9b;color: white;" onclick="addsizevalue()">ADD SIZE VALUE</a>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div><hr>

                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                <label for="options" class="pr-3">OPTIONS</label>
                                                @if ($topcatoption != '' || !empty($topcatoption))
                                                    <input type="radio" name="options" value="1" onclick="$('#opt-btn').show();$('#groupTopping').show()" {{ ($topcatoption->enable_option == 1) ? 'checked' : '' }}> Enable &nbsp;
                                                    <input type="radio" name="options" value="0"  onclick="$('#opt-btn').hide();$('#groupTopping').hide()" {{ ($topcatoption->enable_option == 0) ? 'checked' : '' }}> Disable
                                                @else
                                                    <input type="radio" name="options" value="1" onclick="$('#opt-btn').show();"> Enable &nbsp;
                                                    <input type="radio" name="options" value="0"  onclick="$('#opt-btn').hide();" checked> Disable
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" id="groupTopping" style="display: none;">
                                                @php
                                                    if(isset($topcatoption->group))
                                                    {
                                                        $group = unserialize($topcatoption->group);
                                                    }
                                                    else {
                                                        $group = '';
                                                    }
                                                    if(!empty($group) || $group != '')
                                                    {
                                                        unset($group["number_group"]);
                                                    }
                                                    // Dynamic Topping Size Count
                                                    if($group != '' || !empty($group))
                                                    {
                                                        $group_count = count($group);
                                                    }
                                                    else
                                                    {
                                                        $group_count = '';
                                                    }
                                                    if ($group_count != '') {
                                                        // $newcount = $count + 1;
                                                        echo '<input type="hidden" name="group_row_count" id="group_row_count" value="'.$group_count.'">';
                                                    }
                                                    else {
                                                        echo '<input type="hidden" name="group_row_count" id="group_row_count" value="1">';
                                                    }
                                                    // End Dynamic Topping Size Count
                                                @endphp
                                                @if(!empty($group) || $group != '')
                                                    @foreach ($group as $key => $value)
                                                        <div id="group_{{ $key }}" class="mt-2">
                                                            <a class="btn btn-sm btn-danger"  onclick="$('#group_{{ $key }}').remove()"><i class="fa fa-trash"></i></a>
                                                            <table class="table mt-1 table-bordered">
                                                                <tr>
                                                                    <th>Select Option Group</th>
                                                                    <td>
                                                                        <select name="group[{{ $key }}][id_group_option]">
                                                                            @foreach($optiongroups as $optiongroup)
                                                                                <option value="{{ $optiongroup->id_topping }}" {{ ($optiongroup->id_topping == $value['id_group_option']) ? 'selected' : '' }}>{{ $optiongroup->name_topping }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Select Free Group</th>
                                                                    <td>
                                                                        <input name="group[{{ $key }}][set_option]" type="radio" value="1" onclick="$('.list_{{ $key }}').hide();" {{ ($value['set_option'] == 1) ? 'checked' : '' }}> <label class="pr-3">Free</label>

                                                                        <input name="group[{{ $key }}][set_option]" type="radio" value="2" onclick="$('.list_{{ $key }}').hide();" {{ ($value['set_option'] == 2) ? 'checked' : '' }}> <label  class="pr-3">Main Price</label>

                                                                        <input name="group[{{ $key }}][set_option]" type="radio" value="3" onclick="$('.list_{{ $key }}').show();" {{ ($value['set_option'] == 3) ? 'checked' : '' }}> <label  class="pr-3">Set Price</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th></th>
                                                                    <td>
                                                                        <input type="radio" name="group[{{ $key }}][set_require]" value="1" {{ ($value['set_require'] == 1) ? 'checked' : '' }}> <label class="pr-3">Required</label>

                                                                        <input type="radio" name="group[{{ $key }}][set_require]" value="0" {{ ($value['set_require'] == 0) ? 'checked' : '' }}> <label class="pr-3">Optional</label>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            @if( ($value['set_option'] == 1) || ($value['set_option'] == 2))
                                                                <table class="table mt-1 table-bordered list_{{ $key }}" style="display: none;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Size</th>
                                                                            <th>Top Price</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($toppingsizes as $toppingsize)
                                                                            <tr class="size_{{ $key }}">
                                                                                <td>{{ html_entity_decode($toppingsize->size) }}</td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="group[{{ $key }}][size_val][{{ $toppingsize->id_size }}]" value="{{ isset($value['size_val'][$toppingsize->id_size]) ? $value['size_val'][$toppingsize->id_size] : '' }}">
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @elseif($value['set_option'] == 3)
                                                                <table class="table mt-1 table-bordered list_{{ $key }}">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Size</th>
                                                                            <th>Top Price</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($toppingsizes as $toppingsize)
                                                                            <tr class="size_{{ $key }}">
                                                                                <td>{{ html_entity_decode($toppingsize->size) }}</td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" name="group[{{ $key }}][size_val][{{ $toppingsize->id_size }}]" value="{{ isset($value['size_val'][$toppingsize->id_size]) ? $value['size_val'][$toppingsize->id_size] : '' }}">
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <a class="btn btn-sm btn-primary mt-2" id="opt-btn" style="display: none;" onclick="addgroup()"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div><hr>

                                        <div class="row">
                                            <div class="col-md-12 mt-2">
                                                @if($topcatoption != '' || !empty($topcatoption))
                                                    <label for="commentbox" class="pr-3">Comment Box</label>
                                                    <input type="radio" name="enable_comment" value="1" onclick="$('#numbercharacter').show()" {{ ($topcatoption->enable_boxcomment == 1) ? 'checked' : '' }}> Enable &nbsp;
                                                    <input type="radio" name="enable_comment" value="0"  onclick="$('#numbercharacter').hide()" {{ ($topcatoption->enable_boxcomment == 0) ? 'checked' : '' }}> Disable
                                                @else
                                                    <label for="commentbox" class="pr-3">Comment Box</label>
                                                    <input type="radio" name="enable_comment" value="1" onclick="$('#numbercharacter').show()"> Enable &nbsp;
                                                    <input type="radio" name="enable_comment" value="0"  onclick="$('#numbercharacter').hide()" checked> Disable
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row" id="numbercharacter" style="display: none;">
                                            <div class="col-md-3">
                                                <b>Maximum Character Allowed</b>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="numbercharacter" value="{{ (isset($topcatoption->character)) ? $topcatoption->character : 0 }}" class="form-control">
                                            </div>
                                        </div><hr>


                                    </div>

                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                              </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text" name="image">
                                          </div>
                                          <img id="holder" style="margin-top:15px;max-height:100px;">
                                        <div class="div mt-3 p-2 text-center" style="border: 2px solid black;width:90px;box-shadow: inset -3px -3px 5px rgb(17, 15, 15);">
                                            @if(!empty($data->image))
                                                <img src="{{ isset($data->image) ? $data->image : '' }}" alt="Not Found" width="60">
                                            @else
                                                <h3 class="text-danger"><i class="fa fa-ban" aria-hidden="true"></i></h3>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="banner">Banner</label>
                                        {{-- <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" style="padding:3px;" name="banner" id="banner" type="file">
                                        @if ($errors->has('banner'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('banner') }}
                                            </div>
                                        @endif --}}
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail2" class="form-control" type="text" name="banner">
                                        </div>
                                         <div id="holder2"  style="margin-top:15px;max-height:100px;"></div>
                                        <div class="div mt-3 p-2 text-center" style="border: 2px solid black;width:90px;box-shadow: inset -3px -3px 5px rgb(17, 15, 15);">
                                            @if(!empty($data->img_banner))
                                                <img src="{{ isset($data->img_banner) ? $data->img_banner : '' }}" alt="Not Found" width="60">
                                            @else
                                                <h3 class="text-danger"><i class="fa fa-ban" aria-hidden="true"></i></h3>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sortorder" class="form-label">Sort Order</label>
                                        <input type="text" class="form-control" name="sortorder" id="sortorder" value="{{ isset($data->sort_order) ? $data->sort_order : '' }}">
                                    </div>

                                 </div>
                            </form>
                            {{-- End Form --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Edit Section --}}

    </div>
</section>
{{-- End Section of Edit Category --}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}

{{-- SCRIPT --}}
<script type="text/javascript">


$(document).ready(function(){

    var sizeval = $("[name=sizeval]:checked").val();
    if(sizeval == 1)
    {
        $('#size-value').show();
    }

    var enable_comment = $("[name=enable_comment]:checked").val();
    if(enable_comment == 1)
    {
        $('#numbercharacter').show();
    }

    var options = $("[name=options]:checked").val();
    if(options == 1)
    {
        $('#opt-btn').show();
        $('#groupTopping').show();
    }

});


// Add Size Function
var size_value_row = $('#size_value_row').val();
function addsizevalue()
{
    size_value_row++;
    html = '<tr class="size_' + size_value_row + '">';
    html += '<td><input type="text" name="size[' + size_value_row + '][sizename]" value="" placeholder="Size" class="form-control"></td>';
    html += '<td><input type="text" name="size[' + size_value_row + '][short_order]" value="" placeholder="Sort Order" class="form-control"></td>';
    html += '<td><a onclick="$(\'.size_' + size_value_row + '\').remove();" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>';
    // html += '    <td><a onclick="$(\'.size_' + size_value_row + '\').remove();" class="btn btn-sm" style="background:#1bbc9b;color: white;">Edit</a></td>';
    html += '  </tr>';
    $('#size-value-row').append(html);
}
// End Add Size Function


// Add Group Function
var group_row = $('#group_row_count').val();
function addgroup()
{
    group_row++;
    html = '<div id="group_'+group_row+'" class="mt-2">';


    html += '<a class="btn btn-sm btn-danger" onclick="$(\'#group_'+group_row+'\').remove()"><i class="fa fa-trash"></i></a>';


    html += '<table class="table mt-1 table-bordered">';
    html += '<tr><th>Select Option Group</th><td><select name="group['+group_row+'][id_group_option]">@foreach($optiongroups as $optiongroup)<option value="{{ $optiongroup->id_topping }}">{{ $optiongroup->name_topping }}</option>@endforeach</select></td></tr>';

    html += '<tr><th>Select Free Group</th><td><input name="group['+group_row+'][set_option]" type="radio" value="1" onclick="$(\'.list_'+group_row+'\').hide();"> <label class="pr-3">Free</label><input name="group['+group_row+'][set_option]" type="radio" value="2" onclick="$(\'.list_'+group_row+'\').hide();"> <label  class="pr-3">Main Price</label><input name="group['+group_row+'][set_option]" type="radio" value="3" onclick="$(\'.list_'+group_row+'\').show();" checked> <label  class="pr-3">Set Price</label></td></tr>';

    html += '<tr><th></th><td><input type="radio" name="group['+group_row+'][set_require]" value="1" checked> <label class="pr-3">Required</label><input type="radio" name="group['+group_row+'][set_require]" value="0"> <label class="pr-3">Optional</label></td></tr>';
    html += '</table>';


    html += '<table class="table mt-1 table-bordered list_'+group_row+'">';
    html += '<thead>';
    html += '<tr><th>Size</th><th>Top Price</th></tr>';
    html += '</thead>';
    html += '<tbody>';
    html += '@foreach($toppingsizes as $toppingsize)<tr class="size_{{ $loop->iteration }}"><td>{{ ($toppingsize->size) }}</td><td><input type="text" class="form-control" name="group['+group_row+'][size_val][{{ $toppingsize->id_size }}]"></td></tr>@endforeach';
    html += '</tbody>';
    html += '</table>';


    html += '</div>';

    $('#groupTopping').append(html);
}
//End Add Group Function


// Delete Option Size
function deleteOptionSize(id)
{
    var size_id = id;

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
                        url: "{{ url('delOptionSize') }}",
                        data: {"_token": "{{ csrf_token() }}",'size_id':size_id},
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
// End Delete Option Size

</script>
{{--
    <script>
        $('#lfm').filemanager('file');
        var getUrl = window.location;
        var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+'/index.php/filemanager';
        // alert(baseUrl)
        //    var route_prefix = "http://192.168.1.3/opencart/index.php/filemanager";
        $('#lfm').filemanager('image', {prefix: baseUrl});
    </script> --}}
<script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    var data = $('#gallary').val();
     $('#lfm').filemanager('file');
    var route_prefix =data;
    $('#lfm').filemanager('image', {prefix: route_prefix});
</script>
<script>
    var lfm = function(id, type, options) {
        let button = document.getElementById(id);

        button.addEventListener('click', function() {
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            var target_input = document.getElementById(button.getAttribute('data-input'));
            var target_preview = document.getElementById(button.getAttribute('data-preview'));

            window.open(route_prefix + '?type=' +  options.type || 'file', 'FileManager',
                'width=900,height=600');
            window.SetUrl = function(items) {
                var file_path = items.map(function(item) {
                    return item.url;
                }).join(',');

                // set the value of the desired input to image url
                target_input.value = file_path;
                target_input.dispatchEvent(new Event('change'));

                // clear previous preview
                target_preview.innerHtml = '';

                // set or change the preview image src
                items.forEach(function(item) {
                    let img = document.createElement('img')
                    img.setAttribute('style', 'display : none')
                    img.setAttribute('src', item.thumb_url)
                    target_preview.appendChild(img);
                });

                // trigger change event
                target_preview.dispatchEvent(new Event('change'));
            };
        });
    };

    lfm('lfm2', 'file', {
        prefix: route_prefix
    });

</script>

{{-- END SCRIPT --}}


