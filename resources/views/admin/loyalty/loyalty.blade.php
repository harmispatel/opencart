@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Loyalty --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Loyalty</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Loyalty </li>
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
                        <div class="card card-body ">
                            <form action="{{ route('storeloyalty') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <h1>Loyalty System</h1>
                                <hr>
                                @php
                                    $current_store = currentStoreId();
                                    $rewardtype = getLoyaltyDetails($current_store, 'rewardtype');
                                    //  echo '<pre>';
                                    //  print_r($rewardtype['unserializemoney']['minimum']);
                                    //  exit();
                                    // $point = getLoyaltyDetails($current_store, 0, $rewardtype);
                                    // echo '<pre>';
                                    // print_r($point);
                                   
                                    // $money = getLoyaltyDetails($current_store, 0, $rewardtype);
                                    // echo '<pre>';
                                    // print_r($money);
                                    
                                @endphp
                                <div class="rewardtype">
                                    <div class="radio">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="radio" name="rewardtype" value="point"
                                                        {{ $rewardtype['value'] == 'point' ? 'checked' : '' }}>
                                                    <span>Point Rewards</span>
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="radio" name="rewardtype" value="money"
                                                        {{ $rewardtype['value'] == 'money' ? 'checked' : '' }}>
                                                    <span>Money Rewards</span>
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="radio" name="rewardtype" value="offer" disabled>
                                                    <span>Offer Rewards</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div id="configmoneyrewards" class="configdiv">
                                    <div class="form-group">
                                        <label>Minimum spend</label>
                                        <input type="text"
                                            value="{{ isset($rewardtype['unserializemoney']['minimum']) ? $rewardtype['unserializemoney']['minimum'] : '' }}"
                                            class="form-control" style="max-width: 250px" name="money[minimum]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Collection &nbsp; Award %</label>
                                        <input type="text"
                                            value="{{ isset($rewardtype['unserializemoney']['collectionaward']) ? $rewardtype['unserializemoney']['collectionaward'] : '' }}"
                                            class="form-control" style="max-width: 250px"
                                            name="money[collectionaward]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Delivery &nbsp;&nbsp;&nbsp;&nbsp; Award %</label>
                                        <input type="text"
                                            value="{{ isset($rewardtype['unserializemoney']['deliveryaward']) ? $rewardtype['unserializemoney']['deliveryaward'] : '' }}"
                                            style="max-width: 250px" class="form-control"
                                            name="money[deliveryaward]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="checkbox" value="1" name="money[pointexpiry]"
                                                    {{ (isset($rewardtype['unserializemoney']['pointexpiry']) ? $rewardtype['unserializemoney']['pointexpiry'] : '' == 1) ? 'checked' : '' }} />
                                                <label>Apply point expiry &nbsp;&nbsp;</label>
                                            </div>
                                            <input type="text"
                                                value="{{ isset($rewardtype['unserializemoney']['expiryday']) ? $rewardtype['unserializemoney']['expiryday'] : '' }}"
                                                style="max-width: 250px" class="form-control"
                                                name="money[expiryday]" /><label> days.</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="checkbox" value="1" name="money[maximumaward]"
                                                    {{ (isset($rewardtype['unserializemoney']['maximumaward']) ? $rewardtype['unserializemoney']['maximumaward'] : '' == 1) ? 'checked' : '' }} />
                                                <label>Apply maximum award </label>
                                            </div>
                                            <input type="text"
                                                value="{{ isset($rewardtype['unserializemoney']['maximumorder']) ? $rewardtype['unserializemoney']['maximumorder'] : '' }}"
                                                style="max-width: 250px" class="form-control"
                                                name="money[maximumorder]" /><label>per order</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Exclude</label>
                                                <div style="display: flex;">
                                                    <div class="box-categories">
                                                        @php
                                                            $moneycategory = isset($rewardtype['unserializemoney']['category']) ? $rewardtype['unserializemoney']['category'] : '';
                                                             
                                                        @endphp
                                                        <select class="category form-control" name="money[category][]"
                                                        style="width: 300px" multiple="multiple">
                                                            @foreach ($result['category'] as $categorys)
                                                           
                                                                @if (!empty($moneycategory) || $moneycategory != '')
                                                                    <option value="{{ $categorys->category_id }}"
                                                                        {{ in_array($categorys->category_id, $moneycategory) == $categorys->category_id ? 'selected' : '' }}>
                                                                        {{ $categorys->name }}</option>
                                                                @else
                                                                    <option value="{{ $categorys->category_id }}">
                                                                        {{ $categorys->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="box-products" style="margin-left: 10px">
                                                        @php
                                                            $productcategory = isset($rewardtype['unserializemoney']['product']) ? $rewardtype['unserializemoney']['product'] : '';
                                                           
                                                        @endphp
                                                        <select class="products  form-control" name="money[product][]"
                                                        style="width: 350px" multiple="multiple">
                                                            @foreach ($result['product'] as $products)
                                                                @if (!empty($productcategory) || $productcategory != '')
                                                                    <option value="{{ $products->product_id }}"
                                                                        {{ in_array($products->product_id, $productcategory) == $products->product_id ? 'selected' : '' }}>
                                                                        {{ $products->name }}</option>
                                                                @else
                                                                    <option value="{{ $products->product_id }}">
                                                                        {{ $products->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>


                                    <div class="form-group">
                                        <label for="days" class="form-label">Days availible to spend</label>
                                        <br>
                                        <div class="p-2 rounded" style="border: 1px solid rgb(197, 197, 197)">
                                            @php
                                                $day = isset($rewardtype['unserializemoney']['availibleday']) ? $rewardtype['unserializemoney']['availibleday'] : '';
                                            @endphp
                                            @if (!empty($day) || $day != '')
                                                <input type="checkbox" name="money[availibleday][]" value="2"
                                                    id="money_day_2" {{ in_array(2, $day) ? 'checked' : '' }} />
                                                <label for="money_day_2" class="day_available"> MON </label>
                                            @else
                                                <input type="checkbox" name="money[availibleday][]" value="2"
                                                    id="money_day_2" />
                                                <label for="money_day_2" class="day_available"> MON </label>
                                            @endif

                                            @if (!empty($day) || $day != '')
                                                <input type="checkbox" name="money[availibleday][]" value="3"
                                                    id="money_day_3" {{ in_array(3, $day) ? 'checked' : '' }} />
                                                <label for="money_day_3" class="day_available">TUE</label>
                                            @else
                                                <input type="checkbox" name="money[availibleday][]" value="3"
                                                    id="money_day_3" />
                                                <label for="money_day_3" class="day_available">TUE</label>
                                            @endif




                                            @if (!empty($day) || $day != '')
                                                <input type="checkbox" name="money[availibleday][]" value="4"
                                                    id="money_day_4" {{ in_array(4, $day) ? 'checked' : '' }} />
                                                <label for="money_day_4" class="day_available">WED</label>
                                            @else
                                                <input type="checkbox" name="money[availibleday][]" value="4"
                                                    id="money_day_4" />
                                                <label for="money_day_4" class="day_available">WED</label>
                                            @endif


                                            @if (!empty($day) || $day != '')
                                                <input type="checkbox" name="money[availibleday][]" value="5"
                                                    id="money_day_5" {{ in_array(5, $day) ? 'checked' : '' }} />
                                                <label for="money_day_5" class="day_available">THU</label>
                                            @else
                                                <input type="checkbox" name="money[availibleday][]" value="5"
                                                    id="money_day_5" />
                                                <label for="money_day_5" class="day_available">THU</label>
                                            @endif

                                            @if (!empty($day) || $day != '')
                                                <input type="checkbox" name="money[availibleday][]" value="6"
                                                    id="money_day_6" {{ in_array(6, $day) ? 'checked' : '' }} />
                                                <label for="money_day_6" class="day_available">FRI</label>
                                            @else
                                                <input type="checkbox" name="money[availibleday][]" value="6"
                                                    id="money_day_6" />
                                                <label for="money_day_6" class="day_available">FRI</label>
                                            @endif


                                            @if (!empty($day) || $day != '')
                                                <input type="checkbox" name="money[availibleday][]" value="7"
                                                    id="money_day_7" {{ in_array(7, $day) ? 'checked' : '' }} />
                                                <label for="money_day_7" class="day_available">SAT</label>
                                            @else
                                                <input type="checkbox" name="money[availibleday][]" value="7"
                                                    id="money_day_7" />
                                                <label for="money_day_7" class="day_available">SAT</label>
                                            @endif

                                            @if (!empty($day) || $day != '')
                                                <input type="checkbox" name="money[availibleday][]" value="8"
                                                    id="money_day_8" {{ in_array(8, $day) ? 'checked' : '' }} />
                                                <label for="money_day_8" class="day_available">SUN</label>
                                            @else
                                                <input type="checkbox" name="money[availibleday][]" value="8"
                                                    id="money_day_8" />
                                                <label for="money_day_8" class="day_available">SUN</label>
                                            @endif

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="checkbox" value="1" id="moneyexcludeminimumspend"
                                            name="money[excludeminimumspend]"
                                            {{ (isset($rewardtype['unserializemoney']['excludeminimumspend']) ? $rewardtype['unserializemoney']['excludeminimumspend'] : '' == 1) ? 'checked' : '' }} />
                                        <label for="moneyexcludeminimumspend">Exclude from minimum spend</label>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="checkbox" value="1" id="moneyexcludecoupons"
                                            name="money[excludecoupons]"
                                            {{ (isset($rewardtype['unserializemoney']['excludecoupons']) ? $rewardtype['unserializemoney']['excludecoupons'] : '' == 1) ? 'checked' : '' }} />
                                        <label for="moneyexcludecoupons">Exclude from coupons</label>
                                    </div>
                                </div>

                                <div id="configpointrewards" class="configdiv" style="display: none">
                                    <div class="form-group">
                                        <label>Minimum spend</label>
                                        <input type="text"
                                            value="{{ isset($rewardtype['unserializepoint']['minimum']) ? $rewardtype['unserializepoint']['minimum'] : '' }}"
                                            class="form-control" style="max-width: 250px" name="point[minimum]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Rewards every £0.01</label>
                                        <input type="text"
                                            value="{{ isset($rewardtype['unserializepoint']['rewardsevery']) ? $rewardtype['unserializepoint']['rewardsevery'] : '' }}"
                                            class="form-control" style="max-width: 250px"
                                            name="point[rewardsevery]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Total points must be reached to spend rewards: </label>
                                        <input type="text"
                                            value="{{ isset($rewardtype['unserializepoint']['totalspend']) ? $rewardtype['unserializepoint']['totalspend'] : '' }}"
                                            style="max-width: 250px" class="form-control" name="point[totalspend]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Award £</label>
                                                <input type="text"
                                                    value="{{ isset($rewardtype['unserializepoint']['award']) ? $rewardtype['unserializepoint']['award'] : '' }}"
                                                    style="max-width: 250px" class="form-control"
                                                    name="point[award]" />
                                            </div>
                                            <div class="col-md-3">
                                                <label>every</label>
                                                <input type="text"
                                                    value="{{ isset($rewardtype['unserializepoint']['everypoint']) ? $rewardtype['unserializepoint']['everypoint'] : '' }}"
                                                    style="max-width: 250px" class="form-control"
                                                    name="point[everypoint]" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="checkbox" value="1" name="point[pointexpiry]"
                                                    {{ (isset($rewardtype['unserializepoint']['pointexpiry']) ? $rewardtype['unserializepoint']['pointexpiry'] : '' == 1) ? 'checked' : '' }} />
                                                <label> Apply point expiry </label>
                                            </div>
                                            <input type="text"
                                                value="{{ isset($rewardtype['unserializepoint']['expiryday']) ? $rewardtype['unserializepoint']['expiryday'] : '' }}"
                                                style="max-width: 250px" class="form-control"
                                                name="point[expiryday]" /><label> days.</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Exclude</label>
                                                <div style="display: flex;">
                                                    <div class="box-categories">
                                                        @php
                                                            $moneycategory1 = isset($rewardtype['unserializepoint']['category']) ? $rewardtype['unserializepoint']['category'] : '';

                                                            
                                                        @endphp
                                                        <select class="category form-control" name="point[category][]"
                                                        style="width: 300px" multiple="multiple">

                                                            @foreach ($result['category'] as $categorys)
                                                                @if (!empty($moneycategory1) || $moneycategory1 != '')
                                                                    <option value="{{ $categorys->category_id }}"
                                                                        {{ in_array($categorys->category_id, $moneycategory1) == $categorys->category_id ? 'selected' : '' }}>
                                                                        {{ $categorys->name }}</option>
                                                                @else
                                                                    <option value="{{ $categorys->category_id }}">
                                                                        {{ $categorys->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="box-products" style="margin-left: 10px">
                                                        @php
                                                            $productcategory2 = isset($rewardtype['unserializepoint']['product']) ? $rewardtype['unserializepoint']['product'] : '';
                                                           
                                                        @endphp
                                                        <select class="products  form-control" name="point[product][]"
                                                            style="width: 300px" multiple="multiple">
                                                            @foreach ($result['product'] as $products)
                                                                @if (!empty($productcategory2) || $productcategory2 != '')
                                                                    <option value="{{ $products->product_id }}"
                                                                        {{ in_array($products->product_id, $productcategory2) == $products->product_id ? 'selected' : '' }}>
                                                                        {{ $products->name }}</option>
                                                                @else
                                                                    <option value="{{ $products->product_id }}">
                                                                        {{ $products->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>


                                    <div class="form-group">
                                        <label for="days" class="form-label">Days availible to spend</label>
                                        <br>
                                        <div class="p-2 rounded" style="border: 1px solid rgb(197, 197, 197)">
                                            @php
                                                $days = isset($rewardtype['unserializepoint']['availibleday']) ? $rewardtype['unserializepoint']['availibleday'] : '';
                                            @endphp
                                           
                                            @if (!empty($days) || $days != '')
                                                <input type="checkbox" name="point[availibleday][]" value="2"
                                                    id="point_day_2" {{ in_array(2, $days) ? 'checked' : '' }} />
                                                <label for="point_day_2" class="day_available"> MON </label>
                                            @else
                                                <input type="checkbox" name="point[availibleday][]" value="2"
                                                    id="point_day_2" />
                                                <label for="point_day_2" class="day_available"> MON </label>
                                            @endif

                                            @if (!empty($days) || $days != '')
                                                <input type="checkbox" name="point[availibleday][]" value="2"
                                                    id="point_day_3" {{ in_array(3, $days) ? 'checked' : '' }} />
                                                <label for="point_day_3" class="day_available">TUE</label>
                                            @else
                                                <input type="checkbox" name="point[availibleday][]" value="3"
                                                    id="point_day_3" />
                                                <label for="point_day_3" class="day_available">TUE</label>
                                            @endif

                                            @if (!empty($days) || $days != '')
                                                <input type="checkbox" name="point[availibleday][]" value="4"
                                                    id="point_day_4" {{ in_array(4, $days) ? 'checked' : '' }} />
                                                <label for="point_day_4" class="day_available">WED</label>
                                            @else
                                                <input type="checkbox" name="point[availibleday][]" value="4"
                                                    id="point_day_4" />
                                                <label for="point_day_4" class="day_available">WED</label>
                                            @endif

                                            @if (!empty($days) || $days != '')
                                                <input type="checkbox" name="point[availibleday][]" value="5"
                                                    id="point_day_5" {{ in_array(5, $days) ? 'checked' : '' }} />
                                                <label for="point_day_5" class="day_available">THU</label>
                                            @else
                                                <input type="checkbox" name="point[availibleday][]" value="5"
                                                    id="point_day_5" />
                                                <label for="point_day_5" class="day_available">THU</label>
                                            @endif

                                            @if (!empty($days) || $days != '')
                                                <input type="checkbox" name="point[availibleday][]" value="6"
                                                    id="point_day_6" {{ in_array(6, $days) ? 'checked' : '' }} />
                                                <label for="point_day_6" class="day_available">FRI</label>
                                            @else
                                                <input type="checkbox" name="point[availibleday][]" value="6"
                                                    id="point_day_6" />
                                                <label for="point_day_6" class="day_available">FRI</label>
                                            @endif

                                            @if (!empty($days) || $days != '')
                                                <input type="checkbox" name="point[availibleday][]" value="7"
                                                    id="point_day_7" {{ in_array(7, $days) ? 'checked' : '' }} />
                                                <label for="point_day_7" class="day_available">SAT</label>
                                            @else
                                                <input type="checkbox" name="point[availibleday][]" value="7"
                                                    id="point_day_7" />
                                                <label for="point_day_7" class="day_available">SAT</label>
                                            @endif

                                            @if (!empty($days) || $days != '')
                                                <input type="checkbox" name="point[availibleday][]" value="8"
                                                    id="point_day_8" {{ in_array(8, $days) ? 'checked' : '' }} />
                                                <label for="point_day_8" class="day_available">SUN</label>
                                            @else
                                                <input type="checkbox" name="point[availibleday][]" value="8"
                                                    id="point_day_8" />
                                                <label for="point_day_8" class="day_available">SUN</label>
                                            @endif

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="checkbox" value="1" id="pointexcludeminimumspend"
                                            name="point[excludeminimumspend]"
                                            {{ (isset($rewardtype['unserializepoint']['excludeminimumspend']) ? $rewardtype['unserializepoint']['excludeminimumspend'] : '' == 1) ? 'checked' : '' }} />
                                        <label for="pointexcludeminimumspend">Exclude from minimum spend</label>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="checkbox" value="1" id="pointexcludecoupons"
                                            name="point[excludecoupons]"
                                            {{ (isset($rewardtype['unserializepoint']['excludecoupons']) ? $rewardtype['unserializepoint']['excludecoupons'] : '' == 1) ? 'checked' : '' }} />
                                        <label for="pointexcludecoupons">Exclude from coupons</label>
                                    </div>
                                </div>
                                <div align="center">
                                    <input type="submit" name="submit" value="SAVE" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Trasnsactions --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        $('.category').select2();
        $('.products').select2();
    });
</script>
<script>
    $(document).ready(function() {
        function showhideoption() {
            $('.configdiv').hide();
            var rewardtype = $('input[name="rewardtype"]:checked').val();
            if (rewardtype == 'point') {
                $('#configpointrewards').show();
            } else {
                $('#configmoneyrewards').show();
            }
        }
        showhideoption();
        $('input[name="rewardtype"]').change(function() {
            showhideoption();
        });

        // $(".products").chosen();
        // $(".category").chosen();
    });
</script>
