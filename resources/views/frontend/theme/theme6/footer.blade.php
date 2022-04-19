@php

    $social = session('social_site');
    $social_site = isset($social) ? $social : '#';

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
