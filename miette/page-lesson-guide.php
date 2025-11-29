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
</div>

<!-- レッスンメニューボタン -->
<div class="lesson-guide__button">
  <a href="<?php echo $lesson; ?>" class="button">
    今月のお菓子と日程を見る
    <span></span>
  </a>
</div>

<?php get_footer(); ?>
