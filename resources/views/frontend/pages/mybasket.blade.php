
<html lang="en">
    <head>
      <meta charset="utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1"/>
      <title>Star Kebab & Pizza</title>
      <!--Css Files-->
      <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;700&amp;display=swap" rel="stylesheet"/>
      <link rel="stylesheet" href="./assets/plugins/bootstrap/dist/css/bootstrap.min.css"/>
      <link rel="stylesheet" href="./assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"/>
      <link rel="stylesheet" href="./assets/plugins/fontawesome/css/all.min.css"/>
      <link rel="stylesheet" href="./assets/plugins/swiper-js/swiper-bundle.min.css"/>
      <link rel="stylesheet" href="./assets/plugins/ui/dist/fancybox.css"/>
      <link rel="stylesheet" href="./assets/plugins/animate.css/animate.min.css"/>
      <link rel="stylesheet" href="./assets/plugins/select2/dist/css/select2.min.css"/>
      <link rel="stylesheet" href="./assets/css/app.css"/>
      <link rel="stylesheet" href="./assets/css/inr.css"/>
      <link rel="stylesheet" href="./assets/css/responsive.css"/>
    </head>
    <body>
      <header class="header">
        <div class="container">
          <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
            <div class="working-time"><strong class="text-uppercase">Working Time:</strong><span>09:00 - 23:00</span></div>
            <ul class="social-links">
              <li><a class="fab fa-facebook" href="#" target="_blank"></a></li>
              <li><a class="fab fa-twitter" href="#" target="_blank"></a></li>
              <li><a class="fab fa-pinterest-p" href="#" target="_blank"></a></li>
              <li><a class="fab fa-instagram" href="#" target="_blank"></a></li>
            </ul>
            <ul class="authentication-links">
              <li><a href="#"><i class="far fa-user"></i><span>Login</span></a></li>
              <li><a href="#"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
            </ul>
          </div>
          <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s"><a class="logo" href="#slide"><img class="img-fluid" src="./assets/img/logo/logo.svg"/></a>
            <ul class="menu">
              <li><a class="text-uppercase" href="index.html">home</a></li>
              <li><a class="text-uppercase" href="member.html">member</a></li>
              <li><a class="text-uppercase" href="menu.html">menu</a></li>
              <li><a class="text-uppercase" href="checkout.html">check out</a></li>
              <li><a class="text-uppercase" href="contact-us.html">contact us</a></li>
            </ul><a class="menu-shopping-cart active" href="">
              <div class="number"><i class="fas fa-shopping-basket"></i><span>2</span></div>
              <div class="price-box"><strong>Shopping Cart:</strong>
                <div class="price"><i class="fas fa-dollar-sign"></i><span class="pirce-value">32.10</span></div>
              </div></a><a class="open-mobile-menu" href="javascript:void(0)"><span class="text-uppercase">menu</span><i class="fas fa-bars"></i></a>
          </div>
        </div>
      </header>
      <div class="mobile-menu-shadow"></div>
      <sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo" href="#slide"><img class="img-fluid" src="./assets/img/logo/logo.svg"/></a>
        <div class="top">
          <ul class="menu">
            <li class="active"><a class="text-uppercase" href="#">home</a></li>
            <li><a class="text-uppercase" href="#">member</a></li>
            <li><a class="text-uppercase" href="#">menu</a></li>
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
      <section class="basket-main">
        <div class="container"> 
          <div class="basket-inr">
            <div class="basket-title">
              <h2>SHOPPING CART</h2>
            </div>
            <div class="basket-product-detail">
              <form>
                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Unit Price</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Image</td>
                      <td>1/2 VEGETARIAN BURGER</td>
                      <td>
                        <div class="qu-inr">
                          <input type="text" name="">
                          <a href=""><i class="far fa-repeat"></i></a>
                          <a href=""><i class="fas fa-times"></i></a>
                        </div>
                      </td>
                      <td>£4.20</td>
                      <td>£4.20</td>
                    </tr>
                  </tbody>
                </table>
              </form>
            </div>
            <div class="coupon-inr">
              <div class="coupon-title">
                <h2>What would you like to do next?</h2>
                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
              </div>
              <div class="coupon-apply">
                <div class="accordion" id="accordionPanelsStayOpenExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header accordion-button collapsed" id="panelsStayOpen-headingOne" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        Accordion Item #1
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                      <div class="accordion-body">
                        123
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header accordion-button collapsed" id="panelsStayOpen-headingTwo" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        Accordion Item #2
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                      <div class="accordion-body">
                       456
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="basket-total">
              <table class="table table-responsive">
                <tbody>
                  <tr>
                    <td><b>Sub-Total:</b></td>
                    <td><span><b>£4.20</b></span></td>
                  </tr>
                  <tr>
                    <td><b>Total to pay:</b></td>
                    <td><span><b>£4.20</b></span></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="basket-bt">
              <button class="btn">Continue Shopping</button>
              <button class="btn">Checkout</button>
            </div>
          </div>
        </div>
      </section>
      <footer class="footer wow animate__fadeInUp" data-wow-duration="1s">
        <div class="container info-group wow animate__fadeInUp" data-wow-duration="1s">
          <div class="row">
            <div class="col-12 col-sm-12 col-md-4 input-group-item"><strong class="title top-divider-red">Our Address</strong>
              <p>Lorem Ipsum Dolor Sit Amet <br>Consensus Feel Free</p>
            </div>
            <div class="col-12 col-sm-12 col-md-4 input-group-item"><strong class="title top-divider-green">Contact Info</strong><a href="mailto:mail@mail.com">mail@mail.com</a><a href="tel:0850 221 22 11">0850 221 22 11</a></div>
            <div class="col-12 col-sm-12 col-md-4 input-group-item"><strong class="title top-divider-orange">Our Reservation</strong>
              <p>You can make a reservation online by <br> clicking on find table link.</p>
            </div>
          </div>
        </div><a class="f-logo" href=""><img class="img-fluid" src="./assets/img/logo/f-logo.svg"/></a>
        <ul class="social-links">
          <li><a class="fab fa-facebook" href="#" target="_blank"></a></li>
          <li><a class="fab fa-twitter" href="#" target="_blank"></a></li>
          <li><a class="fab fa-pinterest-p" href="#" target="_blank"></a></li>
          <li><a class="fab fa-instagram" href="#" target="_blank"></a></li>
        </ul>
        <div class="copyright">
          <p>Copyright © 2021 Star Kebab Tenterden</p>
        </div>
      </footer>
      <a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
      <!--Js Files-->
      <script type="text/javascript" src="./assets/plugins/jquery/dist/jquery.min.js"></script>
      <script type="text/javascript" src="./assets/plugins/moment/min/moment.min.js"></script>
      <script type="text/javascript" src="./assets/plugins/moment/min/locales.min.js"></script>
      <script type="text/javascript" src="./assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="./assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
      <script type="text/javascript" src="./assets/plugins/wow/dist/wow.min.js"></script>
      <script type="text/javascript" src="./assets/plugins/swiper-js/swiper-bundle.min.js"></script>
      <script type="text/javascript" src="./assets/plugins/ui/dist/fancybox.umd.js"></script>
      <script type="text/javascript" src="./assets/plugins/select2/dist/js/select2.min.js"></script>
      <script type="text/javascript" src="./assets/plugins/select2/dist/js/i18n/tr.js"></script>
      <script type="text/javascript" src="./assets/js/app.js"></script>
    </body>
  </html>