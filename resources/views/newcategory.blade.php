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
                        <h1>Add New Category</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('category') }}">Category List </li>
                            </a>
                            <li class="breadcrumb-item active">All</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}

                </div>
                <div class="card-header d-flex justify-content-between
                        p-2"
                    style="background: #f6f6f6">
                    <h3 class="card-title pt-2" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Add Category
                    </h3>
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    {{-- <form action="{{ route('insert') }}" method="POST" enctype="multipart/form-data"> --}}
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Genral</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">SEO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Design</a>
                        </li>
                    </ul>

                    <div class="mt-3">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category">
                            </div>
                        </div>
                        <div class="form-floating">
                            <label for="description" class="form-label">Description</label>

                            <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description" style="height: 100px"></textarea>
                            <label for="description"></label>
                          </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"> Save</i></button>
                            <a href="{{ route('category') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                    Back</i></a>
                        </div>
                    </div>


                </form>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
