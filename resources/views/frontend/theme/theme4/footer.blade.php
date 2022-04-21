@php
    $temp_set = session('template_settings');
    $template_setting = isset($temp_set) ? $temp_set : '';

    $social = session('social_site');
    $social_site = isset($social) ? $social : '#';

    $store_set = session('store_settings');
    $store_setting = isset($store_set) ? $store_set : '';
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
          <li><a class="text-uppercase foot_link" href="#">member</a></li>
          <li><a class="text-uppercase foot_link" href="{{ route('menu') }}">menu</a></li>
          <li><a class="text-uppercase foot_link" href="#">check out</a></li>
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
