<!doctype html>
<html>
<head>
    {{-- CSS --}}
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/pages/menu.css') }}">
    {{-- End CSS --}}
</head>
<body>

    @php
        if(session()->has('theme_id'))
        {
            $theme_id = session()->get('theme_id');
        }
        else
        {
            $theme_id = 1;
        }
    @endphp

{{-- Header --}}
@include('frontend.theme.theme'.$theme_id.'.header')
{{-- End Header --}}

    <div class="mobile-menu-shadow"></div>
    <sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo" href="#slide"><img class="img-fluid" src="./assets/img/logo/black-logo.svg"/></a>
      <div class="top">
        <ul class="menu">
          <li class="active"><a class="text-uppercase" href="#">home</a></li>
          <li><a class="text-uppercase" href="#">member</a></li>
          <li><a class="text-uppercase" href="{{ route('menu') }}">menu</a></li>
          <li><a class="text-uppercase" href="#">check out</a></li>
          <li><a class="text-uppercase" href="#">contact us</a></li>
        </ul>
      </div>
      <div class="center">
        <ul class="authentication-links">
          <li><a href="#"><i class="far fa-user"></i><span>Login</span></a></li>
          <li><a href="#"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
        </ul>
      </div>
      <div class="bottom">
        <div class="working-time"><strong class="text-uppercase">Working Time:</strong><span>09:00 - 23:00</span></div>
        <ul class="social-links">
          <li><a class="fab fa-facebook" href="#" target="_blank"></a></li>
          <li><a class="fab fa-twitter" href="#" target="_blank"></a></li>
          <li><a class="fab fa-pinterest-p" href="#" target="_blank"></a></li>
          <li><a class="fab fa-instagram" href="#" target="_blank"></a></li>
        </ul>
      </div>
    </sidebar>
    <section class="main-innr">
      <div class="container">
        <div class="row">
          <div class="col-md-7 col-lg-8">
            <div class="row">
              <div class="col-lg-4">
                <div class="cate-part wow animate__fadeInUp cate-list-part" data-wow-duration="1s">
                  <div class="category-title">
                    <h2>Categories</h2>
                  </div>
                  <div >
                    <ul class="box-category">
                       @foreach ($data['category'] as $category)
                        @php
                          $demo =$category->category_id;
                          $productcount =getproductcount($demo);
                           
                        
                        @endphp
                            
                       <li><a href="#" class="active">{{ $category->name  }}   ({{ ($productcount) }})</a></li>
                       @endforeach
                     
                    </ul>
                  </div>
                </div>
                <div class="cate-part wow animate__fadeInUp cate-part-select-box" data-wow-duration="1s">
                  <select class="form-control">
                    <option>Show All Categories</option>
                    <option>PIZZA DEALS (5)</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="product-list wow animate__fadeInUp" data-wow-duration="1s">
                  <div class="product-list-innr" >
                    
                    @foreach ($data['category'] as $value )
                     
                    @php
                          $cat_id=$value->category_id;
                          $front_store_id= session('front_store_id'); 
                          $result=getproduct($front_store_id,$cat_id);

                          // echo '<pre>';
                          // print_r($product);
                          
                    @endphp
                     
                   
                       
                        
                       
                    
 
                    <div class="accordion" id="accordionExample">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <span>{{ $value->name }}</span>
                            <i class="fa fa-angle-down"></i>
                          </button>
                        </h2>
                        
                            
                        @foreach($result['product'] as $values)
                           
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>{{ $values->hasOneDescription['name'] }}</h4>
                                <p>{{ $values->hasOneDescription['description'] }}</p>
                                <img src="{{ asset('public/admin/product/' . $values->hasOneProduct['image']) }}"
                                width="80px">
                              </div>
                              <div class="options-bt-main">
                                @foreach ($result['size'] as $size)
                                <div class="options-bt">
                                  <span>{{ $size->size }}</span>
                                  <a href="" class="btn options-btn">£15.00<i class="fa fa-shopping-basket"></i></a>
                                </div>
                                @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-5 col-lg-4">
            <div class="cart-part wow animate__fadeInUp" data-wow-duration="1s">
              <div class="close-shop">
                <h2>Sorry we are closed now!</h2>
                <span>We will be opening back at 16:00 Today</span>
              </div>
              <div class="minicart">
                <div class="minibox-title">
                  <h3>My Basket</h3>
                  <i class="fa fa-shopping-basket"></i>
                </div>
                <div class="minibox-content">
                  <div class="empty-box">
                    <span>Your shopping cart is empty!</span>
                  </div>
                  <div class="minicart-total">
                    <ul class="minicart-list">
                      <li class="minicart-list-item">
                        <div class="minicart-list-item-innr">
                          <label>Sub-Total</label>
                          <span>£0.00</span>
                        </div>
                      </li>
                      <li class="minicart-list-item">
                        <div class="minicart-list-item-innr">
                          <label>Total to pay:</label>
                          <span>£0.00</span>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="order-type">
                    <div class="order-type-innr">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                          <h4>Delivery</h4>
                          <span>Starts at 16:50</span>
                        </label>
                      </div>
                    </div>
                    <div class="order-type-innr">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                          <h4>Collection</h4>
                          <span>Starts at 16:50</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <a href="" class="btn disabled checkbt">Checkout</a>
              <div class="closed-now">
                <span class="closing-text ">We are closed now!</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- Footer --}}
    @include('frontend.theme.theme'.$theme_id.'.footer')
    {{-- End Footer --}}

    {{-- JS --}}
    @include('frontend.include.script')
    {{-- END JS --}}

  </body>
</html>
