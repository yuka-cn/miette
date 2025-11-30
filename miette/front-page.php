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
  <?php
    $args = array(
      'post_type'      => 'lesson',
      'posts_per_page' => -1,
    );
    $lessons = new WP_Query($args);
  if ($lessons->have_posts()): ?>
  <section class="home-lesson home-lesson-layout">
    <div class="home-lesson__inner inner">
      <h2 class="home-lesson__header section-header">
        <span class="section-header__ja">レッスンメニュー</span>
        <span class="section-header__en">Monthly Menu</span>
      </h2>
      <div class="home-lesson__body">
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
            ?>
              <div class="home-lesson__slide swiper-slide">
                <a href="<?php the_permalink(); ?>" class="lesson-cards__item lesson-card">
                  <div class="lesson-card__badge">
                    <p class="lesson-card__month"><?php echo esc_html($month); ?>月</p>
                  </div>
                  <div class="lesson-card__image">
                    <?php if ($image): ?>
                      <?php echo wp_get_attachment_image($image, 'medium', false, ['alt' => '']); ?>
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
  <section class="home-concept home-concept-layout">
    <div class="home-concept__inner inner">
      <p class="home-concept__text">
        特別な日じゃなくても<br>
        焼きたての甘い香りがあるだけで<br>
        ふと心がやわらぐ <br>  
        <br>         
        毎日の暮らしに寄り添う<br>
        やさしいお菓子づくりを<br>
      </p>
      <div class="home-concept__button">
        <a href="<?php echo $about; ?>" class="button">
          もっと知る
          <span></span>
        </a>
      </div>
    </div>
    <div class="home-concept__divider divider divider--a divider--bottom"></div>
  </section>

  <!-- レッスン案内 -->
  <section class="home-lesson-guide">
    <div class="home-lesson-guide__inner inner">
      <h2 class="home-lesson-guide__header section-header">
        <span class="section-header__ja">レッスン案内</span>
        <span class="section-header__en">lesson</span>
      </h2>
      <p class="home-lesson-guide__text">
        家庭でも作りやすい人気のおやつを中心に、基本の技術や材料選びを丁寧に学べる「ベーシッククラス」と、旬の素材や行事に合わせた季節感あふれるメニューに挑戦する「季節のおやつクラス」、そして小さなお子さまと一緒に“作る楽しさ”を感じていただける「親子クラス」の3つをご用意しています。それぞれのクラスで、出来たてのおいしさと手作りならではの温かみを楽しんでいただけます。
      </p>
      <div class="home-lesson-guide__button">
        <a href="<?php echo $lesson_guide; ?>" class="button">
          もっと見る
          <span></span>
        </a>
      </div>
    </div>
  </section>

  <!-- ブログ -->

  <!-- 予約 -->

  <!-- ボタン -->
  <div class="lesson__button">
    <a href="<?php echo $lesson; ?>" class="button">
      もっと知る
      <span></span>
    </a>
  </div>



<?php get_footer(); ?>