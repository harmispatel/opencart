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
                          $productcount =getproduct($demo);
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
                    <option>PIZZAS (27)</option>
                    <option>CALZONE (1)</option>
                    <option>GARLIC PIZZAS (2)</option>
                    <option>MEAL DEALS (3)</option>
                    <option>PASTA (5)</option>
                    <option>WRAPS (9)</option>
                    <option>KIDS MEALS (2)</option>
                    <option>EXTRAS (21)</option>
                    <option>SAUCES (8)</option>
                    <option>DESSERTS (4)</option>
                    <option>DRINKS (11)</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="product-list wow animate__fadeInUp" data-wow-duration="1s">
                  <div class="product-list-innr" >
                    <div class="accordion" id="accordionExample">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            @foreach ($data['category'] as $value )
                            <span>{{ $value->name }}</span>
                              
                            @endforeach
                            <i class="fa fa-angle-down"></i>
                          </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>MARGHERITA</h4>
                                <p>Cheese and Tomato</p>
                                <img src="./assets/demo-data/photo-gallery/placehold 8.jpg">
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>LONDON PIZZA</h4>
                                <p>Chips and Cheese</p>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>AL FUNGHI</h4>
                                <p>Mushrooms and Cheese</p>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>MARGHERITA</h4>
                                <p>Cheese and Tomato</p>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion" id="accordionExample">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                           <span> PIZZAS</span>
                            <i class="fa fa-angle-down"></i>
                          </button>
                          <p>9" (Regular), 12" (Large), 16" (Family Size)</p>
                        </h2>
                        <div id="collapsethree" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>MARGHERITA</h4>
                                <span>Cheese and Tomato</span>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>LONDON PIZZA</h4>
                                <span>Chips and Cheese</span>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>AL FUNGHI</h4>
                                <span>Mushrooms and Cheese</span>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>MARGHERITA</h4>
                                <span>Cheese and Tomato</span>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion" id="accordionExample">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                            <span>CALZONE</span>
                            <i class="fa fa-angle-down"></i>
                          </button>
                          <p>TRY OUR NEW ITALIAN STYLE CALZONES</p>
                        </h2>
                        <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>MARGHERITA</h4>
                                <span>Cheese and Tomato</span>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>LONDON PIZZA</h4>
                                <span>Chips and Cheese</span>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>AL FUNGHI</h4>
                                <span>Mushrooms and Cheese</span>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                            <div class="acc-body-inr">
                              <div class="acc-body-inr-title">
                                <h4>MARGHERITA</h4>
                                <span>Cheese and Tomato</span>
                              </div>
                              <div class="options-bt-main">
                                <div class="options-bt">
                                  <span>9"</span>
                                  <a href="" class="btn options-btn">£05.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>12"</span>
                                  <a href="" class="btn options-btn">£06.49 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                                <div class="options-bt">
                                  <span>16"</span>
                                  <a href="" class="btn options-btn">£10.00 <i class="fa fa-shopping-basket"></i></a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
