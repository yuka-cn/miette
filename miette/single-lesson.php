<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<div class="lesson-single lesson-single-layout">
  <div class="lesson-single__content">
    <div class="lesson-single__inner inner">
      <div class="lesson-single__body">

      <?php the_post(); ?>

      <?php
        $terms = get_the_terms(get_the_ID(), 'lesson_category');
        $term_name = '';

        if ($terms && !is_wp_error($terms)) {
            $term = $terms[0];
            $term_name = $term->name;
        }

        $image = get_field('lesson_image');
        $month = get_field('lesson_month');
        $text  = get_field('lesson_text');
        $lesson_details = get_field('lesson_details', $post_id);

        $lesson_schedule = $lesson_details['lesson_schedule'] ?? '';
        $lesson_duration = $lesson_details['lesson_duration'] ?? '';
        $lesson_price    = $lesson_details['lesson_price'] ?? '';
        $lesson_capacity = $lesson_details['lesson_capacity'] ?? '';
        $lesson_items    = $lesson_details['lesson_items'] ?? '';
      ?>

          <article class="lesson-single__article lesson-article">
            <header class="lesson-article__header">
              <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="lesson-article__date">
                <?php echo get_the_date('Y.m.d'); ?>
              </time>
              <h2 class="lesson-article__title"><?php the_title(); ?></h2>
            </header>

            <div class="lesson-article__content">
              <?php if (has_post_thumbnail()) : ?>
                <figure class="lesson-article__figure">
                  <?php the_post_thumbnail('large'); ?>
                </figure>
              <?php endif; ?>
              <div class="lesson-article__text">
                <?php the_content(); ?>
              </div>
            </div>
          </article>

        <!-- ページネーション -->
        <nav class="lesson-single__pagination pagination pagination--simple">
          <div class="pagination__prev">
            <?php previous_post_link('%link', '前へ'); ?>
          </div>
          <div class="pagination__next">
            <?php next_post_link('%link', '次へ'); ?>
          </div>
        </nav>
      </div>

    </div>
  </div>
</div>

<?php get_footer(); ?>
