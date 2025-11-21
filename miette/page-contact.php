<?php get_header(); ?>

<!-- ページコンテンツ -->
  <div class="page-contact page-contact-layout">
    <div class="page-contact__inner inner">

      <!-- エラーメッセージ -->
      <div class="page-contact__error"></div>
      
      <!-- お問い合わせフォーム -->
      <?php echo do_shortcode('[contact-form-7 id="268ee84" title="お問い合わせ"]'); ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
