<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<div class="page-voice page-voice-layout">
  <div class="page-voice__body">
    <div class="page-voice__inner inner">

      <!-- カテゴリーボタン -->
      <?php if (!have_posts()): ?>
        <p class="page-voice__no-post no-post">
          ただいま準備中です。<br>掲載までしばらくお待ちください。
        </p>

      <?php else: ?>
        <div class="page-voice__category-buttons category-buttons" id="category-top">
          <a 
            class="category-buttons__item category-button <?php if (!is_tax()) echo 'is-active'; ?>" 
            href="<?php echo $voice; ?>#category-top"
          >
            ALL
          </a>

          <?php
            $taxonomy = 'voice_category';
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
              href="<?php echo esc_url(get_term_link($term)); ?>#category-top"
            >
              <?php echo esc_html($term->name); ?>
            </a>
          <?php endforeach; endif; ?>
        </div>

        <!-- voiceカード -->
        <div class="page-voice__cards voice-cards">

          <?php while (have_posts()): the_post(); ?>

            <?php
              $terms = get_the_terms(get_the_ID(), 'voice_category');
              $term_name = '';

              if ($terms && !is_wp_error($terms)) {
                  $term = $terms[0];
                  $term_name = $term->name;
              }

              $demographic = get_field('voice_demographic');
              $image       = get_field('voice_image');
              $text        = get_field('voice_text');
            ?>

            <div class="voice-cards__item voice-card voice-card--page-voice" data-category="license">
              <div class="voice-card__header">
                <div class="voice-card__text-block">
                  <div class="voice-card__meta">
                    <p class="voice-card__demographic"><?php echo esc_html($demographic); ?></p>
                    <p class="voice-card__category"><?php echo esc_html($term_name); ?></p>
                  </div>
                  <h2 class="voice-card__title"><?php the_title(); ?></h2>
                </div>

                <div class="voice-card__image">
                  <?php if ($image): ?>
                    <?php echo wp_get_attachment_image($image, 'medium', false, ['alt' => '']); ?>
                  <?php else: ?>
                    <img src="<?php echo get_theme_file_uri('/assets/images/common/placeholder-user.jpg'); ?>" alt="">
                  <?php endif; ?>
                </div>
              </div>

              <p class="voice-card__text">
                <?php echo nl2br(esc_html($text)); ?>
              </p>
            </div>

          <?php endwhile; ?>

        </div>
        
        <!-- ページネーション -->
        <nav class="page-voice__pagination pagination">
          <?php wp_pagenavi(); ?>
        </nav>

      <?php endif; ?>

    </div>
  </div>
</div>

<?php get_footer(); ?>
