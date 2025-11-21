<?php get_header(); ?>

<!-- ページコンテンツ -->
<?php if ( is_page(array('privacypolicy', 'terms-of-service')) ): ?>
  <?php $slug = get_post_field('post_name', get_post()); ?>
  <div class="page-policy page-policy-layout">
    <div class="page-policy__body legal legal--<?php echo esc_attr( $slug ); ?>">
      <div class="legal__inner inner">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php get_footer(); ?>