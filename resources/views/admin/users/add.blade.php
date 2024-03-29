<!--
    THIS IS HEADER Users PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    add.blade.php
    Its Used for Insert New Users
    ----------------------------------------------------------------------------------------------
-->
{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Users --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
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
                            {{-- Form Strat --}}
                            <form action="{{ route('storeuser') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2" style="color: black">
                                        <i class="fas fa-pencil-alt mr-2"></i>
                                        INSERT
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                                        <a href="{{ route('users') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i></a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="username"><span class="text-danger">*</span>User Name</label>
                                        <input type="text" name="username" id="username" class="form-control {{ ($errors->has('username')) ? 'is-invalid' : '' }}" value="{{ old('username') }}">
                                        @if($errors->has('username'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('username') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="username"><span class="text-danger">*</span>Users Group</label>
                                        <select name="usersgroup" id="usersgroup" class="form-control {{ ($errors->has('usersgroup')) ? 'is-invalid' : '' }}">
                                            <option value="">Select User Group</option>
                                            @foreach ($usersgroup as $usergroup)
                                                <option value="{{ $usergroup->user_group_id }}" {{ (old('usersgroup') == $usergroup->user_group_id) ? 'selected' : '' }}>{{ $usergroup->name }}</option>
                                            @endforeach
                                        </select>

                                        @if($errors->has('usersgroup'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('usersgroup') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="firstname"><span class="text-danger">*</span>Firstname</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control {{ ($errors->has('firstname')) ? 'is-invalid' : '' }}" value="{{ old('firstname') }}">
                                        @if($errors->has('firstname'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('firstname') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="lastname"><span class="text-danger">*</span>Lastname</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control {{ ($errors->has('lastname')) ? 'is-invalid' : '' }}" value="{{ old('lastname') }}">
                                        @if($errors->has('lastname'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('lastname') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="email"><span class="text-danger">*</span>E-mail</label>
                                        <input type="text" name="email" id="email" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" value="{{ old('email') }}">
                                        @if($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
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
                                    </div>

                                    <div class="form-group">
                                        <label for="password"><span class="text-danger">*</span>Password</label>
                                        <input type="password" name="password" id="password" class="form-control {{ ($errors->has('password')) ? 'is-invalid' : '' }}">
                                        @if($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm"><span class="text-danger">*</span>Confirm Password</label>
                                        <input type="password" name="confirm" id="confirm" class="form-control {{ ($errors->has('confirm')) ? 'is-invalid' : '' }}">
                                        @if($errors->has('confirm'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('confirm') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="status"><span class="text-danger">*</span>Stores</label>
                                        <select name="store" id="store" class="form-control {{ ($errors->has('store')) ? 'is-invalid' : '' }}">
                                            <option value="">Select Your Store</option>
                                            @foreach ($stores as $store)
                                                <option value="{{ $store->store_id }}">{{ $store->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('store'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('store') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" selected>Enabled</option>
                                            <option value="0">Disabled</option>
                                        </select>
                                    </div>

                                </div>
                                {{-- End Card Body --}}
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
{{-- End Section of Add Users--}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}

<script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>


<script>
     $('#lfm').filemanager('file');
    var route_prefix = "filemanager";
    $('#lfm').filemanager('image', {prefix: route_prefix});
</script>
