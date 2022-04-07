{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

<style>

    .deliveryby:checked + label
    {
        color: blue;
    }
</style>

{{-- Section of List Delivery Collection Settings --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if(Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Delivery Collection Settings</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Delivery Collection Settings</li>
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
                        <div class="card">
                            {{-- Form --}}
                            <form method="POST" action="{{ route('updatesociallinks') }}" enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2" style="color: black">
                                        <i class="fas fa-cog mr-2"></i>
                                        SETTINGS
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                 {{-- Card Body --}}
                                 <div class="card-body">
                                    <div class="card">
                                        <div class="card-body" style="background: #e6e6e6;">
                                            <div class="form-group">
                                                <label>Enable Delivery/Collection</label>
                                                <div class="form-control">
                                                    <input type="radio" name="enable_delivery" value="delivery" onclick="">
                                                    <label class="mr-4">Delivery</label>
                                                    <input type="radio" name="enable_delivery" value="collection">
                                                    <label class="mr-4">Collection</label>
                                                    <input type="radio" name="enable_delivery" value="both">
                                                    <label>Both</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="content">
                                        <div class="form-group">
                                            <label>Delivery By</label><br>
                                            <span class="p-2 rounded mr-2" style="background: #dbc5b8;">
                                                <input type="radio" class="deliveryby" name="delivery_option" id="postcode">
                                                <label class="ml-1" for="postcode" style="cursor: pointer;">POST CODE SECTORS</label>
                                            </span>
                                            <span class="p-2 rounded mr-2" style="background: #dbc5b8;">
                                                <input type="radio" class="deliveryby" name="delivery_option" id="distance">
                                                <label class="ml-1" for="distance" style="cursor: pointer;">DISTANCE</label>
                                            </span>
                                            <span class="p-2 rounded mr-2" style="background: #dbc5b8;">
                                                <input type="radio" class="deliveryby" name="delivery_option" id="area_name">
                                                <label class="ml-1" for="area_name" style="cursor: pointer;">AREA NAMES</label>
                                            </span>
                                        </div>
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
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Delivery Collection Settings --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}
