@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Country --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Countries</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('countries') }}">Countries</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                                    Edit Country
                                </h3>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('updatecountry') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    <input type="hidden" id='id' name="id" value="{{ $country->country_id }}">

                                    <div class="form-group">
                                        <label for="name">Country Name</label>
                                        <input type="text" name="name" id="name" class="form-control {{ ($errors->has('username')) ? 'is-invalid' : '' }}" value="{{ $country->name }}">
                                        @if($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="iso_code_2">Users Group</label>
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
                                    </div> --}}

                                    <div class="form-group">
                                        <label for="iso_code_2">IOS Code (2)</label>
                                        <input type="text" name="iso_code_2" id="iso_code_2" class="form-control {{ ($errors->has('iso_code_2')) ? 'is-invalid' : '' }}" value="{{ $country->iso_code_2 }}"  minlength="2" maxlength="2">
                                        @if($errors->has('iso_code_2'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('iso_code_2') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="iso_code_3">IOS Code (3)</label>
                                        <input type="text" name="iso_code_3" id="iso_code_3" class="form-control {{ ($errors->has('iso_code_3')) ? 'is-invalid' : '' }}" value="{{ $country->iso_code_3 }}" minlength="3" maxlength="3">
                                        @if($errors->has('iso_code_3'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('iso_code_3') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="address_format">Address Format</label>
                                        <input type="text" name="address_format" id="address_format" class="form-control {{ ($errors->has('address_format')) ? 'is-invalid' : '' }}" value="{{ $country->address_format }}">
                                        @if($errors->has('address_format'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('address_format') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="postcode_required">Postcode Required</label>
                                        <select name="postcode_required" id="postcode_required" class="form-control">
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="postcode_required">Postcode Required</label>
                                        <input type="postcode_required" name="postcode_required" id="postcode_required" class="form-control {{ ($errors->has('postcode_required')) ? 'is-invalid' : '' }}">
                                        @if($errors->has('postcode_required'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('postcode_required') }}
                                            </div>
                                        @endif
                                    </div> --}}

                                    {{-- <div class="form-group">
                                        <label for="status">Status</label>
                                        <input type="status" name="status" id="status" class="form-control {{ ($errors->has('status')) ? 'is-invalid' : '' }}">
                                        @if($errors->has('status'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('status') }}
                                            </div>
                                        @endif
                                    </div> --}}

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
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"> Update</i></button>
                                        <a href="{{ route('countries') }}" class="btn btn-danger"><i class="fa fa-arrow-left"> Back</i></a>
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
