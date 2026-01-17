<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<div class="lesson lesson-layout">
  <div class="lesson__body">
    <div class="lesson__inner inner">
      
      <!-- カテゴリーボタン -->
      <?php if (!have_posts()): ?>
        <p class="lesson__no-post no-post">
          ただいま準備中です。<br>掲載までしばらくお待ちください。
        </p>

      <?php else: ?>
        <div class="lesson__category-buttons category-buttons" id="category-top">
          <a
            class="category-buttons__item category-button <?php if (!is_tax()) echo 'is-active'; ?>" 
            href="<?php echo $lesson; ?>"
          >
            すべてのクラス
          </a>

          <?php
            $taxonomy = 'lesson_category';
            $terms = get_terms([
              'taxonomy'   => $taxonomy,
              'hide_empty' => true,
              'orderby'    => 'id',
            ]);

            if ($terms && !is_wp_error($terms)):
              foreach ($terms as $term):
          ?>
              <a 
                class="category-buttons__item category-button <?php if (is_tax($taxonomy, $term->slug)) echo 'is-active'; ?>" 
                href="<?php echo esc_url(get_term_link($term)); ?>"
              >
                <?php echo esc_html($term->name); ?>
              </a>
          <?php endforeach; endif; ?>
        </div>

        <!-- lessonカード -->
        <div class="lesson__cards lesson-cards">
          <?php while (have_posts()): the_post(); ?>
            <?php
              $terms = get_the_terms(get_the_ID(), 'lesson_category');
              $term_name = '';

              if ($terms && !is_wp_error($terms)) {
                  $term = $terms[0];
                  $term_name = $term->name;
              }

              $image = get_field('lesson_image');
              $month = get_field('lesson_month');

              $lesson_details = get_field('lesson_details');
              $lesson_schedule = $lesson_details['lesson_schedule'] ?? '';
            ?>

            <a href="<?php the_permalink(); ?>" class="lesson-cards__item lesson-card js-fadeIn">
              <div class="lesson-card__badge">
                <p class="lesson-card__month"><?php echo esc_html($month); ?>月</p>
              </div>
              <div class="lesson-card__image">
                <?php if ($image): ?>
                  <?php echo wp_get_attachment_image($image, 'medium', false, ['alt' => '' ,'sizes' => '(min-width: 1440px) 306px, 100vw']); ?>
                <?php else: ?>
                  <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
                <?php endif; ?>
              </div>
              <div class="lesson-card__body">
                <p class="lesson-card__category"><?php echo esc_html($term_name); ?></p>
                <h2 class="lesson-card__title"><?php the_title(); ?></h2>
              </div>
              <span class="lesson-card__mask"></span>
            </a>

          <?php endwhile; ?>

        </div>

        <!-- ページネーション -->
        <nav class="lesson__pagination pagination">
          <?php wp_pagenavi(); ?>
        </nav>

      <?php endif; ?>

    </div>
  </div>
</div>

<?php get_footer(); ?>

