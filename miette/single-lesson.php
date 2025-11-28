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
        $lesson_details = get_field('lesson_details', get_the_ID());

        $lesson_schedule = $lesson_details['lesson_schedule'] ?? '';
        $lesson_duration = $lesson_details['lesson_duration'] ?? '';
        $lesson_price    = $lesson_details['lesson_price'] ?? '';
        $lesson_capacity = $lesson_details['lesson_capacity'] ?? '';
        $lesson_items    = $lesson_details['lesson_items'] ?? '';
      ?>

        <article class="lesson-single__article lesson-article">
          <header class="lesson-article__header">
            <div class="lesson-article__meta">
              <p class="lesson-article__month"><?php echo esc_html($month); ?>月　</p>
              <p class="lesson-article__category"><?php echo esc_html($term_name); ?></p>
            </div>
            <h2 class="lesson-article__title"><?php the_title(); ?></h2>
          </header>
          <div class="lesson-article__body">
            <div class="lesson-article__image">
              <?php if ($image): ?>
                <?php echo wp_get_attachment_image($image, 'large', false, ['alt' => '']); ?>
              <?php else: ?>
                <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
              <?php endif; ?>
            </div>
            <p class="lesson-article__text"><?php echo nl2br(esc_html($text)); ?></p>
            <table class="lesson-article__details table">
              <tbody>
                <tr>
                  <th scope="row">開催日</th>
                  <td><?php echo nl2br( wp_kses( $lesson_schedule, array() ) ); ?></td>
                </tr>
                <tr>
                  <th scope="row">所要時間</th>
                  <td><?php echo esc_html($lesson_duration); ?></td>
                </tr>
                <tr>
                  <th scope="row">料金</th>
                  <td><?php echo nl2br( wp_kses( $lesson_price, array() ) ); ?></td>
                </tr>
                <tr>
                  <th scope="row">定員</th>
                  <td><?php echo esc_html($lesson_duration); ?></td>
                </tr>
                <tr>
                  <th scope="row">持ち物</th>
                  <td><?php echo nl2br( wp_kses( $lesson_items, array() ) ); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </article>

        <!-- 予約ボタン -->
        <div class="lesson-single__button">
          <a href="<?php echo $reservation; ?>" class="button button--green">
            ご予約はこちら
            <span></span>
          </a>
        </div>

      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
