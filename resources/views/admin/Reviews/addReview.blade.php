@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Reviews</h1>

                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('addReview') }}">Reviews
                            </li>
                            </a>
                            {{-- <li class="breadcrumb-item active">All</li> --}}
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary"><i
                                class="fa fa-save">Save</i></button>
                        <a href="{{ route('addReview') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                Back</i></a>
                    </div>
                </div>
                <div class="card-header d-flex justify-content-between
                        p-2"
                    style="background: #f6f6f6">
                    <h3 class="card-title pt-2" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                      Add Reviews
                    </h3>

                </div>
                {{-- </section>
        {{-- End Header Section --}}

                {{-- List Section Start --}}
                {{-- <section class="content"> --}}
                <form action="{{ route('addReview') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" name="author" class="form-control" id="author"
                            placeholder="Author">
                    </div>

                    <div class="mb-3">
                        <label for="sortorder" class="form-label">Product</label>
                            <select name="product" id="product" class="form-control">
                                <option></option>
                                @foreach ($review as  $reviews)
                                <option value="{{ $reviews->name }}">{{ $reviews->name }}</option>
                                @endforeach
                            </select>
                    </div>

                    <div class="mb-3">
                        <label for="text" class="form-label">Text</label>
                        <textarea name="text" class="form-control" id="text"  rows="6" placeholder="Text">
                        </textarea>
                    </div>

                    <div class="mb-3">
                        <label for="text" class="form-label">Rating </label>&nbsp&nbsp&nbsp&nbsp
                         <input type="radio" name="name" value="1">&nbsp 1 &nbsp&nbsp&nbsp
                         <input type="radio" name="name" value="1">&nbsp 2 &nbsp&nbsp&nbsp
                         <input type="radio" name="name" value="1">&nbsp 3 &nbsp&nbsp&nbsp
                         <input type="radio" name="name" value="1">&nbsp 4 &nbsp&nbsp&nbsp
                         <input type="radio" name="name" value="1">&nbsp 5 &nbsp&nbsp&nbsp
                    </div>

                    <div class="col-md-6">
                        <label for="text" class="form-label">Date Added</label>
                        <input type="date" name="date" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                       <select name="status" id="status" class="form-control">
                          <option value="1">Enabled</option>
                          <option value="0" selected>Disabled</option>
                       </select>
                    </div>
                </form>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
