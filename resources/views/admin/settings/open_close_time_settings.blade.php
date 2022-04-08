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
                                    <button type="submit" form="openclosetime" class="btn btn-sm btn-primary ml-auto"><i class="fa fa-save"></i></button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('openclosetimeset') }}" method="POST" id="openclosetime">
                                    {{ csrf_field() }}
                                    <h1 class="text-center">Opening Closing Times</h1>
                                    <h4 class="text-success" style="border-bottom: 1px dotted black">BUSSINESS HOURS
                                    </h4>
                                    <div class="addnewtime">
                                        {{-- <div class="form-row justify-content-between add">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select class="form-control js-example-basic-multiple text-dark"
                                                        multiple="multiple" id="days" name="bussinessdays[]">
                                                        @foreach ($days as $key => $day)
                                                            <option value="{{ $key }}">{{ $day }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="form-group col-md-5">
                                                        <select class="form-control js-example-basic-multiple text-dark"
                                                            id="starttime" name="bussinessstarttime[]">
                                                            @foreach ($times as $key => $time)
                                                                <option value="{{ $time }}">{{ $time }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <select class="form-control js-example-basic-multiple text-dark"
                                                            id="endtime" name="bussinessendtime[]">
                                                            @foreach ($times as $key => $time)
                                                                <option value="{{ $time }}"
                                                                    selected="{{ $time == '23:50' ? $time : 'selected' }}">
                                                                    {{ $time }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2 pt" style="padding-top: 6px;">
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="$('.add').remove()" type="button">X</button>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="col-sm-12">
                                        <span class="btn btn-primary addtime" id="bussines">+Add another set of
                                            hours</span>
                                    </div>
                                    <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">CLOSING DATES
                                    </h4>
                                    <div class="row adddate">
                                        {{-- <div class="col-md-4 py-2">
                                            <input type="date" name="closingdate[]" class="form-control">
                                        </div> --}}
                                    </div>
                                    <div class="col-sm-12">
                                        <span class="btn btn-primary addnewdate" id="bussines">+Add another closing
                                            date</span>
                                    </div>

                                    <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">DELIVERY HOURS</h4>

                                    <div class="form-group row col-sm">
                                        <label class=" col-form-label">Same as bussiness hours</label>
                                        <div class="d-flex pl-5">
                                            <div class="form-check form-check-inline ">
                                                <input class="form-check-input" type="radio" name="deliveryhours[]"
                                                    id="samebisinessyes" value="1" checked>
                                                <label class="form-check-label" for="samebisinessyes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="deliveryhours[]"
                                                    id="samebisinessno" value="0">
                                                <label class="form-check-label" for="samebisinessno">No</label>
                                            </div>
                                        </div>
                                        <div class="form-group row float-right">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">GAP</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="deliverygap" id="staticEmail">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="addsamebisinesshours"></div>
                                    <div class="col-sm-12 samebisiness" style="display: none">
                                        <span class="btn btn-primary addsamebisiness" id="bussines">+Add another set of hours</span>
                                    </div>

                                    <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">COLLECTION HOURS</h4>
                                    <div class="form-group row col-sm">
                                        <label class=" col-form-label">Same as bussiness hours</label>
                                        <div class="d-flex pl-5">
                                            <div class="form-check form-check-inline ">
                                                <input class="form-check-input" type="radio" name="collectionhours[]"
                                                    id="deleveryyes" value="1" checked>
                                                <label class="form-check-label" for="deleveryyes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="collectionhours[]"
                                                    id="collection" value="0">
                                                <label class="form-check-label" for="collection">No</label>
                                            </div>
                                        </div>
                                        <div class="form-group row float-right">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">GAP</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="staticEmail" name="collectiongap">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adddeleverycolection"></div>
                                    <div class="col-sm-12 collection" style="display: none">
                                        <span class="btn btn-primary deleverycolection" id="bussines">+Add another set of hours</span>
                                    </div>
                                    <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">SETTING ORDER</h4>
                                    <div class="form-group row align-items-center">
                                        <label for="inputPassword" class="col-sm-8 col-form-label">Accept orders out of bussiness hours?</label>
                                        <div class="col-sm-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="acceptorder[]" id="acceptedyes" value="1">
                                                <label class="form-check-label" for="acceptedyes">1</label>
                                              </div>
                                              <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="acceptorder[]" id="acceptedno" value="0">
                                                <label class="form-check-label" for="acceptedno">2</label>
                                              </div>
                                        </div>
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
$('.multipalselect').siblings().addClass('js-example-basic-multiple');
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
                            
       

        var id = 0;
        // Add bussiness hours
        $('.addtime').click(function () {            
            $('.addnewtime').append('<div class="form-row justify-content-between add'+ id +'">'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group">'+
                                                '<select class="form-control multipalselect" multiple="multiple"  name="bussines[days]['+id+'][]">'+
                                                    '@foreach ($days as $key => $day)'+
                                                        '<option value="{{ $key }}">{{ $day }}</option>'+
                                                    '@endforeach'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<div class="row">'+
                                                '<div class="form-group col-md-5">'+
                                                    '<select class="form-control js-example-basic-multiple text-dark" id="starttime" name="bussines[from]['+id+']">'+
                                                        '@foreach ($times as $key => $time)'+
                                                            '<option value="{{ $time }}">{{ $time }}</option>'+
                                                        '@endforeach'+
                                                    '</select>'+
                                                '</div>'+
                                                '<div class="form-group col-md-5">'+
                                                    '<select class="form-control js-example-basic-multiple text-dark" id="endtime" name="bussines[to]['+id+']">'+
                                                        '@foreach ($times as $key => $time)'+
                                                            '<option value="{{ $time }}" selected="{{ $time == '23:50' ? $time : 'selected' }}">{{ $time }}</option>'+
                                                        '@endforeach'+
                                                    '</select>'+
                                                '</div>'+
                                                '<div class="form-group col-md-2 pt" style="padding-top: 6px;">'+
                                                    '<button class="btn btn-sm btn-danger remove" onclick="$(\'.add' + id + '\').remove()" type="button">X</button>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>');
                                    id ++;
             });


        // Add bussiness hours
        var closedate = 0
        $('.addnewdate').click(function () {            
            $('.adddate').append('<div class="col-md-4 py-2">'+
                                    '<input type="date" name="closingdate['+closedate+']" class="form-control">'+
                                '</div>');
                                closedate++
        });


        // Same as bussiness hours
        $('#samebisinessno').on('click', function() {
            $('.samebisiness').show();

            var id = 0;
        // Add bussiness hours
        $('.addsamebisiness').click(function () {            
            $('.addsamebisinesshours').append('<div class="form-row justify-content-between addsamebisiness'+ id +'">'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group">'+
                                                '<select class="form-control multipalselect" multiple="multiple"  name="delivery[days]['+id+'][]">'+
                                                    '@foreach ($days as $key => $day)'+
                                                        '<option value="{{ $key }}">{{ $day }}</option>'+
                                                    '@endforeach'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<div class="row">'+
                                                '<div class="form-group col-md-5">'+
                                                    '<select class="form-control js-example-basic-multiple text-dark" id="starttime" name="delivery[form][]">'+
                                                        '@foreach ($times as $key => $time)'+
                                                            '<option value="{{ $time }}">{{ $time }}</option>'+
                                                        '@endforeach'+
                                                    '</select>'+
                                                '</div>'+
                                                '<div class="form-group col-md-5">'+
                                                    '<select class="form-control js-example-basic-multiple text-dark" id="endtime" name="delivery[to][]">'+
                                                        '@foreach ($times as $key => $time)'+
                                                            '<option value="{{ $time }}" selected="{{ $time == '23:50' ? $time : 'selected' }}">{{ $time }}</option>'+
                                                        '@endforeach'+
                                                    '</select>'+
                                                '</div>'+
                                                '<div class="form-group col-md-2 pt" style="padding-top: 6px;">'+
                                                    '<button class="btn btn-sm btn-danger remove" onclick="$(\'.addsamebisiness' + id + '\').remove()" type="button">X</button>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>');
                                    id ++;
             });
        });

        $('#samebisinessyes').on('click', function() {
            console.log("yes");
            $('.samebisiness').hide();
        });


        // COLLECTION HOURS
        $('#collection').on('click', function() {
            $('.collection').show();

            var id = 0;
        // Add bussiness hours
        $('.deleverycolection').click(function () {            
            $('.adddeleverycolection').append('<div class="form-row justify-content-between addsamebisiness'+ id +'">'+
                                        '<div class="col-md-4">'+
                                            '<div class="form-group">'+
                                                '<select class="form-control multipalselect" multiple="multiple"  name="collection[days]['+id+'][]">'+
                                                    '@foreach ($days as $key => $day)'+
                                                        '<option value="{{ $key }}">{{ $day }}</option>'+
                                                    '@endforeach'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-4">'+
                                            '<div class="row">'+
                                                '<div class="form-group col-md-5">'+
                                                    '<select class="form-control js-example-basic-multiple text-dark" id="starttime" name="collection[form][]">'+
                                                        '@foreach ($times as $key => $time)'+
                                                            '<option value="{{ $time }}">{{ $time }}</option>'+
                                                        '@endforeach'+
                                                    '</select>'+
                                                '</div>'+
                                                '<div class="form-group col-md-5">'+
                                                    '<select class="form-control js-example-basic-multiple text-dark" id="endtime" name="collection[to][]">'+
                                                        '@foreach ($times as $key => $time)'+
                                                            '<option value="{{ $time }}" selected="{{ $time == '23:50' ? $time : 'selected' }}">{{ $time }}</option>'+
                                                        '@endforeach'+
                                                    '</select>'+
                                                '</div>'+
                                                '<div class="form-group col-md-2 pt" style="padding-top: 6px;">'+
                                                    '<button class="btn btn-sm btn-danger remove" onclick="$(\'.addsamebisiness' + id + '\').remove()" type="button">X</button>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>');
                                    id ++;
            });
        });

        $('#samebisinessyes').on('click', function() {
            console.log("NO");
            $('.collection').hide();
        });
      



                                     
                                                

    });
</script>
