<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<aside class="blog__sidebar sidebar">

  <!-- レッスンメニュー -->
  <section class="sidebar__box sidebar-box js-fadeIn">
    <h2 class="sidebar-box__heading">
      <span class="sidebar-box__icon"></span>
      <span class="sidebar-box__title">レッスンメニュー</span>
    </h2>
    <div class="sidebar-box__body">
      <?php
        $lesson_query = new WP_Query(array(
          'posts_per_page' => 1,
          'post_type'      => 'lesson',
          'orderby'        => 'date',
          'order'          => 'DESC'
        ));
        if(!$lesson_query->have_posts()): ?>
          <p class="sidebar-box__no-post no-post">ただいま準備中です。</p>
        <?php else: ?>
          <?php while($lesson_query->have_posts()): $lesson_query->the_post();
            $lesson_terms = get_the_terms(get_the_ID(), 'lesson_category');
            $lesson_term_name = '';

            if ($lesson_terms && !is_wp_error($lesson_terms)) {
                $lesson_term = $lesson_terms[0];
                $lesson_term_name = $lesson_term->name;
            }

            $lesson_img = get_field('lesson_image');
            $lesson_month = get_field('lesson_month');
          ?>
          <a href="<?php the_permalink(); ?>" class="sidebar-box__lesson-card lesson-card lesson-card--sidebar">
            <div class="lesson-card__badge">
              <p class="lesson-card__month"><?php echo esc_html($lesson_month); ?>月</p>
            </div>
            <div class="lesson-card__image">
              <?php if ($lesson_img): ?>
                <?php echo wp_get_attachment_image($lesson_img, 'medium', false, ['alt' => '']); ?>
              <?php else: ?>
                <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
              <?php endif; ?>
            </div>
            <div class="lesson-card__body">
              <p class="lesson-card__category"><?php echo esc_html($lesson_term_name); ?></p>
              <p class="lesson-card__title"><?php the_title(); ?></p>
            </div>
            <span class="lesson-card__mask"></span>
          </a>
          <div class="sidebar-box__button">
            <a href="<?php echo $lesson; ?>" class="button">
              もっと見る
              <span></span>
            </a>
          </div>
          <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
  </section>

  <!-- 人気記事 -->
  <section class="sidebar__box sidebar-box js-fadeIn">
    <h2 class="sidebar-box__heading">
      <span class="sidebar-box__icon"></span>
      <span class="sidebar-box__title">人気記事</span>
    </h2>
    <div class="sidebar-box__body">
      <?php
        $popular = new WP_Query(array(
          'posts_per_page' => 3,
          'post_type'      => 'post',
          'meta_key'       => 'post_views_count',
          'orderby'        => 'meta_value_num',
          'order'          => 'DESC',
          'ignore_custom_sort' => true,
        ));
        if (!$popular->have_posts()): ?>
          <p class="sidebar-box__no-post no-post">現在、投稿はありません。</p>
        <?php else: ?>
          <div class="sidebar-box__blog-cards">
            <?php while($popular->have_posts()): $popular->the_post(); ?>
              <article class="sidebar-box__blog-card blog-card blog-card--sidebar">
                <a href="<?php the_permalink(); ?>"">
                  <div class="blog-card__body">
                    <div class="blog-card__meta">
                      <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="blog-card__date">
                        <?php echo get_the_date('Y.m.d'); ?>
                      </time>
                    </div>
                    <p class="blog-card__title"><?php the_title(); ?></p>
                  </div>
                  <div class="blog-card__image">
                    <?php if (has_post_thumbnail()): ?>
                      <?php the_post_thumbnail('medium'); ?>
                    <?php else: ?>
                      <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
                    <?php endif; ?>
                  </div>
                  <span class="blog-card__mask"></span>
                </a>
              </article>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
  </section>

  <!-- カテゴリー -->
  <section class="sidebar__box sidebar-box js-fadeIn">
    <h2 class="sidebar-box__heading">
      <span class="sidebar-box__icon"></span>
      <span class="sidebar-box__title">カテゴリー</span>
    </h2>
    <div class="sidebar-box__body">
      <?php 
        $categories = get_categories(array(
          'orderby' => 'name',
          'order'   => 'ASC',
          'hide_empty' => true
        ));
        if(!$categories): ?>
          <p class="sidebar-box__no-post no-post">現在、投稿はありません。</p>
        <?php else: ?>
          <ul class="sidebar-box__category-list">
            <?php foreach($categories as $category): ?>
              <li class="sidebar-box__category-item">
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                  <?php echo esc_html($category->name); ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
      <?php endif; ?>
    </div>
  </section>


  <!-- アーカイブ -->
  <section class="sidebar__box sidebar-box js-fadeIn">
    <h2 class="sidebar-box__heading">
      <span class="sidebar-box__icon"></span>
      <span class="sidebar-box__title">アーカイブ</span>
    </h2>
    <div class="sidebar-box__body">
      <?php
        global $wpdb;
        $years = $wpdb->get_col("
          SELECT DISTINCT YEAR(post_date) 
          FROM $wpdb->posts 
          WHERE post_status='publish' AND post_type='post' 
          ORDER BY post_date DESC
        ");
        if(!$years): ?>
          <p class="sidebar-box__no-post no-post">現在、投稿はありません。</p>
        <?php else: ?>
          <ul class="sidebar-box__archive-list archive-list">
            <?php foreach($years as $year): ?>
              <li class="archive-list__year">
                <button class="archive-list__year-button" type="button"><?php echo $year; ?></button>
                <ul class="archive-list__months">
                  <?php
                    $months = $wpdb->get_col($wpdb->prepare(
                      "SELECT DISTINCT MONTH(post_date) 
                       FROM $wpdb->posts 
                       WHERE post_status='publish' AND post_type='post' AND YEAR(post_date)=%d 
                       ORDER BY post_date DESC",
                      $year
                    ));
                    foreach($months as $month):
                      $link = get_month_link($year, $month);
                  ?>
                    <li class="archive-list__month"><a href="<?php echo esc_url($link); ?>"><?php echo $month; ?>月</a></li>
                  <?php endforeach; ?>
                </ul>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
    </div>
  </section>

</aside>
