<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<div class="single-blog single-blog-layout">
  <div class="single-blog__content">
    <div class="single-blog__inner inner">
      <div class="single-blog__body">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <?php 
          if (is_single()) {
            set_post_views(get_the_ID());
          }
          ?>

          <article class="single-blog__article blog-article">
            <header class="blog-article__header">
              <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="blog-article__date">
                <?php echo get_the_date('Y.m.d'); ?>
              </time>
              <h2 class="blog-article__title"><?php the_title(); ?></h2>
            </header>

            <div class="blog-article__content">
              <?php if (has_post_thumbnail()) : ?>
                <figure class="blog-article__figure">
                  <?php the_post_thumbnail('large'); ?>
                </figure>
              <?php endif; ?>
              <div class="blog-article__text">
                <?php the_content(); ?>
              </div>
            </div>
          </article>
        <?php endwhile; endif; ?>

        <!-- ページネーション -->
        <nav class="single-blog__pagination pagination pagination--simple">
          <div class="pagination__prev">
            <?php previous_post_link('%link', '前へ'); ?>
          </div>
          <div class="pagination__next">
            <?php next_post_link('%link', '次へ'); ?>
          </div>
        </nav>
      </div>

      <!-- サイドバー -->
      <?php get_sidebar(); ?>

    </div>
  </div>
</div>

<?php get_footer(); ?>
