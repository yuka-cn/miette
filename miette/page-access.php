<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<?php $access_items = SCF::get('access'); ?>

<div class="access access-layout">
  <div class="access__body">
    <div class="access__inner inner">
      <?php if (empty($access_items)): ?>
        <p class="access__no-data no-data">
          ただいま準備中です。<br>公開までしばらくお待ちください。
        </p>
      <?php else: ?>
        <div class="access__items">
          <div class="access__info">
            <table class="access__table table">
              <tbody>
                <?php foreach ($access_items as $item): ?>
                  <tr>
                    <th scope="row"><?php echo esc_html($item['access_label']); ?></th>
                    <td><?php echo nl2br(esc_html($item['access_value'])); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="access__map">

          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
