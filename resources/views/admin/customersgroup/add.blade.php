<!--
    THIS IS HEADER CustomerGroup PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    add.blade.php
    Its Used for Insert New CustomerGroup
    ----------------------------------------------------------------------------------------------
-->


{{-- Header --}}
@include('header')
{{-- End  Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Customer Group --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customers Group</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customersgroup') }}">Customers Group</a></li>
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
                                    <i class="fas fa-pencil-alt mr-2"></i>
                                    Add Customer Group
                                </h3>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('storecustomergroup') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="customergroupname">Customer Group Name</label>
                                        <input type="text" name="customergroupname" id="customergroupname" class="form-control {{ ($errors->has('customergroupname')) ? 'is-invalid' : '' }}">
                                        @if($errors->has('customergroupname'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('customergroupname') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="approve">Approve New Customer</label>
                                        <div class="form-control">
                                            <label for="yes">Yes</label>
                                            <input type="radio" name="approve" id="approve" value="1" {{ (old('approve') == 1) ? 'checked' : '' }}>
                                            <label for="yes">No</label>
                                            <input type="radio" name="approve" id="approve" value="0" {{ (old('approve') == 1) ? '' : 'checked' }}>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sortorder">Sort Order</label>
                                        <input type="number" name="sortorder" id="sortorder" class="form-control" value="{{ old('sortorder') }}">
                                    </div>

                                </div>
                                {{-- End Card Body --}}

                                {{-- Start Card Footer --}}
                                <div class="card-footer">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"> Save</i></button>
                                        <a href="{{ route('customersgroup') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"> Back</i></a>
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
