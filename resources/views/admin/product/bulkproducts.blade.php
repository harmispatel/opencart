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
                                        {{-- @foreach ($category as $categorys)
                                            <option value="{{ $categorys->category_id }}">{{ $categorys->name }}
                                            </option>
                                        @endforeach --}}

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
                                        <th>
                                            <input type="checkbox" name="checkall" id="delall">
                                        </th>
                                        <th id="name">Product Name</th>
                                        <th id="Description">Description</th>
                                        <th id="price">Price</th>
                                        <th id="image">Image</th>
                                        <th id="option">Option</th>
                                        <th id="action">Action</th>
                                        {{-- <tr><td colspan="3"><td>1</td></tr> --}}
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body --}}
                                    <tbody class="text-center cat-list">
                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="text-center"><button type="button" onclick="addProduct();"
                                                    data-toggle="tooltip" title="Add Product"
                                                    class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    {{-- End Table Body --}}
                                </table>
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

<script type="text/javascript">
     var product_row=0;
    //  html ='';
   function addProduct(){
     html ='<tr>';
     html +='<td></td>';   
     html +='<td><input type="text" name="name" class="form-control"></td>';
     html +='<td><textarea type="text" name="address" class="form-control" ></textarea></td>';   
     html +='<td><input type="text" name="price" class="form-control"></td>';
     html +='<td><input type="file" name="price" class="form-control"></td>';
     html +=`<td><h5>hello</h5><div><input type="radio" name="typetopping" class="avtive" value="select">Dropdown&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="typetopping" value="checkbox">Checkbox&nbsp;&nbsp;&nbsp;&nbsp;</div></td></tr>`;
     $('.cat-list').append(html);;
   }
</script>
