@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" /> --}}

{{-- Section of List Open/Close Time Settings --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Open/Close Time Settings</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Open/Close Time Settings </li>
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
                            <div class="card-header" style="background: #f6f6f6">
                                <div class="container" style="text-align: right">
                                    <button  class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form>
                                    <h1 class="text-center">Opening Closing Times</h1>
                                    <h4 class="text-success" style="border-bottom: 1px dotted black">BUSSINESS HOURS
                                    </h4>
                                    <div class="addnewtime">

                                    </div>
                                    <div class="form-row justify-content-between">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control js-example-basic-multiple text-dark"
                                                    multiple="multiple" id="days" name="days[]">
                                                    @foreach ($days as $key => $day)
                                                        <option value="{{ $key }}">{{ $day }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="form-group col-md-5">
                                                    <select class="form-control js-example-basic-multiple text-dark"
                                                    id="starttime" name="starttime[]">
                                                    @foreach ($times as $key => $time)
                                                        <option value="{{ $time }}">{{ $time }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <select class="form-control js-example-basic-multiple text-dark"
                                                    id="endtime" name="endtime[]">
                                                    @foreach ($times as $key => $time)
                                                        <option value="{{ $time }}" selected="{{ ($time == '23:50') ? $time : 'selected' }}">{{ $time }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                                <div class="form-group col-md-2 pt" style="padding-top: 6px;">
                                                    <button class="btn btn-sm btn-danger" onclick="$('.addnewtime').remove()" type="button">X</button>
                                                </select>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <span class="btn btn-primary addtime"  id="bussines">+Add another set of hours</span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Open/Close Time Settings --}}



@include('footer')

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script> --}}

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
       

        // Add bussiness hours
        $('.addtime').click(function () { 
           
        $('.addnewtime').append('<div class="form-row justify-content-between">'+
                                    '<div class="col-md-4">'+
                                        '<div class="form-group">'+
                                            '<select class="js-example-basic-multiple form-control"  name="days">'+
                                                '@foreach ($days as $key => $day)'+
                                                    '<option value="{{ $key }}">{{ $day }}</option>'+
                                                '@endforeach'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-4">'+
                                        '<div class="row">'+
                                            '<div class="form-group col-md-5">'+
                                                '<select class="form-control js-example-basic-multiple text-dark" id="starttime" name="starttime[]">'+
                                                    '@foreach ($times as $key => $time)'+
                                                        '<option value="{{ $time }}">{{ $time }}</option>'+
                                                    '@endforeach'+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="form-group col-md-5">'+
                                                '<select class="form-control js-example-basic-multiple text-dark" id="endtime" name="endtime[]">'+
                                                    '@foreach ($times as $key => $time)'+
                                                        '<option value="{{ $time }}" selected="{{ $time == '23:50' ? $time : 'selected' }}">{{ $time }}</option>'+
                                                    '@endforeach'+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="form-group col-md-2 pt" style="padding-top: 6px;">'+
                                                '<button class="btn btn-sm btn-danger" onclick="$(".addnewtime").remove()" type="button">X</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                            });
                            
    });
    
</script>
