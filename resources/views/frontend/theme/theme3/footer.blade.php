@php
    $temp_set = session('template_settings');
    $template_setting = isset($temp_set) ? $temp_set : '';

    $social = session('social_site');
    $social_site = isset($social) ? $social : '#';

    $store_set = session('store_settings');
    $store_setting = isset($store_set) ? $store_set : '';
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
