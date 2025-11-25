<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<div class="page-blog page-blog-layout">
  <div class="page-blog__content">
    <div class="page-blog__inner inner">
      <div class="page-blog__body">
        <?php if (!have_posts()): ?>
          <p class="page-blog__no-post no-post">現在、投稿はありません。</p>
        <?php else: ?>
          <div class="page-blog__cards blog-cards">
            <?php while (have_posts()): the_post(); ?>
              <article class="blog-cards__item blog-card">
                <a href="<?php the_permalink(); ?>">
                  <div class="blog-card__body">
                    <div class="blog-card__meta">
                      <p class="blog-card__category">
                        <?php
                          $categories = get_the_category();
                          if (!empty($categories)) {
                            echo esc_html($categories[0]->name);
                          }
                        ?>
                      </p>
                      <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="blog-card__date">
                        <?php echo get_the_date('Y.m.d'); ?>
                      </time>
                    </div>
                    <h2 class="blog-card__title"><?php the_title(); ?></h2>
                    <p class="blog-card__text">
                      <?php
                        if (has_excerpt()) {
                          $excerpt = get_the_excerpt();
                          $excerpt = mb_strimwidth($excerpt, 0, 122, '...', 'UTF-8');
                          echo nl2br(esc_html($excerpt));
                        } else {
                          $excerpt = wp_strip_all_tags(get_the_content());
                          $excerpt = mb_strimwidth($excerpt, 0, 122, '...', 'UTF-8');
                          echo esc_html($excerpt);
                        }
                      ?>
                    </p>
                  </div>
                  <div class="blog-card__image">
                    <?php if (has_post_thumbnail()): ?>
                      <?php the_post_thumbnail('medium'); ?>
                    <?php else: ?>
                      <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
                    <?php endif; ?>
                  </div>
                </a>
              </article>
            <?php endwhile; ?>
          </div>

          <!-- ページネーション -->
          <nav class="page-blog__pagination pagination">
            <?php wp_pagenavi(); ?>
          </nav>
        <?php endif; ?>
      </div>

      <!-- サイドバー -->
      <?php get_sidebar(); ?>

    </div>
  </div>
</div>

<?php get_footer(); ?>
