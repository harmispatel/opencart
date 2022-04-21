@include('header')
<style>
    .select2-selection__choice{
        background-color: white!important;
        color: black!important;
    }
</style>
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
            @if(Session::has('success'))
            <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
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
                                    <h4 class="text-success" style="border-bottom: 1px dotted black">BUSSINESS HOURS</h4>
                                    <div class="col-sm-12" id="bussinestime">
                                        @php $key_bussines = 0; @endphp
                                            @if(isset($bussines['day']) && count($bussines['day']))
                                                @foreach($bussines['day'] as $keyday => $daytime)
                                                    <div id="bussines_{{ $key_bussines }}" class="bussines col-sm-12">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="form-group col-sm-6">
                                                                <select class="selectday form-control" name="bussines[day][{{ $key_bussines }}][]" class="form-control" multiple="multiple" style="width: 100% !importent;">
                                                                    @foreach($days as $key => $day)
                                                                        <option @if(in_array($key, $daytime)) {{'selected'}} @endif value="{{ $key }}">{{ $day }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="form-group">
                                                                    <select class="selectday form-control" name="bussines[from][{{ $key_bussines }}]" class="form-control" style="width: 100% !importent;">
                                                                        @foreach($times as $key => $time)
                                                                            <option @if (isset($bussines['from'][$keyday]) && $bussines['from'][$keyday] == $key)  {{'selected'}} @endif value="{{ $key }}">{{ $time }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group px-3">
                                                                    <select class="selectday form-control" name="bussines[to][{{ $key_bussines }}]" class="form-control" style="width: 100% !importent;">
                                                                        @foreach($times as $key => $time)
                                                                        <option @if (isset($bussines['to'][$keyday]) && $bussines['to'][$keyday] == $key) {{'selected' }}  @endif value="{{ $key }}">{{ $time }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="btn btn-default" onclick="$('#bussines_{{ $key_bussines }}').remove();">X</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php $key_bussines++; @endphp
                                                @endforeach
                                            @endif
                                        <div class="col-sm-12">
                                            <span class="btn btn-primary addtime" rel="bussines">+Add another set of hours</span>
                                        </div>
                                    </div>
                                        <!-- end bussinestime -->


                                        <!--Closing Dates--->
                                        <div class="col-sm-12" id="closingdates">
                                            <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">CLOSING DATES</h4>
                                            <div class="row">
                                                @if ($closedate > 0)
                                                    @if(isset($closedate) && !empty(array_filter($closedate)))
                                                        @foreach (array_filter($closedate) as $key => $value )
                                                        <div class="col-md-4 py-2">
                                                            <input type="date" name="closing_dates[{{$key}}]" class="multi-dates form-control" value="{{$value}}">
                                                        </div>
                                                        @endforeach
                                                    @else
                                                    <div class="col-md-4 py-2">
                                                        <input type="date" name="closing_dates[0]" class="multi-dates form-control" value="">
                                                    </div>
                                                    @endif
                                                @endif
                                                <div class="col-sm-12 py-3">
                                                    <span class="btn btn-primary adddates" rel="closingdates">+Add another closing date</span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-sm-12" id="deliverytime">
                                            <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">DELIVERY HOURS</h4>
                                            <div class="col-sm-12 d-flex">
                                                <div class="col-sm-8 d-flex">
                                                    <label class="control-label col-sm-4">Same as bussiness hours</label>
                                                    <p>
                                                    <input class="switch-size" {{ (isset($timesetting['delivery_same_bussiness']) && $timesetting['delivery_same_bussiness'] == 1) ? 'checked="checked"' : '' }} name="delivery_same_bussiness" type="radio" value="1" onclick="$('#delivery_same_bussiness').hide();" />Yes
                                                    <input class="switch-size" {{ (!(isset($timesetting['delivery_same_bussiness']) && $timesetting['delivery_same_bussiness'] == 1)) ? 'checked="checked"' : '' }} name="delivery_same_bussiness" type="radio" value="0" onclick="$('#delivery_same_bussiness').show();" />No
                                                    </p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span>GAP</span>
                                                    {{-- value="{{ $timesetting['delivery_gaptime'] ? $timesetting['delivery_gaptime'] : ""  }}" --}}
                                                    <input type="text" value="{{ (isset($timesetting['delivery_gaptime'])) ? $timesetting['delivery_gaptime'] : '' }}" name="delivery_gaptime" />
                                                    <span>Min</span>
                                                </div>
                                            </div>
                                            @php $key_delivery = 0; @endphp
                                            <div id="delivery_same_bussiness" style="display: {{ (isset($timesetting['delivery_same_bussiness']) && $timesetting['delivery_same_bussiness'] == 1) ? 'none' : 'block' }}" >
                                                @if(isset($delivery['day']) && count($delivery['day']))
                                                    @foreach($delivery['day'] as $keyday => $daytime)
                                                        <div id="delivery_{{ $key_delivery }}" class="delivery col-sm-12">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="form-group col-sm-6">
                                                                    <select class="selectday" name="delivery[day][{{ $key_delivery}}][]" class="form-control" multiple="multiple" style="width: 100% !importent;">
                                                                        @foreach($days as $key => $day)
                                                                        <option @if (in_array($key, $daytime)) {{'selected'}} @endif value="{{ $key}}">{{$day}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="form-group">
                                                                        <select class="selectday" name="delivery[from][{{$key_delivery}}]" class="form-control" style="width: 100% !importent;">
                                                                            @foreach($times as $key => $time)
                                                                                <option @if (isset($delivery['from'][$keyday]) && $delivery['from'][$keyday] == $key)  {{'selected'}} @endif value="{{$key}}">{{$time}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group px-3">
                                                                        <select class="selectday" name="delivery[to][{{ $key_delivery }}]" class="form-control" style="width: 100% !importent;">
                                                                            @foreach($times as $key => $time)
                                                                                <option @if (isset($delivery['to'][$keyday]) && $delivery['to'][$keyday] == $key)  {{'selected'}} @endif value=" {{$key}}">{{$time}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <span class="btn btn-default" onclick="$('#delivery_{{$key_delivery}}').remove();">X</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $key_delivery++ @endphp
                                                    @endforeach
                                                @endif
                                                <div class="col-sm-12">
                                                    <span class="btn btn-primary addtime" rel="delivery">+Add another set of hours</span>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- end delivery time -->

                                    <!-- start collection time -->
                                    <div class="col-sm-12" id="collection">
                                        <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">COLLECTION HOURS</h4>
                                        <div class="col-sm-12 d-flex">
                                            <div class="col-sm-8 d-flex">
                                                <label class="control-label col-sm-4">Same as bussiness hours</label>
                                                <p>
                                                <input class="switch-size" {{ (isset($timesetting['collection_same_bussiness']) && $timesetting['collection_same_bussiness'] == 1) ? 'checked="checked"' : '' }} name="collection_same_bussiness" type="radio" value="1" onclick="$('#collection_same_bussiness').hide();" />Yes
                                                <input class="switch-size" {{ (!(isset($timesetting['collection_same_bussiness']) && $timesetting['collection_same_bussiness'] == 1)) ? 'checked="checked"' : '' }} name="collection_same_bussiness" type="radio" value="0" onclick="$('#collection_same_bussiness').show();" />No
                                                </p>
                                            </div>
                                            <div class="col-sm-4 pull-right">
                                                <span>GAP</span>
                                                <input type="text" value="{{ (isset($timesetting['collection_gaptime'])) ? $timesetting['collection_gaptime'] : '' }}" name="collection_gaptime" />
                                                <span>Min</span>
                                            </div>
                                        </div>
                                        @php $key_collection = 0; @endphp
                                        <div id="collection_same_bussiness" style="display: {{ (isset($timesetting['collection_same_bussiness']) && $timesetting['collection_same_bussiness'] == 1) ? 'none' : 'block' }}" >
                                            @if(isset($collection['day']) && count($collection['day']))
                                                @foreach($collection['day'] as $keyday => $daytime)
                                                    <div id="collection_{{ $key_collection }}" class="collection col-sm-12">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="form-group col-sm-6">
                                                                <select class="selectday" name="collection[day][{{ $key_collection }}][]" class="form-control" multiple="multiple" style="width: 100% !importent;">
                                                                    @foreach($days as $key => $day)
                                                                    <option @if (in_array($key, $daytime)) {{'selected'}} @endif value="{{ $key }}">{{ $day }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="form-group">
                                                                    <select class="selectday" name="collection[from][{{ $key_collection }}]" class="form-control" style="width: 100% !importent;">
                                                                        @foreach($times as $key => $time)
                                                                        <option @if (isset($collection['from'][$keyday]) && $collection['from'][$keyday] == $key) {{'selected'}} @endif value="{{ $key }}">{{ $time }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group px-3">
                                                                    <select class="selectday" name="collection[to][{{ $key_collection }}]" class="form-control" style="width: 100% !importent;">
                                                                        @foreach($times as $key => $time){ }}
                                                                        <option @if (isset($collection['to'][$keyday]) && $collection['to'][$keyday] == $key)  {{'selected'}} @endif value="{{ $key }}">{{ $time }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="btn btn-default" onclick="$('#collection_{{ $key_collection }}').remove();">X</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php $key_collection++; @endphp
                                                @endforeach
                                            @endif
                                            <div class="col-sm-12">
                                                <span class="btn btn-primary addtime" rel="collection">+Add another set of hours</span>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">SETTING ORDER</h4>
                                        <!-- accept order out of bussines time -->
                                        <div class="col-sm-12" id="outofbusiness">
                                            <div class="col-sm-12 d-flex">
                                                <label class="control-label col-sm-8">Accept orders out of bussiness hours?</label>
                                                <p>
                                                <input class="switch-size" {{ (!(isset($timesetting['order_outof_bussiness_time']) && $timesetting['order_outof_bussiness_time'] == 0)) ? 'checked="checked"' : '' }} name="order_outof_bussiness_time" type="radio" value="1"  />Yes
                                                <input class="switch-size" {{ (isset($timesetting['order_outof_bussiness_time']) && $timesetting['order_outof_bussiness_time'] == 0) ? 'checked="checked"' : '' }} name="order_outof_bussiness_time" type="radio" value="0"  />No
                                                </p>
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


<script type="text/javascript">
    // $('.multipalselect').siblings().addClass('js-example-basic-multiple');
    $('.selectday').select2();
    $(document).ready(function(){
       var number_bussines = {{ $key_bussines }};
       var number_delivery = {{ $key_delivery }};
       var number_collection = {{ $key_collection }};

       var number = 0;
       $('.addtime').click(function(){
            var addtime = $(this);
            switch(addtime.attr('rel'))
            {
                case 'bussines': number = number_bussines;break;
                case 'delivery': number = number_delivery;break;
                case 'collection': number = number_collection;break;
            }
            $.ajax({
                // url: '{{ route("daytime") }}/&number=' + number + '&type=' + addtime.attr('rel'),
                url: '{{ route("daytime") }}',
        		type: "get",
        		dataType: 'json',
                data: {
                    'number': number,
                    'type': addtime.attr('rel'),
                    '_token': '{{ csrf_token() }}'
                },
        		success: function(response) {
                    // console.log(response.html);
                    switch(addtime.attr('rel'))
                    {
                        case 'bussines': number_bussines++;break;
                        case 'delivery': number_delivery++;break;
                        case 'collection': number_collection++;break;
                    }
                    addtime.parent().before(response.html);
        		},
            });
       });

        $('.adddates').click(function(){
       		var numItems = $('.multi-dates').length;

            numItems = ++numItems;
       		$(this).parent().before("<div class='col-md-4 py-2'><input type='date' class='multi-dates form-control' name='closing_dates["+numItems+"]' /></div>");
        })
    });




</script>
