<!--
    THIS IS HEADER Delivery_Collection_Setting PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    delivery_collection_setting.blade.php
    This for Edit Delivery_Collection_Setting
    ----------------------------------------------------------------------------------------------

-->

{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/css/jquery.tagsinput.css') }}">

{{-- Custom Css--}}
<style>

    .content_form .odd
    {
        background: #d8d8d8;
        font-size: 18px;
        font-weight: 700;
        padding: 10px;
        position: relative;
    }

    .content_form .even
    {
        background: #E6E6E6;
        font-size: 18px;
        font-weight: 700;
        padding: 10px;
        position: relative;
    }

    .content_form
    {
        border-radius: 4px;
        overflow: hidden;
    }

    .stylehieu {
        margin-top: 14px;
    }

    .deliver-by
    {
        color: #000;
        font-size: 18px!important;
        font-weight: 700!important;
    }

    span.stylehieu
    {
        display: inline-block;
        margin-bottom: 3px;
        text-transform: uppercase;
    }

    .stylehieu p.active-style
    {
        background: #f8b461;
    }

    .stylehieu p
    {
        display: inline-block;
        vertical-align: middle;
        background: #f68e59;
        color: #000;
        text-transform: uppercase;
        font-size: 14px;
        padding: 3px 10px 0;
        font-weight: 700!important;
    }

    .newtable
    {
        display: flex;
    }

    .label-td
    {
        color: #000;
        font-size: 18px!important;
        font-weight: 700!important;
        width: 250px;
    }

    .content_form tr td
    {
        line-height: 20px;
    }

    .dis_opt
    {
        padding-right: 15px;
    }

    label
    {
        cursor: pointer;
    }

    p
    {
        display: block;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
    }

    .input-td
    {
        width: 80%;
    }

    .addfeedplus
    {
        text-align: right;
        margin: 0 0 7px;
    }

    .input-td ul
    {
        padding: 0;
        clear: both;
        overflow: hidden;
        position: relative;
    }

    ul
    {
        display: block;
        list-style-type: disc;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        padding-inline-start: 40px;
    }

    .input-td ul li
    {
        float: left;
        width: 50%;
        margin: 7px 0 0!important;
    }

    .content_form ul li
    {
        list-style: none;
    }

    span.upto-span
    {
        display: inline-block;
        width: 58px;
        color: #000;
        font-size: 16px;
        padding: 4px 0 0 10px;
    }

    li
    {
        display: list-item;
        text-align: -webkit-match-parent;
    }

    .input-td ul b.remove_feed
    {
        position: absolute;
        background: red;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        cursor: pointer;
        text-align: center;
        color: #f0f8ff;
        right: 4px;
        top: 10px;
        font-size: 15px;
        line-height: 20px;
    }

    .input-td input
    {
        border: 1px solid #000!important;
        min-height: 30px!important;
        width: 100%;
        color: #000;
        padding: 0 5px 1px 13px !important;
        border-radius: 2px;
    }

    .addfeedplus b
    {
        background: green none repeat scroll 0 0;
        color: #fff;
        display: inline-block;
        padding: 4px 11px;
        text-transform: uppercase;
        font-size: 15px;
    }

    .input-td .tagsinput
    {
        width: 100%!important;
        border: 1px solid #000;
        color: #000;
    }

    .deleted-feed
    {
        text-align: right;
        margin: 9px 0;
    }

    .deleted-feed .delete_delivery
    {
        position: relative;
        right: 0;
        top: 0;
    }

    .delete_delivery
    {
        background: red none repeat scroll 0 0;
        border-radius: 0;
        color: #fff;
        cursor: pointer;
        font-size: 15px;
        font-weight: 700;
        padding: 5px 10px;
        text-decoration: none;
    }

    .distance-calculation
    {
        background: #fe0000;
        padding: 8px 30px 8px 12px;
        position: relative;
        margin: 0 0 20px;
    }

    .distance-calculation p
    {
        color: #fff;
        font-size: 21px;
        font-weight: 700;
        display: inline-block;
        vertical-align: middle;
        margin: 0;
        padding: 0 10px 0 0;
    }

    .distance-calculation input[type="text"]
    {
        border: 1px solid #000!important;
        min-height: 42px!important;
        color: #000;
        font-size: 20px!important;
        text-transform: uppercase;
        font-weight: 700;
        width: 126px;
        display: inline-block;
        vertical-align: middle;
        text-align: center;
        margin: 0 6px 0 2px;
    }

    .distance-calculation button
    {
        background: #3ab54a;
        border: 1px solid #3ab54a;
        color: #fff;
        font-weight: 700;
        font-size: 19px;
        height: 41px;
        display: inline-block;
        vertical-align: middle;
        padding: 0 20px;
    }

    .distance-calculation p.total-miles
    {
        padding-left: 30px;
    }

    .food-form-btn
    {
        width: auto;
        text-align: right!important;
        padding: 14px 0 20px;
    }

    .food_form
    {
        background: #fff none repeat scroll 0 0;
        float: right;
        font-size: 25px;
    }

    .button-food
    {
        background: none repeat scroll 0 0 #3ab54a;
        border: medium none;
        border-radius: 0;
        color: #FFF;
        display: inline-block!important;
        font-size: 15px!important;
        font-weight: 700;
        padding: 7px 33px;
        float: left;
        text-transform: uppercase;
        margin: 0 0 0 10px;
    }

</style>
{{-- End Custom Css--}}


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
                @php
                    $class = 'even';
                    $max_feed = 0;
                @endphp
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card">
                            {{-- Form --}}
                            <form method="POST" action="{{ route('manageDeliveryCollection') }}" enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2" style="color: black">
                                        <i class="fas fa-cog mr-2"></i>
                                        SETTINGS
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        @if (check_user_role(88) == 1)
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa fa-save"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary" disabled>
                                                <i class="fa fa-save"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                 {{-- Card Body --}}
                                 <div class="card-body">
                                    <div class="content_form">
                                        <div class="even">
                                            <table>
                                                <tr>
                                                    <td style="width: 200px;">
                                                        Enable Delivery/Collection
                                                    </td>
                                                    @php
                                                        $enable_delivery = isset($enable_delivery->value) ? $enable_delivery->value : 'delivery';
                                                    @endphp
                                                    <td>
                                                        <p class="stylehieu">
                                                            <input class="switch-size vertical-top" name="enable_delivery" type="radio" value="delivery" onclick="$('.delivery-sec').hide(); $('.food_form_settt, .delivery-options').show(); $('.'+$('input[name=delivery_type]').val()).show(); $('#deliveryenable').show();" id="cauhinh1" {{ ($enable_delivery == 'delivery') ? 'checked' : ''; }} />
                                                            <label for="cauhinh1">Delivery</label>

                                                            <input class="switch-size vertical-top" name="enable_delivery" type="radio" value="collection" onclick="$('#deliveryenable, .food_form_settt, .delivery-options, .delivery-sec, .distance-calculation, .mileage-sec').hide();" id="cauhinh2" {{ ($enable_delivery == 'collection') ? 'checked' : ''; }} />
                                                            <label for="cauhinh2">Collection</label>

                                                            <input class="switch-size vertical-top" name="enable_delivery" type="radio" value="both" onclick="$('.delivery-sec').hide(); $('.food_form_settt, .delivery-options').show(); $('.'+$('input[name=delivery_type]').val()).show(); $('#deliveryenable').show();" id="cauhinh3" {{ ($enable_delivery == 'both') ? 'checked' : ''; }} />
                                                            <label for="cauhinh3">Both</label>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        @php
                                            $delivery_option = isset($delivery_option->value) ? $delivery_option->value : 'post_codes';
                                        @endphp

                                        <div class="delivery-options" style="display: {{ ($enable_delivery == 'delivery' || $enable_delivery == 'both') ? 'block' : 'none'; }}">
                                            <table>
                                                <tr>
                                                    <td class="deliver-by" style="width: 200px;">
                                                        Delivery By
                                                    </td>
                                                    <td>
                                                        <span class="stylehieu">
                                                            <p class="{{ ($delivery_option == 'post_codes') ?'active-style' : ''; }}">
                                                                <input class="switch-size" name="delivery_option" type="radio" value="post_codes" onclick="$('#deliveryenable, .food_form_settt').show();$('#area_option').hide();$('#distance_option').hide();$('input[name=delivery_type]').val('post_codes'); $('p').removeClass('active-style'); $(this).parent('p').addClass('active-style');$('.distance-calculation, .mileage-sec').hide();" id="deliveryby1" {{ ($delivery_option == 'post_codes') ? 'checked' : ''; }} />
                                                                <label for="deliveryby1">Post Code Sectors</label>
                                                            </p>
                                                            <p class="{{ ($delivery_option == 'distance') ?'active-style' : ''; }}">
                                                                <input class="switch-size" name="delivery_option" type="radio" value="distance" onclick="$('#distance_option').show(); $('#deliveryenable').hide();$('#area_option').hide();$('input[name=delivery_type]').val('distance'); $('p').removeClass('active-style'); $(this).parent('p').addClass('active-style'); $('.distance-calculation, .mileage-sec').show();" id="deliveryby2" {{ ($delivery_option == 'distance') ? 'checked' : ''; }} />
                                                                <label for="deliveryby2">Distance</label>
                                                            </p>
                                                            <p class="{{ ($delivery_option == 'area') ?'active-style' : ''; }}">
                                                                <input class="switch-size" name="delivery_option" type="radio" value="area" onclick="$('#area_option').show();$('#distance_option').hide(); $('#deliveryenable').hide();$('input[name=delivery_type]').val('area'); $('p').removeClass('active-style'); $(this).parent('p').addClass('active-style'); $('.distance-calculation, .mileage-sec').hide();" id="deliveryby3" {{ ($delivery_option == 'area') ? 'checked' : ''; }} />
                                                                <label for="deliveryby3">Area Names</label>
                                                            </p>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="mileage-sec" style="display: {{ ( ($enable_delivery == 'delivery' && $delivery_option == 'distance') || ($enable_delivery == 'both' && $delivery_option == 'distance') )  ? 'block' : 'none' }};">
                                            <table class="newtable">
                                                <tr>
                                                    <td class="label-td width100">Distance Options</td>
                                                    <td style="padding-left: 10px;">
                                                        <table style="width: auto;" cellpadding="0" cellspacing="0" border="0">
                                                            <tr>
                                                                <td class="dis_opt">
                                                                    <p class="distance-opt-tab">
                                                                        @php
                                                                            $is_distance_option = isset($is_distance_option->value) ? $is_distance_option->value : '1';
                                                                        @endphp
                                                                        <input id="deliveryby12" class="distance-opt vertical-top active" name="is_distance_option" type="radio" value ="1" {{ ($is_distance_option == 1) ? 'checked' : '' }} onclick="$('.google-dis_api').hide(); $('.percentage-mileage').show();">
                                                                        <label for="deliveryby12">
                                                                            Local PostCode Distance
                                                                        </label>
                                                                    </p>
                                                                </td>
                                                                <td class="dis_opt">
                                                                    <p class="distance-opt-tab active-style">
                                                                        <input id="deliveryby32" class="distance-opt vertical-top" name="is_distance_option" type="radio" value ="2" {{ ($is_distance_option == 2) ? 'checked' : '' }} onclick="$('.google-dis_api').show(); $('.percentage-mileage').hide();">
                                                                        <label for="deliveryby32">
                                                                            Google API Distance
                                                                        </label>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                                @php
                                                    $displyoptions = $displyoptions1 = '';
                                                    if($is_distance_option == 1)
                                                    {
                                                        $displyoptions = 'style=display:block';
                                                        $displyoptions1 = 'style=display:none';
                                                    }
                                                    else
                                                    {
                                                        $displyoptions1 = 'style=display:block';
                                                        $displyoptions = 'style=display:none';
                                                    }
                                                @endphp

                                                @php
                                                    $road_mileage_percentage = isset($road_mileage_percentage->value) ? $road_mileage_percentage->value : '';
                                                @endphp

                                                <tr class="percentage-mileage" {{ $displyoptions }}>
                                                    <td class="label-td width100">Percentage value for road mileage<br/> (22% is Recommended)</td>
                                                    <td class="input-td widthhalf" style="padding-left: 73px; white-space: nowrap;">
                                                        <input type="number" name="road_mileage_percentage" style="width:100%;" value="{{ $road_mileage_percentage }}" />
                                                        <span style="color:#000;">%</span>
                                                    </td>
                                                </tr>

                                                <tr class="google-dis_api" {{ $displyoptions1 }}>
                                                    <td class="label-td width100">Google Distance Api Key</td>
                                                    <td style="padding-left: 10px;">
                                                        <table style="width: auto;" cellpadding="0" cellspacing="0" border="0">
                                                            <tr>
                                                                <td class="dis_opt input-td">
                                                                    <input style="width: 400px;" type="text" name="google_distance_api_key"  value="{{ (isset($google_distance_api_key->value)) ? $google_distance_api_key->value : '' }}" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div id="deliveryenable" class="post_codes delivery-sec" style="display: {{ ( ($enable_delivery == 'delivery' && $delivery_option == 'post_codes') || ($enable_delivery == 'both' && $delivery_option == 'post_codes') ) ? 'block' : 'none'; }}">
                                            @if(isset($deliverysettings))
                                                @php
                                                    $max_feed = 0;
                                                @endphp

                                                @foreach ($deliverysettings as $delivery_setting)
                                                    @php
                                                        $class = ($class == 'even') ? 'odd' : 'even';
                                                    @endphp
                                                    <div id="item_{{ $delivery_setting->id_delivery_settings }}" class="{{ $class }}">
                                                        <input type="hidden" name="delivery_type_{{ $delivery_setting->id_delivery_settings }}" value="post_codes" />
                                                        <table>
                                                            <tr>
                                                                <td class="label-td">Group Name</td>
                                                                <td class="input-td">
                                                                    <input type="text" class="form-control" name="name_{{ $delivery_setting->id_delivery_settings }}" value="{{ $delivery_setting->name }}" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td">Minimum Spend </td>
                                                                <td class="input-td">
                                                                    <input type="text" class="form-control" name="min_spend_{{ $delivery_setting->id_delivery_settings }}" value="{{ $delivery_setting->min_spend }}" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td">Delivery Fees </td>
                                                                <td class="input-td">
                                                                    <div class="add-more-feed">
                                                                        @php
                                                                            $flag = false;
                                                                        @endphp

                                                                        @if (count($delivery_setting->hasManyDeliveryFeeds) > 0)
                                                                            @foreach ($delivery_setting->hasManyDeliveryFeeds as $feed)

                                                                                @if ($max_feed < $feed->id_delivery_feeds)
                                                                                    @php
                                                                                        $max_feed = $feed->id_delivery_feeds;
                                                                                    @endphp
                                                                                @endif

                                                                                <ul id="feed_{{ $delivery_setting->id_delivery_settings }}" class="id_delivery_feeds_{{ $feed->id_delivery_feeds }}">
                                                                                    <li>
                                                                                        <input type="text" name="price_shipping_{{ $delivery_setting->id_delivery_settings }}[]" value="{{ $feed->price_shipping }}" style="width: 100%" />
                                                                                    </li>
                                                                                    <li>
                                                                                        <span class="upto-span">
                                                                                            Up To :
                                                                                        </span>
                                                                                        <input type="text" name="price_upto_{{ $delivery_setting->id_delivery_settings }}[]" style="width: 75%" value="{{ $feed->price_upto }}" />

                                                                                        @if ($flag)
                                                                                            <b class="remove_feed" onclick="remove_feed({{ $feed->id_delivery_feeds }})">X</b>
                                                                                        @endif

                                                                                        @php
                                                                                             $flag = true;
                                                                                        @endphp
                                                                                    </li>
                                                                                </ul>
                                                                            @endforeach
                                                                        @else
                                                                            <ul id="feed_{{$delivery_setting->id_delivery_settings }}">
                                                                                <li>
                                                                                    <input type="text" name="price_shipping_{{ $delivery_setting->id_delivery_settings }}[]" value="" style="width: 100%" />
                                                                                </li>
                                                                                <li>
                                                                                    <span class="upto-span">
                                                                                        Up To :
                                                                                    </span>
                                                                                    <input type="text" name="price_upto_{{ $delivery_setting->id_delivery_settings }}[]" style="width: 75%" value="" />
                                                                                </li>
                                                                            </ul>
                                                                        @endif
                                                                    </div>
                                                                    <div class="addfeedplus"><b style="cursor: pointer" class="add_feeds" onclick="add_more({{ $delivery_setting->id_delivery_settings }});"><i class="fa fa-plus"></i> Add Fee</b>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td">Post Codes </td>
                                                                <td class="input-td">
                                                                    <input class="inputtag" name="post_codes_{{ $delivery_setting->id_delivery_settings }}" value="{{ $delivery_setting->post_codes }}" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="deleted-feed">
                                                            <b onclick="delete_delivery({{ $delivery_setting->id_delivery_settings }});" class="delete_delivery"><i class="fa fa-trash"></i> DELETE</b>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <div id="distance_option" class="distance mt-3 delivery-sec" style="display: {{ ( ($enable_delivery == 'delivery' && $delivery_option == 'distance') || ( $enable_delivery == 'both' && $delivery_option == 'distance') ) ? 'block' : 'none'; }}">
                                            @if (isset($deliverydistance))
                                                @php
                                                    $max_feed = 0;
                                                @endphp

                                                @foreach ($deliverydistance as $delivery_distance)
                                                    @php
                                                        $class = ($class == 'even')  ? 'odd' : 'even';
                                                    @endphp

                                                    <div id="item_{{ $delivery_distance->id_delivery_settings }}" class="{{ $class }}">
                                                        <input type="hidden" name="delivery_type_{{ $delivery_distance->id_delivery_settings }}" value="distance" />
                                                        <table>
                                                            <tr>
                                                                <td class="label-td">Group Name </td>
															    <td class="input-td">
                                                                    <input type="text" name="name_{{ $delivery_distance->id_delivery_settings }}" value="{{ $delivery_distance->name }}"/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td">Minimum Spend </td>
                                                                <td class="input-td"><input type="text" name="min_spend_{{ $delivery_distance->id_delivery_settings }}" value="{{ $delivery_distance->min_spend }}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td">Delivery Fees </td>
                                                                <td class="input-td">
                                                                    <div class="add-more-feed">
                                                                        @php
                                                                            $flag = false;
                                                                        @endphp

                                                                        @if (count($delivery_distance->hasManyDeliveryFeeds) > 0)
                                                                            @foreach ($delivery_distance->hasManyDeliveryFeeds as $feed)

                                                                                @if ($max_feed < $feed->id_delivery_feeds)
                                                                                    @php
                                                                                        $max_feed = $feed->id_delivery_feeds;
                                                                                    @endphp
                                                                                @endif

                                                                                <ul id="feed_{{ $delivery_distance->id_delivery_settings }}" class="id_delivery_feeds_{{ $feed->id_delivery_feeds }}">
                                                                                    <li>
                                                                                        <input type="text" name="price_shipping_{{ $delivery_distance->id_delivery_settings }}[]" value="{{ $feed->price_shipping }}" style="width: 100%" />
                                                                                    </li>
                                                                                    <li>
                                                                                        <span class="upto-span">
                                                                                            Up To :
                                                                                        </span>
                                                                                        <input type="text" name="price_upto_{{ $delivery_distance->id_delivery_settings }}[]" style="width: 75%" value="{{ $feed->price_upto }}" />

                                                                                        @if ($flag)
                                                                                            <b class="remove_feed" onclick="remove_feed({{ $feed->id_delivery_feeds }})">X</b>
                                                                                        @endif

                                                                                        @php
                                                                                             $flag = true;
                                                                                        @endphp
                                                                                    </li>
                                                                                </ul>
                                                                            @endforeach
                                                                        @else
                                                                            <ul id="feed_{{$delivery_distance->id_delivery_settings }}">
                                                                                <li>
                                                                                    <input type="text" name="price_shipping_{{ $delivery_distance->id_delivery_settings }}[]" value="" style="width: 100%" />
                                                                                </li>
                                                                                <li>
                                                                                    <span class="upto-span">
                                                                                        Up To :
                                                                                    </span>
                                                                                    <input type="text" name="price_upto_{{ $delivery_distance->id_delivery_settings }}[]" style="width: 75%" value="" />
                                                                                </li>
                                                                            </ul>
                                                                        @endif
                                                                    </div>
                                                                    <div class="addfeedplus"><b style="cursor: pointer" class="add_feeds" onclick="add_more({{ $delivery_distance->id_delivery_settings }});"><i class="fa fa-plus"></i> Add Fee</b>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td">Distance (Miles) </td>
                                                                <td class="input-td">
                                                                    <input name="post_codes_{{ $delivery_distance->id_delivery_settings }}" value="{{ $delivery_distance->distance }}"/>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="deleted-feed">
                                                            <b onclick="delete_delivery({{ $delivery_distance->id_delivery_settings }});" class="delete_delivery"><i class="fa fa-trash"></i> DELETE</b>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <div id="area_option" class="area delivery-sec" style="display: {{ ( ($enable_delivery == 'delivery' && $delivery_option == 'area') || ($enable_delivery == 'both' && $delivery_option == 'area') ) ? 'block' : 'none'; }}">
                                            @if (isset($deliveryareas))
                                                @php
                                                    $max_feed = 0;
                                                @endphp

                                                @foreach ($deliveryareas as $delivery_area)
                                                    @php
                                                        $class = ($class == 'even') ? 'odd' : 'even';
                                                    @endphp

                                                    <div id="item_{{ $delivery_area->id_delivery_settings }}" class="<?php echo $class ?>">
                                                        <input type="hidden" name="delivery_type_{{ $delivery_area->id_delivery_settings }}" value="area" />
                                                        <table>
                                                            <tr>
                                                                <td class="label-td">Group Name </td>
																<td class="input-td">
                                                                    <input type="text" name="name_{{ $delivery_area->id_delivery_settings }}" value="{{ $delivery_area->name }}" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td">Minimum Spend </td>
                                                                <td class="input-td"><input type="text" name="min_spend_{{ $delivery_area->id_delivery_settings }}" value="{{ $delivery_area->min_spend }}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td">Delivery Fees </td>
                                                                <td class="input-td">
                                                                    <div class="add-more-feed">
                                                                        @php
                                                                            $flag = false;
                                                                        @endphp

                                                                        @if (count($delivery_area->hasManyDeliveryFeeds) > 0)
                                                                            @foreach ($delivery_area->hasManyDeliveryFeeds as $feed)

                                                                                @if ($max_feed < $feed->id_delivery_feeds)
                                                                                    @php
                                                                                        $max_feed = $feed->id_delivery_feeds;
                                                                                    @endphp
                                                                                @endif

                                                                                <ul id="feed_{{ $delivery_area->id_delivery_settings }}" class="id_delivery_feeds_{{ $feed->id_delivery_feeds }}">
                                                                                    <li>
                                                                                        <input type="text" name="price_shipping_{{ $delivery_area->id_delivery_settings }}[]" value="{{ $feed->price_shipping }}" style="width: 100%" />
                                                                                    </li>
                                                                                    <li>
                                                                                        <span class="upto-span">
                                                                                            Up To :
                                                                                        </span>
                                                                                        <input type="text" name="price_upto_{{ $delivery_area->id_delivery_settings }}[]" style="width: 75%" value="{{ $feed->price_upto }}" />

                                                                                        @if ($flag)
                                                                                            <b class="remove_feed" onclick="remove_feed({{ $feed->id_delivery_feeds }})">X</b>
                                                                                        @endif

                                                                                        @php
                                                                                             $flag = true;
                                                                                        @endphp
                                                                                    </li>
                                                                                </ul>
                                                                            @endforeach
                                                                        @else
                                                                            <ul id="feed_{{$delivery_area->id_delivery_settings }}">
                                                                                <li>
                                                                                    <input type="text" name="price_shipping_{{ $delivery_area->id_delivery_settings }}[]" value="" style="width: 100%" />
                                                                                </li>
                                                                                <li>
                                                                                    <span class="upto-span">
                                                                                        Up To :
                                                                                    </span>
                                                                                    <input type="text" name="price_upto_{{ $delivery_area->id_delivery_settings }}[]" style="width: 75%" value="" />
                                                                                </li>
                                                                            </ul>
                                                                        @endif
                                                                    </div>
                                                                    <div class="addfeedplus"><b style="cursor: pointer" class="add_feeds" onclick="add_more({{ $delivery_area->id_delivery_settings }});"><i class="fa fa-plus"></i> Add Fee</b>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
																<td class="label-td">Areas </td>
																<td class="input-td">
																	<input class="inputtag" name="post_codes_{{ $delivery_area->id_delivery_settings }}" value="{{ $delivery_area->area }}" />
                                                                </td>
															</tr>
                                                        </table>
                                                        <div class="deleted-feed">
                                                            <b onclick="delete_delivery({{ $delivery_area->id_delivery_settings }});" class="delete_delivery"><i class="fa fa-trash"></i> DELETE</b>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>

                                    <div class="distance-calculation" style="display: {{ ($delivery_option == 'distance') ? 'inline-block' : 'none'; }}">
                                        <p>Test Distance</p>
                                        <input type="text" name="distance_postcode">
                                        <button type="button" class="calculate-distance" ref="{{ route('calculateDistance') }}">CALCULATE</button>
                                        <p class="total-miles"></p>
                                    </div>

                                    <div class="food_form food_form_settt food-form-btn" style="display: {{ ($enable_delivery == 'collection') ? 'none' : 'block'; }}">
                                        <b class="button-food" id="add_group" ref="" style="cursor: pointer"><i class="fa fa-plus"></i> Add group</b>
                                        <input type="hidden" id="action_delete" value="{{ route('deleteGroup') }}" />
                                        <input type="hidden" name="delivery_type" value="<?= $delivery_option; ?>" />
                                        <input class="button-food" type="submit" value=" Save" />
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


{{-- SCRIPT --}}
<script src="{{ asset('public/dist/js/jquery.tagsinput.js') }}"></script>
<script type="text/javascript">
$(document).ready(function()
{
    // Add more Group
    $('#add_group').click(function()
    {
        $.ajax({
            url: '{{ url("addGroup") }}',
            type: 'POST',
            data: {'delivery_type':$('input[name=delivery_type]').val()},
            dataType: 'json',
            beforeSend: function() {
                $('.food_form').before('<span class="wait">&nbsp;<img src="public/admin/gif/gif3.gif" width="60" /></span>');
            },
            complete: function() {
                $('.wait').remove();
            },
            success: function(response)
            {
                if(response.max_id)
                {
                    add_group(parseInt(response.max_id));
                }
            }
        });
    });
});

    $('.inputtag').tagsInput({width:'600px', defaultText: 'add'});

	var max_feed = {{ $max_feed }} + 1;
    var class_even = '{{ $class }}';

    // Add More Delivery Feeds
    function add_more(id_delivery_settings)
    {
        $('#feed_'+id_delivery_settings).after('<ul id="feed_'+id_delivery_settings+'" class="id_delivery_feeds_'+max_feed+'"><li><input type="text" value="" name="price_shipping_'+id_delivery_settings+'[]" style="width:100%;"/></li><li><span class="upto-span">Up To:</span> <input type="text" value="" name="price_upto_'+id_delivery_settings+'[]" style="width:75%;"></li><b onclick="remove_feed('+max_feed+')" class="remove_feed"> X</b></li></ul>');
        max_feed++;
        return false;
    }

    // Remove Delivery Feeds
    function remove_feed(id_feed)
    {
        $('.id_delivery_feeds_'+id_feed).remove();
        return false;
    }

    // Add Group
    function add_group(max_id){
        if(class_even == 'odd'){
            class_even = 'even';
        } else{
            class_even = 'odd';
        }
        if($('input[name="delivery_type"]').val()=='post_codes'){
            var html = '';
            html += '<div id="item_'+max_id+'" class="'+class_even+'">';
            html += '<input type="hidden" name="delivery_type_'+max_id+'" value="'+$('input[name="delivery_type"]').val()+'"/>';
            html += '<table>';
            html += '<tbody><tr>';
            html += '<td class="label-td">Group Name: </td>';
            html += '<td class="input-td"><input type="text" value="" name="name_'+max_id+'"></td>';
            html += '</tr>';
            html += '<tr>';
            html += '<td class="label-td">Minimum Spend: </td>';
            html += '<td class="input-td"><input type="text" value="" name="min_spend_'+max_id+'"></td>';
            html += '</tr>';
            html += ' <tr>';
            html += '<td class="label-td">Delivery Feeds: </td>';
            html += '<td class="input-td">';
            html += '<ul id="feed_'+max_id+'">';
            html += '<li id="id_delivery_feeds_'+max_feed+'"><input type="text" name="price_shipping_'+max_id+'[]" value=""></li><li> <span class="upto-span">Up To:</span> <input type="text" name="price_upto_'+max_id+'[]" value=""></li>'
            html += '</ul>';
            html += '<div class="addfeedplus"><b onclick="add_more('+max_id+');" class="add_feeds" href="">+Add Fee</b></div>';
            html += '</td>';
            html += '</tr>';
            html += '<tr>';
            html += '<td class="label-td">Post Codes: </td>';
            html += '<td class="input-td"><input type="text" class="inputtag" name="post_codes_'+max_id+'" /></td>';
            html += '</tr>';
            html += '</tbody></table>';
            html += '<div class="deleted-feed"><b class="delete_delivery" onclick="delete_delivery('+max_id+');">DELETE</b></div>';
            html += '</div>';
            max_feed++;
        }else if($('input[name="delivery_type"]').val()=='distance'){
            var html = '';
            html += '<div id="item_'+max_id+'" class="'+class_even+'">';
            html += '<input type="hidden" name="delivery_type_'+max_id+'" value="'+$('input[name="delivery_type"]').val()+'"/>';
            html += '<table>';
            html += '<tbody><tr>';
            html += '<td class="label-td">Group Name: </td>';
            html += '<td class="input-td"><input type="text" value="" name="name_'+max_id+'"></td>';
            html += '</tr>';
            html += '<tr>';
            html += '<td class="label-td">Minimum Spend: </td>';
            html += '<td class="input-td"><input type="text" value="" name="min_spend_'+max_id+'"></td>';
            html += '</tr>';
            html += ' <tr>';
            html += '<td class="label-td">Delivery Feeds: </td>';
            html += '<td class="input-td">';
            html += '<ul id="feed_'+max_id+'">';
            html += '<li id="id_delivery_feeds_'+max_feed+'"><input type="text" name="price_shipping_'+max_id+'[]" value=""> </li><li><span class="upto-span">Up To:</span> <input type="text" name="price_upto_'+max_id+'[]" value=""></li>'
            html += '</ul>';
            html += '<div class="addfeedplus"><b onclick="add_more('+max_id+');" class="add_feeds" href="">+Add Fee</b></div>';
            html += '</td>';
            html += '</tr>';
            html += '<tr>';
            html += '<td class="label-td">Distance (Miles): </td>';
            html += '<td class="input-td"><input type="text" name="post_codes_'+max_id+'" /></td>';
            html += '</tr>';
            html += '<tr>';

            html += '</tbody></table>';
            html += '<div class="deleted-feed"><b class="delete_delivery" onclick="delete_delivery('+max_id+');">DELETE</b></div>';
            html += '</div>';
            max_feed++;
        }else{
            var html = '';
            html += '<div id="item_'+max_id+'" class="'+class_even+'">';
            html += '<input type="hidden" name="delivery_type_'+max_id+'" value="'+$('input[name="delivery_type"]').val()+'"/>';
            html += '<table>';
            html += '<tbody><tr>';
            html += '<td class="label-td">Group Name: </td>';
            html += '<td class="input-td"><input type="text" value="" name="name_'+max_id+'"></td>';
            html += '</tr>';
            html += '<tr>';
            html += '<td class="label-td">Minimum Spend: </td>';
            html += '<td class="input-td"><input type="text" value="" name="min_spend_'+max_id+'"></td>';
            html += '</tr>';
            html += ' <tr>';
            html += '<td class="label-td">Delivery Feeds: </td>';
            html += '<td class="input-td">';
            html += '<ul id="feed_'+max_id+'">';
            html += '<li id="id_delivery_feeds_'+max_feed+'"><input type="text" name="price_shipping_'+max_id+'[]" value=""> </li><li><span class="upto-span">Up To:</span><input type="text" name="price_upto_'+max_id+'[]" value=""></li>'
            html += '</ul>';
            html += '<div class="addfeedplus"><b onclick="add_more('+max_id+');" class="add_feeds" href="">+Add Fee</b></div>';
            html += '</td>';
            html += '</tr>';
            html += '<tr>';
            html += '<td class="label-td">Areas: </td>';
            html += '<td class="input-td"><input type="text" class="inputtag" name="post_codes_'+max_id+'" /></td>';
            html += '</tr>';
            html += '</tbody></table>';
            html += '<div class="deleted-feed"><b class="delete_delivery" onclick="delete_delivery('+max_id+');">DELETE</b></div>';
            html += '</div>';
            max_feed++;
        }
        $('.content_form').find('.'+$('input[name="delivery_type"]').val()).append(html);
        $('.inputtag').tagsInput({width:'600px', defaultText: 'add'});
    }

    // Delete Delivery
    function delete_delivery(id_delivery_settings)
    {
        var r = confirm("Do you want delete delivery setting");
        if (r == true) {
            $.ajax({
                url: $('#action_delete').val(),
                type: 'post',
                data: '&id_delivery_settings='+id_delivery_settings,
                dataType: 'json',
                success: function(response)
                {
                    location.reload();
                }
            });
        }
    }

    // Get Calculate Distance
    $('.calculate-distance').click(function()
    {
        $.ajax({
            url: $(this).attr('ref'),
            type: 'post',
            data: {'distance_postcode':$('input[name=distance_postcode]').val()},
            dataType: 'json',
            beforeSend: function() {
                $('.error').remove();
                $('.distance-calculation').after('<span class="wait">&nbsp;<img src="public/admin/gif/gif3.gif" width="60" /></span>');
            },
            complete: function() {
                $('.wait').remove();
            },
            success: function(response)
            {
                if(response.json.error)
                {
                    $('.total-miles').html('');
                    $('.distance-calculation').after('<span class="error text-danger">'+response.json.error+'</span>');
                }
                else
                {
                    $('.total-miles').html(response.json.success);
                }
            }
        });
    });


</script>
{{-- END SCRIPT --}}
