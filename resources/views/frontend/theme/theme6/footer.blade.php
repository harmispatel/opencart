<!--
    THIS IS LAYOUT(THEME) 6 FOOTER PAGE FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    footer.blade.php
    It Displayed Layout(Theme) 6 Footer
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
    .footer-v6 .footer-top
    {
        background: <?php echo $template_setting['polianna_footer_background']; ?> !important;
    }

    footer .__footer-title
    {
        color: <?php echo $template_setting['polianna_footer_title_color']; ?> !important;
    }

    footer .copyright
    {
        color: <?php echo $template_setting['polianna_footer_text_color']; ?> !important;
    }
</style>

<footer class="footer-v6 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="footer-top backgroundcolor">
      <h4 class="__footer-title text-uppercase">thank you and welcome back!</h4>
      <p class="copyright">Copyright © 2021 Star Kebab Tenterden</p>
      <div class="__btn-top"><i class="fas fa-arrow-up"></i></div>
    </div>
    <div class="footer-bottom"><a class="f-logo"><img class="img-fluid" src="{{ $template_setting['polianna_footer_logo'] }}"/></a>
      <div class="__social-links">
          <a href="{{ $social_site['polianna_facebook_id'] }}" target="_blank" class="fab fa-facebook"></a>
          <a href="{{ $social_site['polianna_twitter_username'] }}" target="_blank" class="fab fa-twitter"></a>
          <a href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank" class="fab fa-linkedin"></a>
          <a href="{{ $social_site['polianna_youtube_id'] }}" target="_blank" class="fab fa-youtube"></a>
      </div>
    </div>
  </footer>
  <a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
