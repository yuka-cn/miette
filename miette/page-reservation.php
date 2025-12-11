<?php get_header(); ?>

<!-- ページコンテンツ -->
  <div class="reservation reservation-layout">
    <div class="reservation__inner inner">

      <!-- エラーメッセージ -->
      <div class="reservation__error"></div>
      
      <!-- お問い合わせフォーム -->
      <?php echo do_shortcode('[contact-form-7 id="166489f" title="レッスン予約"]'); ?>
    </div>
  </div>

<?php get_footer(); ?>
