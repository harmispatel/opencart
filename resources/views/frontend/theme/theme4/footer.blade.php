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
    }

    footer .info-group .row .foot_content ,.foot_link
    {
        color: <?php echo $template_setting['polianna_footer_text_color']; ?> !important;
    } */
</style>

<footer class="footer-v4 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="footer-top">
      <div class="container">
        <ul class="__menu">
          <li><a class="text-uppercase" href="{{ route('home') }}">home</a></li>
          <li><a class="text-uppercase" href="#">member</a></li>
          <li><a class="text-uppercase" href="{{ route('menu') }}">menu</a></li>
          <li><a class="text-uppercase" href="#">check out</a></li>
          <li><a class="text-uppercase" href="{{ route('contact') }}">contact us</a></li>
        </ul>
        <div class="__social-links">
          <a class="fab fa-facebook-f" href="{{ $social_site['polianna_facebook_id'] }}"></a>
          <a class="fab fa-twitter"    href="{{ $social_site['polianna_twitter_username'] }}"></a>
          <a class="fab fa-linkedin"   href="{{ $social_site['polianna_linkedin_id'] }}"></a>
          <a class="fab fa-instagram"  href="#"></a></div>
      </div><a class="f-logo" href="{{ route('home') }}">
        <img class="img-fluid" src="{{ $template_setting['polianna_footer_logo'] }}"/></a>
    </div>
    <div class="footer-bottom">
      <p>Copyright © 2021 Star Kebab Tenterden</p>
    </div>
  </footer>
  <a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
