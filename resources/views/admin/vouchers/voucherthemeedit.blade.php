<!--
    THIS IS HEADER VoucherThemeEdit PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    voucherthemeedit.blade.php
    This for Edit VoucherTheme
    ----------------------------------------------------------------------------------------------
-->

{{-- Hedaer --}}
@include('header')
{{-- End Header --}}


{{-- Section of Edit Voucher Themes --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Voucher Themes</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vouchertheme') }}">Voucher Themes</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Edit Data Section --}}
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
                        {{-- Card --}}
                        <div class="card">
                            {{-- Form --}}
                            <form action="{{ route('voucherthemeupdate') }}" id="voucherform" method="POST"
                                enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fas fa-pencil-alt"></i>
                                        EDIT
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a href="{{ route('vouchertheme') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id"
                                            value="{{ $voucherthemenameedit->voucher_theme_id }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name"><span class="text-danger">*</span> Voucher Theme
                                            Name</label>
                                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            name="name" id="name" value="{{ $voucherthemenameedit->name }}"
                                            type="text">
                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="image"><span class="text-danger">*</span> Image</label>
                                        <input class="form-control p-1" name="image" id="image" type="file">
                                    </div>
                                    <div class="form-group">
                                        @if (!empty($vouchertheme->image) || $vouchertheme->image != '')
                                            <img src="{{ asset('public/admin/voucherthemes/' . $vouchertheme->image) }}"
                                                width="60">
                                        @endif
                                    </div>
                                </div>
                                {{-- End Card Body --}}
                            </form>
                            {{-- End Form --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Edit Data Section --}}
    </div>
</section>
{{-- End Section of Edit Voucher Themes --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}
