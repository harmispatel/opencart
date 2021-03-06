<!--
    THIS IS HEADER UserGroup PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    add.blade.php
    Its Used for Insert New UserGroup
    ----------------------------------------------------------------------------------------------
-->

{{-- Header --}}
@include('header')
{{-- End Header --}}


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Users Group --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users Group</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('usersgroup') }}">Users Group</a></li>
                            <li class="breadcrumb-item active">Add</li>
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
                        {{-- Card Start --}}
                        <div class="card card-primary">
                            {{-- Card Header --}}
                            <div class="card-header d-flex justify-content-between
                            p-2" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fas fa-pencil-alt"></i>
                                    Add Users Group
                                </h3>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('storeusergroup') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="usergroupname">User Group Name</label>
                                        <input type="text" name="usergroupName" id="usergroupName" class="form-control {{ ($errors->has('usergroupName')) ? 'is-invalid' : '' }}">
                                        @if($errors->has('usergroupName'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('usergroupName') }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- <div class="form-group" >
                                        <label for="permissions">Access Permissions</label>

                                        <div class="container" style="overflow-y: scroll; box-sizing: border-box; max-height: 150px;border: 1px solid #d7dbdf;border-radius: 5px;padding:10px;">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Category</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                                <div class="col-md-1">
                                                    <label>--view</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                                <div class="col-md-1">
                                                    <label>--add</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                                <div class="col-md-1">
                                                    <label>--edit</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                            </div><hr>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Sub Category</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                                <div class="col-md-1">
                                                    <label>--view</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                                <div class="col-md-1">
                                                    <label>--add</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                                <div class="col-md-1">
                                                    <label>--edit</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                            </div><hr>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Sub Category</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                                <div class="col-md-1">
                                                    <label>--view</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                                <div class="col-md-1">
                                                    <label>--add</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                                <div class="col-md-1">
                                                    <label>--edit</label>
                                                    <input type="checkbox" name="" id="">
                                                </div>
                                            </div><hr>
                                        </div>

                                    </div> --}}

                                </div>
                                {{-- End Card Body --}}

                                {{-- Start Card Footer --}}
                                <div class="card-footer">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"> Save</i></button>
                                        <a href="{{ route('usersgroup') }}" class="btn btn-danger"><i class="fa fa-arrow-left"> Back</i></a>
                                    </div>
                                </div>
                                {{-- End Card Footer --}}

                            </form>
                            {{-- Form End --}}


                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of Add Users Group --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}

{{-- Script Section --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
</script>

{{-- End Script Section --}}

