<?php get_header(); ?>

<!-- ページコンテンツ -->
<div class="page-about page-about-layout">
  <!-- SPレイアウト -->
  <section class="page-about__lead-sp about-lead">
    <div class="about-lead__inner inner">
      <div class="about-lead__image">
        <img src="<?php echo get_theme_file_uri('/assets/images/common/about_2.jpg'); ?>" alt="">
      </div>
      <h2 class="about-lead__title">Dive into<br>the Ocean</h2>
      <p class="about-lead__text">
        ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
        <br>
        ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
      </p>
    </div>
  </section>

  <!-- PCレイアウト -->
  <section class="page-about__lead-pc about about--page-about">
    <div class="about__inner inner">
      <div class="about__images">
        <div class="about__left-image">
          <img src="<?php echo get_theme_file_uri('/assets/images/common/about_1.jpg'); ?>" alt="">
        </div>
        <div class="about__right-image">
          <img src="<?php echo get_theme_file_uri('/assets/images/common/about_2.jpg'); ?>" alt="">
        </div>
      </div>
      <div class="about__body">
        <h2 class="about__title">Dive into<br>the Ocean</h2>
        <div class="about__content">
          <p class="about__text">
            ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
            <br>
            ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
          </p>
        </div>
      </div>
    </div>
  </section>

  <?php
  $gallery = array_filter(SCF::get('gallery'), function($item){
    return !empty($item['image']);
  });
  ?>

  <!-- Gallery -->
  <div class="page-about__gallery gallery">
    <div class="gallery__inner inner">
      <div class="gallery__header section-header">
        <p class="section-header__entitle">Gallery</p>
        <h2 class="section-header__jatitle">フォト</h2>
      </div>
      <div class="gallery__body">
        <?php if (empty($gallery)): ?>
          <p class="gallery__no-post no-post">ただいま準備中です。<br>掲載までしばらくお待ちください。</p>
        <?php else: ?>

        <?php $index = 0; ?>
        <?php foreach ($gallery as $item): ?>
          <?php
            $img = $item['image'] ?? null;
            $alt = $item['alt'] ?? '';
            if (!$img) continue;

            $slot = ($index % 6) + 1;
          ?>

          <?php if ($slot === 1): ?>
            <div class="gallery__column">
              <button class="gallery__item gallery__item--single" type="button">
                <img src="<?php echo esc_url(wp_get_attachment_url($img)); ?>" alt="<?php echo esc_attr($alt); ?>">
              </button>
          
          <?php elseif ($slot === 2): ?>
              <div class="gallery__stack">
                <button class="gallery__item gallery__item--stacked" type="button">
                  <img src="<?php echo esc_url(wp_get_attachment_url($img)); ?>" alt="<?php echo esc_attr($alt); ?>">
                </button>
          
          <?php elseif ($slot === 3): ?>
                <button class="gallery__item gallery__item--stacked" type="button">
                  <img src="<?php echo esc_url(wp_get_attachment_url($img)); ?>" alt="<?php echo esc_attr($alt); ?>">
                </button>
              </div>
            </div>
          
          <?php elseif ($slot === 4): ?>
            <div class="gallery__column gallery__column--reverse">
              <div class="gallery__stack">
                <button class="gallery__item gallery__item--stacked" type="button">
                  <img src="<?php echo esc_url(wp_get_attachment_url($img)); ?>" alt="<?php echo esc_attr($alt); ?>">
                </button>
          
          <?php elseif ($slot === 5): ?>
                <button class="gallery__item gallery__item--stacked" type="button">
                  <img src="<?php echo esc_url(wp_get_attachment_url($img)); ?>" alt="<?php echo esc_attr($alt); ?>">
                </button>
              </div>
          
          <?php elseif ($slot === 6): ?>
              <button class="gallery__item gallery__item--single" type="button">
                <img src="<?php echo esc_url(wp_get_attachment_url($img)); ?>" alt="<?php echo esc_attr($alt); ?>">
              </button>
            </div>
          <?php endif; ?>
          
          <?php $index++; ?>
        <?php endforeach; ?>

        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- モーダル -->
<div id="modal" class="modal" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="modal__overlay"></div>
  <div class="modal__background">
    <div class="modal__background-inner inner"></div>
  </div>
  <div class="modal__content"></div>
</div>

<?php get_footer(); ?>
