<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<main>
  <!-- ファーストビュー -->
  <section class="mv">
   
  </section>

  <!-- レッスンメニュー -->

  <!-- コンセプト -->

  <!-- レッスン案内 -->

  <!-- ブログ -->

  <!-- 予約 -->

  <!-- ボタン -->
  <div class="lesson__button">
    <a href="<?php echo $lesson; ?>" class="button">
      もっと知る
      <span></span>
    </a>
  </div>

  <?php
    $args = array(
      'post_type'      => 'campaign',
      'posts_per_page' => -1,
    );
    $campaigns = new WP_Query($args);
  if ($campaigns->have_posts()): ?>
  <section class="campaign campaign-layout">
    <div class="campaign__inner inner">
      <div class="campaign__header section-header">
        <p class="section-header__entitle">Campaign</p>
        <h2 class="section-header__jatitle">キャンペーン</h2>
      </div>
      <div class="campaign__body">
        <div class="campaign__cards swiper js-campaignSwiper">
          <div class="campaign__flex swiper-wrapper">
            <?php while ($campaigns->have_posts()): $campaigns->the_post();
              $terms = get_the_terms(get_the_ID(), 'campaign_category');
              $term_name = '';
              if ($terms && !is_wp_error($terms)) {
                $term_name = $terms[0]->name;
              }
              $image = get_field('campaign_image');
              $note = get_field('campaign_note');
              $selling = get_field('campaign_price_selling');
              $special = get_field('campaign_price_special');
            ?>
            <div class="campaign__slide swiper-slide">
              <div class="campaign__card campaign-card">
                <div class="campaign-card__image">
                  <?php if ($image) : ?>
                    <?php echo wp_get_attachment_image($image, 'medium', false, ['alt' => '']); ?>
                  <?php else: ?>
                    <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
                  <?php endif; ?>
                </div>
                <div class="campaign-card__body">
                  <p class="campaign-card__category"><?php echo esc_html($term_name); ?></p>
                  <p class="campaign-card__title"><?php the_title(); ?></p>
                  <p class="campaign-card__note"><?php echo esc_html($note); ?></p>
                  <div class="campaign-card__price">
                    <p class="campaign-card__selling"><?php echo esc_html($selling); ?></p>
                    <p class="campaign-card__special"><?php echo esc_html($special); ?></p>
                  </div>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
      <button class="campaign__swiper-button-prev swiper-button-prev">
        <img src="<?php echo get_theme_file_uri('/assets/images/common/prev.png'); ?>" alt="前へ">
      </button>
      <button class="campaign__swiper-button-next swiper-button-next">
        <img src="<?php echo get_theme_file_uri('/assets/images/common/next.png'); ?>" alt="次へ">
      </button>
      <div class="campaign__button">
        <a href="<?php echo $campaign; ?>" class="button">
          View more
          <span></span>
        </a>
      </div>
    </div>
  </section>
  <?php endif; ?>
  <?php wp_reset_postdata();?>

  <!-- blogセクション -->
  <?php
  $args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
  );
  $posts = new WP_Query($args);
  $has_blog = $posts->have_posts();
  if ($has_blog): 
  ?>
  <section class="blog blog-layout">
    <div class="blog__inner inner">
      <div class="blog__header section-header">
        <p class="section-header__entitle section-header__entitle--white">Blog</p>
        <h2 class="section-header__jatitle section-header__jatitle--white">ブログ</h2>
      </div>
      <div class="blog__cards blog-cards">
        <?php while ($posts->have_posts()): $posts->the_post();?>
        <article class="blog-cards__item blog-card">
          <a href="<?php the_permalink(); ?>">
            <div class="blog-card__image">
              <?php if ( has_post_thumbnail() ): ?>
                <?php the_post_thumbnail('medium'); ?>
              <?php else: ?>
                <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
              <?php endif; ?>
            </div>
            <div class="blog-card__body">
              <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="blog-card__date">
                <?php echo get_the_date('Y.m.d'); ?>
              </time>
              <h3 class="blog-card__title"><?php the_title(); ?></h3>
              <p class="blog-card__text">
                <?php
                if ( has_excerpt() ) {
                  $excerpt = get_the_excerpt();
                  $excerpt = mb_strimwidth( $excerpt, 0, 172, '', 'UTF-8' );
                  echo nl2br( esc_html( $excerpt ) );
                } else {
                  $excerpt = wp_strip_all_tags( get_the_content() );
                  $excerpt = mb_strimwidth( $excerpt, 0, 172, '', 'UTF-8' );
                  echo esc_html( $excerpt );
                }
                ?>
              </p>
            </div>
          </a>
        </article>
        <?php endwhile; ?>
      </div>
      <div class="blog__button">
        <a href="<?php echo $blog ;?>" class="button">
          View more
          <span></span>
        </a>
      </div>
    </div>
  </section>
  <?php endif; ?>
  <?php wp_reset_postdata();?>
  

<?php get_footer(); ?>