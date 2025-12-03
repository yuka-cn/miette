<?php get_header(); ?>

<!-- ページコンテンツ -->
  <div class="contact contact-layout">
    <div class="contact__inner inner">

      <!-- エラーメッセージ -->
      <div class="contact__error"></div>
      
      <!-- お問い合わせフォーム -->
      <?php echo do_shortcode('[contact-form-7 id="bdd0e72" title="お問い合わせ"]'); ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
