@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">
<link rel="stylesheet" type="text/css"
    href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />


{{-- Section of List Category --}}
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
                            <li class="breadcrumb-item"><a href="{{ route('voucherlist') }}">Voucher List</a></li>
                            <li class="breadcrumb-item active">Free item</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}

                </div>
                <div class="card-header d-flex p-2" style="background: #f6f6f6">
                    <h3 class="card-title pt-2 m-0" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Free Item
                    </h3>
                    <div class="form-group ml-auto">
                        <button type="submit" form="voucherform" class="btn btn-primary">Save</button>
                        <a href="{{ route('freeitemlist') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            @if (count($errors) > 0)
            @if ($errors->any())
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {{ "Warning: Please check the form carefully for errors!" }}
            </div>
            @endif
            @endif

            
            <form action="{{ route('freeitemupdate',['id'=>$freeitemedit->id_free_item]) }}"  id="voucherform"  method="POST" enctype="multipart/form-data">

                <input type="hidden"  name="id_free_item " value="{{$freeitemedit->id_free_item }}">
		<div class="form-group mb-3">
                {{ @csrf_field() }}
                <div class="card-body">

                   
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active mt-3" id="nav-customer" role="tabpanel"
                            aria-labelledby="nav-customer-tab">                                         
                         
                            <div class="form-group">
                                <label for="name">* Name Item:</label>
                                <input class="form-control" name="name_item" id="name" value="{{ $freeitemedit->name_item }}" type="text"
                                    placeholder="Theme name">

                                @if ($errors->has('name_item'))
                                <div style="color: red">{{ $errors->first('name_item') }}</div>
                                @endif
                            </div>
                          
                          {{-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> --}}
                        </div>
                    </div>
                </div>

            </form>

        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
