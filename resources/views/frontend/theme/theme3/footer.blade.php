<!--
    THIS IS LAYOUT(THEME) 3 FOOTER PAGE FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    footer.blade.php
    It Displayed Layout(Theme) 3 Footer
    ----------------------------------------------------------------------------------------------
-->

@php
    
    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = layoutID($currentURL,'header_id');
    $theme_id = $current_theme_id['header_id'];
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
    .info-group
    {
        background: <?php echo $template_setting['polianna_footer_background']; ?> !important;
    }

    .footer-v3 .info-group .container .title
    {
        color: <?php echo $template_setting['polianna_footer_title_color']; ?> !important;
    }

    .footer-v3 .info-group .container .foot_content,.foot_link
    {
        color: <?php echo $template_setting['polianna_footer_text_color']; ?> !important;
    }
</style>
<footer class="footer-v3 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="footer-top info-group">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-3">
            <div class="footer-about">
              <h5 class="footer-title text-capitalize title">star kebab <br> tenterden</h5>
              <p class="foot_content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Bibendum est ultricies integer quis. Iaculis urna id</p><a class="text-uppercase" href="">read more<i class="fas fa-angle-double-right"></i></a>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-9">
            <h5 class="footer-title text-capitalize title">get in touch</h5>
            <div class="row">
              <div class="col-12 col-sm-12 col-md-6">
                <div class="__info-item"><strong>Office Address</strong>
                  <p class="foot_content">{{ $store_setting['config_address'] }}</p>
                </div>
                <div class="__info-item"><strong>Phone Number</strong><a href="tel:">{{  $store_setting['config_telephone'] }}</a></div>
              </div>
              <div class="col-12 col-sm-12 col-md-6">
                <div class="__info-item"><strong>E-mail Address</strong><a href="mailto:">{{ $store_setting['config_email'] }}</a></div>
                <div class="__info-item"><strong>Online Follow Us</strong>
                  <div class="__social-links">
                      <a href="{{ $social_site['polianna_facebook_id'] }}" target="_blank" class="fab fa-facebook-f"></a>
                      <a  href="{{ $social_site['polianna_twitter_username'] }}" target="_blank" class="fab fa-twitter"></a>
                      <a  href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank" class="fab fa-linkedin"></a>
                      <a href="{{ $social_site['polianna_youtube_id'] }}" target="_blank" class="fab fa-youtube"></a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>Copyright © 2021 Star Kebab Tenterden</p>
    </div>
  </footer>
  <a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
