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
                        <h1>Bulk Category</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bulk Category</li>
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
                                    <i class="fa fa-list pr-2"></i>
                                    Bulk Category
                                </h3>

                                {{-- <div class="container" style="text-align: right">
                                    @if (check_user_role(71) == 1)
                                    <a href="" class="btn btn-sm btn-success ml-auto"><i class="fa fa-plus"></i></a>
                                    @endif

                                    @if (check_user_role(73) == 1)
                                    <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                            class="fa fa-trash"></i></a>
                                    @endif
                                </div> --}}
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">


                                <form action="" method="POST">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 15%">Name*</th>
                                                <th scope="col" style="width: 20%">Description</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Options</th>
                                                <th scope="col">Active</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="align-middle">
                                                    {{-- <input class="form-control form-control-sm" type="text"
                                                        placeholder="Category Name"> --}}
                                                    <input type="text" id="cname" placeholder="Category Name">
                                                </th>
                                                <td class="align-middle">
                                                    <textarea id="textarea" rows="2" style="height: 50px;"></textarea>
                                                </td>
                                                <td>Image</td>
                                                <td>
                                                    <div>
                                                        <label for="size" class="" style="min-width: 100px">Size</label>
                                                        <input type="radio" name="size" value="1"
                                                            onclick="$('#size-value').show()"> Enable &nbsp;
                                                        <input type="radio" name="size" value="0"
                                                            onclick="$('#size-value').hide()" checked> Disable
                                                    </div>


                                                    <table class="table table-bordered" style="display: none"
                                                        id="size-value">
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
                                                                <td></td>
                                                                <td></td>
                                                                <td colspan="3" class="text-center">
                                                                    <a class="btn btn-sm btn-primary" onclick="addsizevalue()">ADD</a>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    {{-- <br> --}}
                                                    <label class="form-check-label"
                                                        style="min-width: 100px">Option</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="option"
                                                            id="optione" value="1">
                                                        <label class="form-check-label" for="optione">Enable</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="option"
                                                            id="optiond" value="0" checked>
                                                        <label class="form-check-label" for="optiond">Disable</label>
                                                    </div>
                                                    <br>
                                                    <label class="form-check-label" style="min-width: 100px">Comment
                                                        Box</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="comment"
                                                            id="commente" value="1">
                                                        <label class="form-check-label" for="commente">Enable</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="comment"
                                                            id="commentd" value="0" checked>
                                                        <label class="form-check-label" for="commentd">Disable</label>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <a class="btn btn-sm btn-danger" href="#" role="button">Delete</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td><a id="addcatbulk" class="btn btn-sm btn-primary">Add</a></td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </form>
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
{{-- End Section of List Manufacturers --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">
    // Add Size Function
    var size_value_row = 0;

    function addsizevalue() {
        size_value_row++;
        html = '  <tr class="size_' + size_value_row + '">';
        html += '    <td><input type="text" name="size[' + size_value_row +
            '][size]" value="" / placeholder="Size" class="form-control"></td>';
        html += '    <td><input type="text" name="size[' + size_value_row +
            '][short_order]" value="" / placeholder="Sort Order" class="form-control"></td>';
        html += '    <td><a onclick="$(\'.size_' + size_value_row +
            '\').remove();" class="btn btn-sm bg-primary">Delete</a></td>';
        // html += '    <td><a onclick="$(\'.size_' + size_value_row + '\').remove();" class="btn btn-sm" style="background:#1bbc9b;color: white;">Edit</a></td>';
        html += '  </tr>';
        $('#size-value-row').append(html);
    }
</script>
