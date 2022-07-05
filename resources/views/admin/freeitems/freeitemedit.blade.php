<!--
    THIS IS HEADER FREEITEMEEDIT PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    freeitemedit.blade.php
    This for Edit FreeIteme
    ----------------------------------------------------------------------------------------------
-->

{{-- Header --}}
@include('header')
{{-- End Header --}}


{{-- Section of Edit Free Item --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Free Item</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('freeitemlist') }}">Free Items</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Edit Section Start --}}
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
                            <form action="{{ route('freeitemupdate',['id'=>$freeitemedit->id_free_item]) }}"  id="voucherform"  method="POST" enctype="multipart/form-data">
                            {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-pencil-alt pr-2"></i>
                                        EDIT
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a href="{{ route('freeitemlist') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="hidden"  name="id_free_item " value="{{$freeitemedit->id_free_item }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name"><span class="text-danger">*</span> Item Name</label>
                                        <input class="form-control {{ ($errors->has('name_item')) ? 'is-invalid' : '' }}" name="name_item" id="name" value="{{ $freeitemedit->name_item }}" type="text" placeholder="Theme name">
                                        @if ($errors->has('name_item'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name_item') }}
                                            </div>
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
        {{-- End Edit Section Start --}}
    </div>
</section>
{{-- End Section of Edit Free Item --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}
