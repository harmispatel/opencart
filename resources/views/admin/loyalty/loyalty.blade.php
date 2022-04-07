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
                                {{-- @php
                                    $current_store = currentStoreId();
                                    $minimum=getLoyaltyDetails($current_store,'money[minimum]');
                                    echo '<pre> hello';
                                        
                                  
                                @endphp --}}
                                <div class="rewardtype">
                                    <div class="radio">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="radio" name="rewardtype" value="point">
                                                    <span>Point Rewards</span>
                                                </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="radio" name="rewardtype" value="money">
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
                                <div id="configmoneyrewards" class="configdiv" >
                                    <div class="form-group">
                                        <label>Minimum spend</label>
                                        <input type="text" value="" class="form-control" style="max-width: 250px"
                                            name="money[minimum]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Collection &nbsp; Award %</label>
                                        <input type="text" value="" class="form-control" style="max-width: 250px"
                                            name="money[collectionaward]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Delivery &nbsp;&nbsp;&nbsp;&nbsp; Award %</label>
                                        <input type="text" value="" style="max-width: 250px" class="form-control"
                                            name="money[deliveryaward]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="checkbox"  value="1" name="money[pointexpiry]" />
                                                <label>Apply point expiry &nbsp;&nbsp;</label>
                                            </div>
                                            <input type="text" value="" style="max-width: 250px" class="form-control"
                                                name="money[expiryday]" /><label> days.</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="checkbox"  value="1" name="money[maximumaward]" />
                                                <label>Apply maximum award </label>
                                            </div>
                                            <input type="text" value="" style="max-width: 250px" class="form-control"
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
                                                        <select class="category form-control" name="money[category][]" multiple="multiple" >
                                                            @foreach ($result['category'] as $categorys )
                                                                
                                                            <option value="{{ $categorys->category_id }}">{{ $categorys->name }}</option>
                                                            @endforeach
                                                          </select>
                                                    </div>
                                                    <div class="box-products" style="margin-left: 10px">
                                                        <select class="products  form-control" name="money[product][]" multiple="multiple">
                                                            @foreach ($result['product'] as $products)

                                                                 <option value="{{ $products->product_id }}">{{ $products->name }}</option>
                                                                
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
                                            <input type="checkbox" name="money[availibleday][]" value="2"
                                                id="money_day_2" />
                                            <label for="money_day_2" class="day_available"> MON </label>
                                            <input type="checkbox" name="money[availibleday][]" value="3"
                                                id="money_day_3" />
                                            <label for="money_day_3" class="day_available">TUE</label>
                                            <input type="checkbox" name="money[availibleday][]" value="4"
                                                id="money_day_4" />
                                            <label for="money_day_4" class="day_available">WED</label>
                                            <input type="checkbox" name="money[availibleday][]" value="5"
                                                id="money_day_5" />
                                            <label for="money_day_5" class="day_available">THU</label>
                                            <input type="checkbox" name="money[availibleday][]" value="6"
                                                id="money_day_6" />
                                            <label for="money_day_6" class="day_available">FRI</label>
                                            <input type="checkbox" name="money[availibleday][]" value="7"
                                                id="money_day_7" />
                                            <label for="money_day_7" class="day_available">SAT</label>
                                            <input type="checkbox" name="money[availibleday][]" value="8"
                                                id="money_day_8" />
                                            <label for="money_day_8" class="day_available">SUN</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="checkbox" value="1" id="moneyexcludeminimumspend"
                                            name="money[excludeminimumspend]" />
                                        <label for="moneyexcludeminimumspend">Exclude from minimum spend</label>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="checkbox" value="1" id="moneyexcludecoupons"
                                            name="money[excludecoupons]" />
                                        <label for="moneyexcludecoupons">Exclude from coupons</label>
                                    </div>
                                </div>




                                <div id="configpointrewards" class="configdiv" style="display: none" >
                                    <div class="form-group">
                                        <label>Minimum spend</label>
                                        <input type="text" value="" class="form-control" style="max-width: 250px"
                                            name="point[minimum]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Rewards every £0.01</label>
                                        <input type="text" value="" class="form-control" style="max-width: 250px"
                                            name="point[rewardsevery]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Total points must be reached to spend rewards: </label>
                                        <input type="text" value="" style="max-width: 250px" class="form-control"
                                            name="point[totalspend]" />
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Award £</label>
                                                <input type="text" value="" style="max-width: 250px"
                                                    class="form-control" name="point[award]" />
                                            </div>
                                            <div class="col-md-3">
                                                <label>every</label>
                                                <input type="text" value="" style="max-width: 250px"
                                                    class="form-control" name="point[everypoint]" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="checkbox" value="1" name="point[pointexpiry]" />
                                                <label> Apply point expiry </label>
                                            </div>
                                            <input type="text" value="" style="max-width: 250px" class="form-control"
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
                                                        <select class="category form-control" name="point[category][]" multiple="multiple" >
                                                            @foreach ($result['category'] as $categorys )
                                                                
                                                            <option value="{{ $categorys->category_id }}">{{ $categorys->name }}</option>
                                                            @endforeach
                                                          </select>
                                                    </div>
                                                    <div class="box-products" style="margin-left: 10px">
                                                        <select class="products  form-control" name="point[product][]" style="width: 200px" multiple="multiple">
                                                            @foreach ($result['product'] as $products)

                                                            <option value="{{ $products->product_id }}">{{ $products->name }}</option>
                                                           
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
                                            <input type="checkbox" name="point[availibleday][]" value="2"
                                                id="point_day_2" />
                                            <label for="point_day_2" class="day_available"> MON </label>
                                            <input type="checkbox" name="point[availibleday][]" value="2"
                                                id="point_day_3" />
                                            <label for="point_day_3" class="day_available">TUE</label>
                                            <input type="checkbox" name="point[availibleday][]" value="4"
                                                id="point_day_4" />
                                            <label for="point_day_4" class="day_available">WED</label>
                                            <input type="checkbox" name="point[availibleday][]" value="5"
                                                id="point_day_5" />
                                            <label for="point_day_5" class="day_available">THU</label>
                                            <input type="checkbox" name="point[availibleday][]" value="6"
                                                id="point_day_6" />
                                            <label for="point_day_6" class="day_available">FRI</label>
                                            <input type="checkbox" name="point[availibleday][]" value="7"
                                                id="point_day_7" />
                                            <label for="point_day_7" class="day_available">SAT</label>
                                            <input type="checkbox" name="point[availibleday][]" value="8"
                                                id="point_day_8" />
                                            <label for="point_day_8" class="day_available">SUN</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="checkbox" value="1" id="pointexcludeminimumspend"
                                            name="point[excludeminimumspend]" />
                                        <label for="pointexcludeminimumspend">Exclude from minimum spend</label>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="checkbox" value="1" id="pointexcludecoupons"
                                            name="point[excludecoupons]" />
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


$(document).ready(function(){
       function showhideoption()
       {
            $('.configdiv').hide();
            var rewardtype = $('input[name="rewardtype"]:checked').val();
            if(rewardtype == 'point')
            {
                $('#configpointrewards').show();
            }
            else
            {
                $('#configmoneyrewards').show();
            }
       } 
       showhideoption();
       $('input[name="rewardtype"]').change(function(){
            showhideoption();
       });
       
        $(".products").chosen();
        $(".category").chosen();
    });
</script>
