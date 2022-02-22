@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">

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
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card card-primary">
                            {{-- Card Header --}}
                            <div class="card-header d-flex justify-content-between
                            p-2" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fas fa-pencil-alt"></i>
                                    Add User
                                </h3>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('storeuser') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" class="form-control {{ ($errors->has('username')) ? 'is-invalid' : '' }}" value="{{ old('username') }}">
                                        @if($errors->has('username'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('username') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Users Group</label>
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
                                        <label for="firstname">Firstname</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control {{ ($errors->has('firstname')) ? 'is-invalid' : '' }}" value="{{ old('firstname') }}">
                                        @if($errors->has('firstname'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('firstname') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="lastname">Lastname</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control {{ ($errors->has('lastname')) ? 'is-invalid' : '' }}" value="{{ old('lastname') }}">
                                        @if($errors->has('lastname'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('lastname') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="text" name="email" id="email" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" value="{{ old('email') }}">
                                        @if($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" style="padding:3px;" id="image" class="form-control {{ ($errors->has('image')) ? 'is-invalid' : '' }}" value="{{ old('image') }}">
                                        @if($errors->has('image'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('image') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control {{ ($errors->has('password')) ? 'is-invalid' : '' }}">
                                        @if($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm">Confirm Password</label>
                                        <input type="password" name="confirm" id="confirm" class="form-control {{ ($errors->has('confirm')) ? 'is-invalid' : '' }}">
                                        @if($errors->has('confirm'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('confirm') }}
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

                                {{-- Start Card Footer --}}
                                <div class="card-footer">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"> Save</i></button>
                                        <a href="{{ route('usersgroup') }}" class="btn btn-danger"><i class="fa fa-arrow-left"> Back</i></a>
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
{{-- End Section of Add Users--}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

</script>
