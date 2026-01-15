<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<div id="loading" class="loading">
  <div class="loading__logo">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/miette-color.png" alt="miette">
  </div>
</div>

<main>
  <!-- ファーストビュー -->
  <section class="mv">
    <div class="mv__logo">
      <img src="<?php echo get_theme_file_uri('/assets/images/common/miette-color.png'); ?>" alt="やさしいおやつ教室Miette">
    </div>
    <picture class="mv__image" style="grid-area: image;">
      <source srcset="<?php echo get_theme_file_uri('/assets/images/common/mv_pc.png'); ?>" media="(min-width: 768px)">
      <img src="<?php echo get_theme_file_uri('/assets/images/common/mv_pc.png'); ?>" alt="">
    </picture>
    <div class="mv__inner inner" style="grid-area: title;">
      <h1 class="mv__title">
        <span>やさしいおやつと</span>
        <span>小さなしあわせを</span>
      </h1>
    </div>
  </section>

  <!-- レッスンメニュー -->
  <?php
    $args = array(
      'post_type'      => 'lesson',
      'posts_per_page' => -1,
    );
    $lessons = new WP_Query($args);
  if ($lessons->have_posts()): ?>
  <section class="home-lesson home-lesson-layout">
    <div class="home-lesson__inner inner">
      <hgroup class="home-lesson__header section-header js-fadeIn">
        <h2 class="section-header__ja">レッスンメニュー</h2>
        <p class="section-header__en">Monthly Menu</p>
      </hgroup>
      <div class="home-lesson__body js-fadeIn">
        <div class="home-lesson__cards swiper js-lessonSwiper">
          <div class="home-lesson__flex swiper-wrapper">
            <?php while ($lessons->have_posts()): $lessons->the_post();
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
              <div class="home-lesson__slide swiper-slide">
                <a href="<?php the_permalink(); ?>" class="home-lesson__card lesson-card">
                  <div class="lesson-card__badge">
                    <p class="lesson-card__month"><?php echo esc_html($month); ?>月</p>
                  </div>
                  <div class="lesson-card__image">
                    <?php if ($image): ?>
                      <?php echo wp_get_attachment_image($image, 'large', false, ['alt' => '']); ?>
                    <?php else: ?>
                      <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-default.jpg'); ?>" alt="">
                    <?php endif; ?>
                  </div>
                  <div class="lesson-card__body">
                    <p class="lesson-card__category"><?php echo esc_html($term_name); ?></p>
                    <h3 class="lesson-card__title"><?php the_title(); ?></h3>
                    <p class="lesson-card__schedule"><?php echo nl2br( wp_kses( $lesson_schedule, array() ) ); ?></p>
                  </div>
                </a>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
        <div class="home-lesson__buttons">
          <button class="home-lesson__button-prev swiper-button-prev"></button>
          <button class="home-lesson__button-next swiper-button-next"></button>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>
  <?php wp_reset_postdata();?>

  <!-- コンセプト -->
  <div class="home-concept home-concept-layout">
    <div class="home-concept__content">
      <div class="home-concept__image js-fadeIn"></div>
      <div class="home-concept__inner inner js-fadeIn">
        <p class="home-concept__text">
          特別な日じゃなくても<br>
          焼きたての甘い香りがあるだけで<br>
          ふと心がやわらぐ <br>
          <br>
          毎日の暮らしに寄り添う<br>
          やさしいおやつづくりを<br>
        </p>
        <div class="home-concept__button">
          <a href="<?php echo $about; ?>" class="button">
            もっと知る
            <span></span>
          </a>
        </div>
      </div>
    </div>
    <div class="home-concept__divider divider divider--a divider--bottom"></div>
  </div>

  <!-- レッスン案内 -->
  <section class="home-lesson-guide">
    <div class="home-lesson-guide__inner inner js-fadeIn">
      <hgroup class="home-lesson-guide__header section-header">
        <h2 class="">レッスン案内</h2>
        <p class="section-header__en">lesson</p>
      </hgroup>
      <p class="home-lesson-guide__text">
        家庭でも作りやすい人気のおやつを中心に、<span>基本の技術や材料選びを丁寧に学べる「ベーシッククラス」</span>と、旬の素材や行事に合わせた<span>季節感あふれるメニューに挑戦する「季節のおやつクラス」</span>、そして<span>小さなお子さまと一緒に</span>“作る楽しさ”を感じていただける<span>「親子クラス」</span>の3つをご用意しています。<br>
        それぞれのクラスで、出来たてのおいしさと手作りならではの温かみを楽しんでいただけます。
      </p>
      <div class="home-lesson-guide__button">
        <a href="<?php echo $lesson_guide; ?>" class="button button--outline">
          もっと見る
          <span></span>
        </a>
      </div>
    </div>
  </section>

  <!-- ブログ -->
  <?php
  $args = array(
    'post_type'      => 'post',
    'posts_per_page' => 2,
  );
  $posts = new WP_Query($args);
  $has_blog = $posts->have_posts();
  if ($has_blog): 
  ?>
  <section class="home-blog">
    <div class="home-blog__inner inner">
      <div class="home-blog__intro js-fadeIn">
        <hgroup class="home-blog__header section-header">
          <h2 class="section-header__ja">ブログ</h2>
          <p class="section-header__en">blog</p>
        </hgroup>
        <p class="home-blog__text">
        教室での様子やアレンジアイデア、素材や道具の話、教室からのお知らせなどをお届けします。
        </p>
      </div>
      <div class="home-blog__cards">
        <?php while ($posts->have_posts()): $posts->the_post();?>
          <article class="home-blog__card blog-card js-fadeIn">
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
                <h3 class="blog-card__title"><?php the_title(); ?></h3>
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
      <div class="home-blog__button js-fadeIn">
        <a href="<?php echo $blog; ?>" class="button">
          もっと見る
          <span></span>
        </a>
      </div>
    </div>
    <div class="home-concept__divider divider divider--b divider--bottom"></div>
  </section>
  <?php endif; ?>
  <?php wp_reset_postdata();?>

  <!-- 予約 -->
  <section class="home-reservation">
    <div class="home-reservation__inner inner">
      <div class="home-reservation__content js-fadeIn">
        <hgroup class="home-reservation__header section-header">
          <h2 class="section-header__ja">ご予約方法</h2>
          <p class="section-header__en">reservation</p>
        </hgroup>
        <p class="home-reservation__text">
          毎月20日頃に、翌月のメニューと開催日程を当ホームページとインスタグラムでお知らせしています。<br>
          ご興味のあるレッスンがありましたら、当ホームページの予約フォームよりお申し込みください。<br>
          定員になり次第締め切りとなります。
        </p>
        <div class="home-reservation__button">
          <a href="<?php echo $reservation; ?>" class="button button--green button--outline">
            ご予約はこちら
            <span></span>
          </a>
        </div>
      </div>
      <div class="home-reservation__image js-fadeIn">
        <img src="<?php echo get_theme_file_uri('/assets/images/common/reservation_1.png'); ?>" alt="">
      </div>
    </div>

  </section>

<?php get_footer(); ?>