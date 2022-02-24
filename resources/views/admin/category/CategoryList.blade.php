@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">

{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Category List</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Category List </li>
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

                        <div class="card-header d-flex justify-content-between
                            p-2"
                            style="background: #f6f6f6">
                            <h3 class="card-title pt-2 m-0" style="color: black">
                                <i class="fa fa-list"></i>
                                Category List
                            </h3>
                            <a href="{{ route('newcategory') }}" class="btn btn-sm btn-success ml-auto"><i
                                    class="fa fa-plus"></i></a>
                            <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                    class="fa fa-trash"></i></a>
                        </div>
                        {{-- End Card Header --}}

                        {{-- Card Body --}}
                        <div class="card-body">
                            <div class="alert alert-success del-alert alert-dismissible" id="alert"
                                style="display: none" role="alert">
                                <p id="success-message" class="mb-0"></p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <table class="table table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th><input type="checkbox" name="checkall" id="delall"></th>
                                        <th>Category Name</th>
                                        <th>Sort Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center cat-list">
                                    @foreach ($fetchparent as $data)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="checkall" class="del_all">
                                            </td>
                                            <td>
                                                @if (!empty($data->cat_name))
                                                    {{ $data->cat_name }}
                                                @endif

                                            </td>
                                            <td>{{ $data->sort_order }}</td>
                                            <td>
                                                <a href="{{ 'categoryedit/' . $data->category_id }}" class="btn btn-sm btn-primary rounded">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        @php
                                            $subcat = get_subcat($data->category_id);
                                        @endphp

                                        @if (!empty($subcat))
                                            @foreach ($subcat as $scat)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="checkall" class="del_all">
                                                    </td>
                                                    <td> {{ $data->cat_name }} > {{ $scat->cat_name }} </td>
                                                    <td>{{ $scat->sort_order }}</td>
                                                    <td>
                                                        <a href="{{ 'categoryedit/' . $scat->category_id }}" class="btn btn-sm btn-primary rounded">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                @php
                                                    $dsubcat = depend_subcat($scat->category_id);
                                                @endphp

                                                @if(!empty($dsubcat))

                                                    @foreach ($dsubcat as $dcat)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="checkall" class="del_all">
                                                            </td>
                                                            <td> {{ $data->cat_name }} > {{ $scat->cat_name }} > {{ $dcat->cat_name }} </td>
                                                            <td>{{ $dcat->sort_order }}</td>
                                                            <td>
                                                                <a href="{{ 'categoryedit/' . $dcat->category_id }}" class="btn btn-sm btn-primary rounded">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                @endif

                                            @endforeach
                                        @endif


                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
@include('footer')


<script>
    $('#delall').on('click', function(e) {
        if ($(this).is(':checked', true)) {
            $(".del_all").prop('checked', true);
        } else {
            $(".del_all").prop('checked', false);
        }
    });
</script>
