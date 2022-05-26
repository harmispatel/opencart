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
    .footer-top
    {
        background: <?php echo $template_setting['polianna_footer_background']; ?> !important;
    }

    /* footer .row .footer-title
    {
        color: <?php echo $template_setting['polianna_footer_title_color']; ?> !important;
    } */

    footer .foot_link
    {
        color: <?php echo $template_setting['polianna_footer_text_color']; ?> !important;
    }
</style>

<footer class="footer-v4 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="footer-top">
      <div class="container">
        <ul class="__menu">
          <li><a class="text-uppercase foot_link" href="{{ route('home') }}">home</a></li>
          <li><a class="text-uppercase foot_link" href="{{ route('member') }}">member</a></li>
          <li><a class="text-uppercase foot_link" href="{{ route('menu') }}">menu</a></li>
          <li><a class="text-uppercase foot_link" href="{{ route('checkout') }}">check out</a></li>
          <li><a class="text-uppercase foot_link" href="{{ route('contact') }}">contact us</a></li>
        </ul>
        <div class="__social-links">
          <a class="fab fa-facebook-f foot_link" href="{{ $social_site['polianna_facebook_id'] }}"></a>
          <a class="fab fa-twitter foot_link"    href="{{ $social_site['polianna_twitter_username'] }}"></a>
          <a class="fab fa-linkedin foot_link"   href="{{ $social_site['polianna_linkedin_id'] }}"></a>
          <a class="fab fa-youtube foot_link"  href="{{ $social_site['polianna_youtube_id'] }}"></a></div>
      </div><a class="f-logo" href="{{ route('home') }}">
        <img class="img-fluid" src="{{ $template_setting['polianna_footer_logo'] }}"/></a>
    </div>
    <div class="footer-bottom">
      <p>Copyright © 2021 Star Kebab Tenterden</p>
    </div>
  </footer>
  <a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
