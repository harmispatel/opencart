{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="sweetalert2.min.css">

{{-- Section of Edit Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
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
                                        <a href="{{ route('category') }}" class="btn btn-sm btn-danger ml-1 deletesellected">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                 {{-- Card Body --}}
                                 <div class="card-body">
                                    <div class="form-group">

                                        <input type="hidden" name="id" value="{{ $data->category_id }}">
                                        <label for="category" class="form-label">Category Name</label>
                                        <input type="text" name="category" class="form-control {{ ($errors->has('category')) ? 'is-invalid' : '' }}" id="category" placeholder="Category Name" value="{{ $data->name }}">
                                        @if ($errors->has('category'))
                                            <div class="invalid-feedback">{{ $errors->first('category') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="days" class="form-label">Days Available</label><br>
                                        <div class="p-2 rounded" style="border: 1px solid rgb(197, 197, 197)">
                                            @php
                                                $days = explode(',',$data->availibleday);
                                            @endphp
                                            <input type="checkbox" id="inlineCheckbox1" value="1" name="availibleday[]" {{ (in_array('1',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox1">Sunday</label>

                                            <input type="checkbox" id="inlineCheckbox2" value="2" name="availibleday[]" {{ (in_array('2',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox2">Monday</label>

                                            <input type="checkbox" id="inlineCheckbox3" value="3" name="availibleday[]" {{ (in_array('3',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox3">Tuesday</label>

                                            <input type="checkbox" id="inlineCheckbox4" value="4" name="availibleday[]" {{ (in_array('4',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox4">Wedensday</label>

                                            <input type="checkbox" id="inlineCheckbox5" value="5" name="availibleday[]" {{ (in_array('5',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox5">Thursday</label>

                                            <input type="checkbox" id="inlineCheckbox6" value="6" name="availibleday[]" {{ (in_array('6',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox6">Friday</label>

                                            <input type="checkbox" id="inlineCheckbox7" value="7" name="availibleday[]" {{ (in_array('7',$days)) ? 'checked' : '' }}>
                                            <label class="form-check-label pr-3" for="inlineCheckbox7">Saturday</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="summernote" class="form-label">Description</label>
                                        <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description">{{ $data->description }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12 pb-1" style="background: #1bbc9b;">
                                            <label for="" class="m-0 p-1 text-white">OPTIONS</label>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label for="size" class="pr-3">SIZE</label>
                                            <input type="radio" name="size" value="1" onclick="$('#size-value').show()"> Enable &nbsp;
                                            <input type="radio" name="size" value="0"  onclick="$('#size-value').hide()" checked> Disable
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-bordered" style="display: none" id="size-value">
                                                <thead>
                                                    <tr>
                                                        <th>Size</th>
                                                        <th>Sort Order</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="size-value-row">

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
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" style="padding:3px;" id="image" class="form-control">
                                        <div class="div mt-3 p-2 text-center" style="border: 2px solid black;width:90px;box-shadow: inset -3px -3px 5px rgb(17, 15, 15);">
                                            @if(!empty($data->image))
                                                <img src="{{ asset('public/admin/category/'.$data->image) }}" alt="Not Found" width="60">
                                            @else
                                                <h3 class="text-danger"><i class="fa fa-ban" aria-hidden="true"></i></h3>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="banner">Banner</label>
                                        <input type="file" name="banner" style="padding:3px;" id="banner" class="form-control">
                                        <div class="div mt-3 p-2 text-center" style="border: 2px solid black;width:90px;box-shadow: inset -3px -3px 5px rgb(17, 15, 15);">
                                            @if(!empty($data->img_banner))
                                                <img src="{{ asset('public/admin/category/banner/'.$data->img_banner) }}" alt="Not Found" width="60">
                                            @else
                                                <h3 class="text-danger"><i class="fa fa-ban" aria-hidden="true"></i></h3>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sortorder" class="form-label">Sort Order</label>
                                        <input type="text" class="form-control" name="sortorder" id="sortorder" value="{{ $data->sort_order }}">
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

// Add Size Function
var size_value_row = 0;
function addsizevalue()
{
    size_value_row++;
    html = '  <tr class="size_' + size_value_row + '">';
    html += '    <td><input type="text" name="size[' + size_value_row + '][size]" value="" / placeholder="Size" class="form-control"></td>';
    html += '    <td><input type="text" name="size[' + size_value_row + '][short_order]" value="" / placeholder="Sort Order" class="form-control"></td>';
    html += '    <td><a onclick="$(\'.size_' + size_value_row + '\').remove();" class="btn btn-sm" style="background:#1bbc9b;color: white;">Delete</a></td>';
    // html += '    <td><a onclick="$(\'.size_' + size_value_row + '\').remove();" class="btn btn-sm" style="background:#1bbc9b;color: white;">Edit</a></td>';
    html += '  </tr>';
    $('#size-value-row').append(html);
}

</script>
{{-- END SCRIPT --}}


