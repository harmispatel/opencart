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
                                    <div class="col-sm-12" id="bussinestime">
                                        <h2>Bussiness Hours</h2>
                                        @php $key_bussines = 0; @endphp
                                            @if(isset($timesetting['bussines']['day']) && count($timesetting['bussines']['day']))
                                                @foreach($timesetting['bussines']['day'] as $keyday => $daytime)
                                                <div id="bussines_{{ $key_bussines; }}" class="bussines col-sm-12">
                                                    <div class="form-group col-sm-6">
                                                        <select class="selectday" name="bussines[day][{{ $key_bussines }}][]" class="form-control" multiple="multiple">
                                                            @foreach($days as $key => $day)
                                                                <option @if(in_array($key, $daytime)) {{'selected'}} @endif value="{{ $key }}">{{ $day }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <select class="selectday" name="bussines[from][{{ $key_bussines; }}]" class="form-control">
                                                            @foreach($times as $key => $time)
                                                                <option @if (isset($timesetting['bussines']['from'][$keyday]) && $timesetting['bussines']['from'][$keyday] == $key)  {{'selected'}} @endif value="{{ $key; }}">{{ $time; }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <select class="selectday" name="bussines[to][{{ $key_bussines; }}]" class="form-control">
                                                            @foreach($times as $key => $time)
                                                            <option @if (isset($timesetting['bussines']['to'][$keyday]) && $timesetting['bussines']['to'][$keyday] == $key) {{'selected' }}  @endif value="{{ $key; }}">{{ $time; }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <span class="btn btn-default" onclick="$('#bussines_<?= $key_bussines; ?>').remove();">X</span>
                                                    </div>
                                                </div>
                                                {{$key_bussines++;}}
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
                                                @if(isset($close_date['closing_dates']) && !empty(array_filter($close_date['closing_dates'])))
                                                    @foreach (array_filter($close_date['closing_dates']) as $key => $value )
                                                        @php
                                                            echo '<pre>';
                                                            print_r($value);
                                                        @endphp
                                                        <input type="date" name="closing_dates[{{$key}}]" class="multi-dates form-control col-md-3 d-inline" value="{{$value}}">
                                                    @endforeach
                                                @else
                                                    <input type="date" name="closing_dates[0]" class="multi-dates form-control col-md-3 d-inline" value="">
                                                @endif 

                                            
                                            <div class="col-sm-12 py-3"> 
                                                <span class="btn btn-primary adddates" rel="closingdates">+Add another closing date</span>
                                            </div>
                                        </div>

                                        
                                        <div class="col-sm-12" id="deliverytime">
                                        <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">DELIVERY HOURS</h4>
                                        <div class="col-sm-12 d-flex">
                                            <div class="col-sm-8 d-flex">
                                                <label class="control-label col-sm-4">Same as bussiness hours</label>
                                                <p>
                                                  <input class="switch-size" {{ (isset($open_close['delivery_same_bussiness']) && $open_close['delivery_same_bussiness'] == 1) ? 'checked="checked"' : ''; }} name="delivery_same_bussiness" type="radio" value="1" onclick="$('#delivery_same_bussiness').hide();" />Yes
                                                  <input class="switch-size" {{ (!(isset($open_close['delivery_same_bussiness']) && $open_close['delivery_same_bussiness'] == 1)) ? 'checked="checked"' : ''; }} name="delivery_same_bussiness" type="radio" value="0" onclick="$('#delivery_same_bussiness').show();" />No
                                                </p>
                                            </div>
                                            <div class="col-sm-4">
                                                <span>GAP</span>
                                                {{-- value="{{ $open_close['delivery_gaptime'] ? $open_close['delivery_gaptime'] : ""  }}" --}}
                                                <input type="text" value="{{ (isset($open_close['delivery_gaptime'])) ? $open_close['delivery_gaptime'] : ''; }}" name="delivery_gaptime" />
                                                <span>Min</span>
                                            </div>
                                        </div>
                                        @php $key_delivery = 0; @endphp
                                        <div id="delivery_same_bussiness" style="display: {{ (isset($open_close['delivery_same_bussiness']) && $open_close['delivery_same_bussiness'] == 1) ? 'none' : 'block'; }}" >
                                        @if(isset($timesetting['delivery']['day']) && count($timesetting['delivery']['day']))
                                                @foreach($timesetting['delivery']['day'] as $keyday => $daytime)
                                                <div id="delivery_{{ $key_delivery }}" class="delivery col-sm-12">
                                                    <div class="form-group col-sm-6">
                                                        <select class="selectday" name="delivery[day][{{ $key_delivery}}][]" class="form-control" multiple="multiple">
                                                            @foreach($days as $key => $day)
                                                            <option @if (in_array($key, $daytime)) {{'selected'}} @endif value="{{ $key}}">< {{$day}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <select class="selectday" name="delivery[from][ {{$key_delivery}}]" class="form-control">
                                                            @foreach($times as $key => $time)
                                                                <option @if (isset($timesetting['delivery']['from'][$keyday]) && $timesetting['delivery']['from'][$keyday] == $key)  {{'selected'}} @endif value="{{$key}}"> {{$time}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <select class="selectday" name="delivery[to][<?= $key_delivery; ?>]" class="form-control">
                                                            @foreach($times as $key => $time)
                                                                <option @if (isset($timesetting['delivery']['to'][$keyday]) && $timesetting['delivery']['to'][$keyday] == $key)  {{'selected'}} @endif value=" {{$key}}>">{{$time}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <span class="btn btn-default" onclick="$('#delivery_{{$key_delivery}};').remove();">X</span>
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
                                            <input class="switch-size" {{ (isset($open_close['collection_same_bussiness']) && $open_close['collection_same_bussiness'] == 1) ? 'checked="checked"' : ''; }} name="collection_same_bussiness" type="radio" value="1" onclick="$('#collection_same_bussiness').hide();" />Yes
                                            <input class="switch-size" {{ (!(isset($open_close['collection_same_bussiness']) && $open_close['collection_same_bussiness'] == 1)) ? 'checked="checked"' : ''; }} name="collection_same_bussiness" type="radio" value="0" onclick="$('#collection_same_bussiness').show();" />No
                                            </p>
                                        </div>
                                        <div class="col-sm-4 pull-right">
                                            <span>GAP</span>
                                            <input type="text" value="{{ (isset($open_close['collection_gaptime'])) ? $open_close['collection_gaptime'] : ''; }}" name="collection_gaptime" />
                                            <span>Min</span>
                                        </div>
                                    </div>
                                    @php $key_collection = 0; @endphp
                                    <div id="collection_same_bussiness" style="display: {{ (isset($open_close['collection_same_bussiness']) && $open_close['collection_same_bussiness'] == 1) ? 'none' : 'block'; }}" >
                                    @if(isset($timesetting['collection']['day']) && count($timesetting['collection']['day']))
                                            @foreach($timesetting['collection']['day'] as $keyday => $daytime)
                                            <div id="collection_{{ $key_collection; }}" class="collection col-sm-12">
                                                <div class="form-group col-sm-6">
                                                    <select class="selectday" name="collection[day][{{ $key_collection; }}][]" class="form-control" multiple="multiple">
                                                        @foreach($days as $key => $day)
                                                        <option @if (in_array($key, $daytime)) {{'selected'}} @endif value="{{ $key; }}">{{ $day }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <select class="selectday" name="collection[from][{{ $key_collection; }}]" class="form-control">
                                                        @foreach($times as $key => $time)
                                                        <option @if (isset($timesetting['collection']['from'][$keyday]) && $timesetting['collection']['from'][$keyday] == $key) {{'selected'}} @endif value="{{ $key }}">{{ $time }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <select class="selectday" name="collection[to][{{ $key_collection; }}]" class="form-control">
                                                        @foreach($times as $key => $time){ }}
                                                        <option @if (isset($timesetting['collection']['to'][$keyday]) && $timesetting['collection']['to'][$keyday] == $key)  {{'selected'}} @endif value="{{ $key }}">{{ $time }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <span class="btn btn-default" onclick="$('#collection_{{ $key_collection; }}').remove();">X</span>
                                                </div>
                                            </div>
                                            @php $key_collection++; @endphp
                                        @endforeach
                                    @endif
                                        <div class="col-sm-12">
                                            <span class="btn btn-primary addtime" rel="collection">+Add another set of hours</span>
                                        </div>
                                </div>
                                    <h4 class="text-success pt-3" style="border-bottom: 1px dotted black">SETTING ORDER</h4>
                                    <div class="form-group row align-items-center">
                                        <label for="inputPassword" class="col-sm-8 col-form-label">Accept orders out of bussiness hours?</label>
                                        <div class="col-sm-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="acceptorder" id="acceptedyes" value="1" {{ ($open_close['order_outof_bussiness_time'] == 1) ? $open_close['order_outof_bussiness_time'] : "checked" }}>
                                                <label class="form-check-label" for="acceptedyes">Yes</label>
                                              </div>
                                              <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="acceptorder" id="acceptedno" value="0"  {{ ($open_close['order_outof_bussiness_time'] == 0) ? $open_close['order_outof_bussiness_time'] : "checked" }}>
                                                <label class="form-check-label" for="acceptedno">No</label>
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


<script type="text/javascript">
    // $('.multipalselect').siblings().addClass('js-example-basic-multiple');
    $('.selectday').select2();
    $(document).ready(function(){
       var number_bussines = {{ $key_bussines; }};
       var number_delivery = {{ $key_delivery; }};
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
       		$(this).parent().before("<input type='date' class='multi-dates form-control col-md-3 py-3 d-inline' name='closing_dates["+numItems+"]' />");
        })
    });




</script>
