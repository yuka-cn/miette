<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<?php if ( is_page('privacy') ): ?>
  <?php $slug = get_post_field('post_name', get_post()); ?>
  <div class="policy policy-layout">
    <div class="policy__body legal legal--<?php echo esc_attr( $slug ); ?>">
      <div class="legal__inner inner">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- お問い合わせ -->
<div class="policy__button">
  <a href="<?php echo $contact; ?>" class="button">
    お問い合わせはこちら
    <span></span>
  </a>
</div>

<?php get_footer(); ?>