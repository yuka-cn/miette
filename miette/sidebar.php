<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<aside class="page-blog__sidebar sidebar">

  <!-- 人気記事 -->
  <section class="sidebar__box sidebar-box">
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
          <div class="sidebar-box__popular-list popular-list">
            <?php while($popular->have_posts()): $popular->the_post(); ?>
              <a href="<?php the_permalink(); ?>" class="popular-list__item">
                <div class="popular-list__image">
                  <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('medium'); ?>
                  <?php else: ?>
                    <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
                  <?php endif; ?>
                </div>
                <div class="popular-list__body">
                  <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="popular-list__date">
                    <?php echo get_the_date('Y.m.d'); ?>
                  </time>
                  <p class="popular-list__title"><?php the_title(); ?></p>
                </div>
                <span class="popular-list__mask"></span>
              </a>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
  </section>

  <!-- 口コミ -->
  <section class="sidebar__box sidebar-box">
    <h2 class="sidebar-box__heading">
      <span class="sidebar-box__icon"></span>
      <span class="sidebar-box__title">口コミ</span>
    </h2>
    <div class="sidebar-box__body">
      <?php
        $voice_query = new WP_Query(array(
          'posts_per_page' => 1,
          'post_type'      => 'voice',
          'orderby'        => 'date',
          'order'          => 'DESC'
        ));
        if(!$voice_query->have_posts()): ?>
          <p class="sidebar-box__no-post no-post">現在、投稿はありません。</p>
        <?php else: ?>
          <?php while($voice_query->have_posts()): $voice_query->the_post();
            $voice_img = get_post_meta(get_the_ID(), 'voice_image', true);
            $voice_demographic = get_post_meta(get_the_ID(), 'voice_demographic', true);
          ?>
          <div class="sidebar-box__voice-card voice-card-simple">
            <div class="voice-card-simple__image">
              <?php if ($voice_img): ?>
                <?php echo wp_get_attachment_image($voice_img, 'medium', false, ['alt' => '']); ?>
              <?php else: ?>
                <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-user.jpg'); ?>" alt="">
              <?php endif; ?>
            </div>
            <p class="voice-card-simple__demographic"><?php echo esc_html($voice_demographic); ?></p>
            <p class="voice-card-simple__title"><?php the_title(); ?></p>
          </div>
          <div class="sidebar-box__button">
            <a href="<?php echo $voice; ?>" class="button">
              View more
              <span></span>
            </a>
          </div>
          <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
  </section>

  <!-- キャンペーン -->
  <section class="sidebar__box sidebar-box">
    <h2 class="sidebar-box__heading">
      <span class="sidebar-box__icon"></span>
      <span class="sidebar-box__title">キャンペーン</span>
    </h2>
    <div class="sidebar-box__body">
      <?php
        $campaign_query = new WP_Query(array(
          'posts_per_page' => 2,
          'post_type'      => 'campaign',
          'orderby'        => 'date',
          'order'          => 'DESC'
        ));
        if(!$campaign_query->have_posts()): ?>
          <p class="sidebar-box__no-post no-post">実施中のキャンペーンはありません。</p>
        <?php else: ?>
          <?php while($campaign_query->have_posts()): $campaign_query->the_post();
            $campaign_img = get_post_meta(get_the_ID(), 'campaign_image', true);
            $campaign_note = get_post_meta(get_the_ID(), 'campaign_note', true);
            $campaign_selling = get_post_meta(get_the_ID(), 'campaign_price_selling', true);
            $campaign_special = get_post_meta(get_the_ID(), 'campaign_price_special', true);
          ?>
          <div class="sidebar-box__campaign-card campaign-card">
            <div class="campaign-card__image campaign-card__image--side">
              <?php if ($campaign_img): ?>
                <?php echo wp_get_attachment_image($campaign_img, 'medium', false, ['alt' => '']); ?>
              <?php else: ?>
                <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
              <?php endif; ?>
            </div>
            <div class="campaign-card__body campaign-card__body--side">
              <p class="campaign-card__title campaign-card__title--side"><?php the_title(); ?></p>
              <p class="campaign-card__note campaign-card__note--side"><?php echo esc_html($campaign_note); ?></p>
              <div class="campaign-card__price campaign-card__price--side">
                <p class="campaign-card__selling campaign-card__selling--side"><?php echo esc_html($campaign_selling); ?></p>
                <p class="campaign-card__special campaign-card__special--side"><?php echo esc_html($campaign_special); ?></p>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
          <div class="sidebar-box__button">
            <a href="<?php echo $campaign ;?>" class="button">
              View more
              <span></span>
            </a>
          </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
  </section>

  <!-- アーカイブ -->
  <section class="sidebar__box sidebar-box">
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
