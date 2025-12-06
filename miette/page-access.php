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
            <table class="access__table table js-fadeIn">
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
          <div class="access__map js-fadeIn">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1598.2951356484914!2d135.2753647600661!3d34.72787769574199!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60008ce6a697d81b%3A0x61f87321a6b51e2a!2z44CSNjU4LTAwNzIg5YW15bqr55yM56We5oi45biC5p2x54GY5Yy65bKh5pys77yR5LiB55uu!5e0!3m2!1sja!2sjp!4v1764437819889!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      <?php endif; ?> 
    </div>
  </div>
  
  <!-- レッスンメニューボタン -->
  <div class="access__button js-fadeIn">
    <a href="<?php echo $lesson; ?>" class="button">
      今月のお菓子と日程を見る
      <span></span>
    </a>
  </div>
</div>

<?php get_footer(); ?>
