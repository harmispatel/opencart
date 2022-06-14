<!--
    THIS IS LAYOUT(THEME) 2 FOOTER PAGE FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    footer.blade.php
    It Displayed Layout(Theme) 2 Footer
    ----------------------------------------------------------------------------------------------
-->

@php
    
    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = themeID($currentURL);
    $theme_id = $current_theme_id['theme_id'];
    $front_store_id =  $current_theme_id['store_id'];
    // // Get Current Theme ID & Store ID

    // Get Store Settings & Theme Settings & Other
    $store_theme_settings = storeThemeSettings($theme_id,$front_store_id);
    //End Get Store Settings & Theme Settings & Other

    // Template Settings
    $template_setting = $store_theme_settings['template_settings'];
    // End Template Settings

    // Social Site Settings
    $social_site = $store_theme_settings['social_settings'];
    // End Social Site Settings

    // Store Settings
    $store_setting = $store_theme_settings['store_settings'];
    // End Store Settings

    // Get Open-Close Time
    $openclose = openclosetime();
    // End Open-Close Time

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type

@endphp
<style>
    .footer-v2
    {
        background: <?php echo $template_setting['polianna_footer_background']; ?> !important;
    }

    footer .row .footer-title
    {
        color: <?php echo $template_setting['polianna_footer_title_color']; ?> !important;
    }

    footer .info-group .row .foot_content ,.foot_link
    {
        color: <?php echo $template_setting['polianna_footer_text_color']; ?> !important;
    }
</style>


<footer class="footer-v2 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="footer-content">
      <div class="container ">
        <div class="row">
          <div class="col-sm-12 col-md-4"><a class="f-logo" href="{{ route('home') }}"><img class="img-fluid" src="{{ $template_setting['polianna_footer_logo'] }}"/></a>
            <p class="foot_link">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus illo porro similique voluptate. Accusamus amet aut beatae consequatur doloremque eius explicabo</p>
            <div class="social-links">
                <a class="fab fa-facebook-f" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="contact-list">
              <h5 class="footer-title  text-uppercase">contacts</h5>
              <p class="foot_link">{{ $store_setting['config_address'] }}</p>
              <a class="foot_link" href="tel:{{  $store_setting['config_telephone'] }}">Phone: +222 222 22 22</a>
              <a class="foot_link" href="mailto:{{ $store_setting['config_email'] }}">Email: info@mail.com</a>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <h5 class="footer-title  text-uppercase">quick links</h5>
            <ul class="row foot_link quick-links ">
              <li class="col-6"><a class="text-uppercase foot_link" href="{{ route('home') }}">home</a></li>
              <li class="col-6"><a class="text-uppercase foot_link" href="#">gallery</a></li>
              <li class="col-6"><a class="text-uppercase foot_link" href="#">about</a></li>
              <li class="col-6"><a class="text-uppercase foot_link" href="#">pages</a></li>
              <li class="col-6"><a class="text-uppercase foot_link" href="#">shop</a></li>
              <li class="col-6"><a class="text-uppercase foot_link" href="#">blog</a></li>
              <li class="col-6"><a class="text-uppercase foot_link" href="{{ route('menu') }}">menu</a></li>
              <li class="col-6"><a class="text-uppercase foot_link" href="{{ route('contact') }}">contact</a></li>
              <li class="col-6"><a class="text-uppercase foot_link" href="#">support</a></li>
              <li class="col-6"><a class="text-uppercase foot_link" href="#">reservation</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
        <p>Copyright © 2021 Star Kebab Tenterden</p>
      </div>
    </div>
  </footer>
  <a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
