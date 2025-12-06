<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<div class="lesson-guide lesson-guide-layout">
  <div class="lesson-guide__body tab">
    <div class="tab__inner inner">
      <!-- tabボタン -->
      <div class="tab__buttons tab-buttons">
        <button class="tab-buttons__item tab-button is-active" type="button" data-target="#tab-basic">
          ベーシック<br>クラス
        </button>
        <button class="tab-buttons__item tab-button" type="button" data-target="#tab-seasonal">
          季節のおやつ<br>クラス
        </button>
        <button class="tab-buttons__item tab-button" type="button" data-target="#tab-parent-child">
          親子<br>クラス
        </button>
      </div>

      <!-- tabパネル -->
      <?php
      $classes = [
          'basic'        => get_field('basic_class'),
          'seasonal'     => get_field('seasonal_class'),
          'parent-child' => get_field('parent_child_class'),
      ];

      $labels = [
          'frequency'  => '開催頻度',
          'duration'   => '所要時間',
          'price'      => '料金',
          'capacity'   => '定員',
          'items'      => '持ち物',
      ];
      ?>

      <div class="tab__panels tab-panels">
        <?php foreach ($classes as $key => $data): ?>
          <?php if ($data): ?>
            <div class="tab-panels__item tab-panel<?php echo $key === 'basic' ? ' is-active' : ''; ?>" id="tab-<?php echo esc_attr($key); ?>">
              <div class="tab-panel__body">
                <div class="tab-panel__image">
                  <?php if (!empty($data['image'])): ?>
                    <img src="<?php echo esc_url($data['image']['url']); ?>" alt="">
                  <?php endif; ?>
                </div>
                <div class="tab-panel__info">
                  <?php if (!empty($data['text'])): ?>
                    <p class="tab-panel__text">
                      <?php echo nl2br(esc_html($data['text'])); ?>
                    </p>
                  <?php endif; ?>
                  <table class="tab-panel__table table">
                    <tbody>
                      <?php foreach ($labels as $field => $label): ?>
                        <?php if (!empty($data[$field])): ?>
                          <tr>
                            <th scope="row"><?php echo esc_html($label); ?></th>
                            <td><?php echo nl2br(esc_html($data[$field])); ?></td>
                          </tr>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>                        
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  
  <!-- レッスンメニューボタン -->
  <div class="lesson-guide__button">
    <a href="<?php echo $lesson; ?>" class="button">
      今月のお菓子と日程を見る
      <span></span>
    </a>
  </div>
  
  <!-- ギャラリー -->
  <?php
  $gallery = array_filter(SCF::get('gallery'), function($item){
    return !empty($item['image']);
  });
  ?>

  <div class="lesson-guide__gallery gallery">
    <div class="gallery__inner inner">
      <h2 class="gallery__header section-header js-fadeIn">
        <span class="section-header__ja">ギャラリー</span>
        <span class="section-header__en">gallery</span>
      </h2>
      <div class="gallery__body js-fadeIn">
        <?php if (empty($gallery)): ?>
          <p class="gallery__no-post no-post">ただいま準備中です。<br>掲載までしばらくお待ちください。</p>
        <?php else: ?>
          <div class="gallery__items">
            <?php foreach ($gallery as $item): ?>
              <button class="gallery__item" type="button">
                <?php
                  echo wp_get_attachment_image(
                    $item['image'],
                    'large',
                    false,
                    ['alt' => esc_attr($item['alt'] ?? '')]
                  );
                ?>
              </button>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- モーダル -->
<div id="modal" class="modal" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="modal__overlay"></div>
  <div class="modal__content"></div>
</div>

<?php get_footer(); ?>
