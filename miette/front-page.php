<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<main>
  <!-- ファーストビュー -->
  <section class="mv">
   
  </section>

  <!-- ボタン -->
  <div class="lesson__button">
    <a href="<?php echo $lesson; ?>" class="button">
      もっと知る
      <span></span>
    </a>
  </div>
  

<?php get_footer(); ?>