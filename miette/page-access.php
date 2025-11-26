<?php get_header(); ?>
<!-- ページコンテンツ -->

<?php $access_items = SCF::get('access'); ?>

<?php if (empty($access_items)): ?>
  <p class="access__no-data no-data">
    ただいま準備中です。<br>公開までしばらくお待ちください。
  </p>
<?php else: ?>
  <table class="table">
    <tbody>
      <?php foreach ($access_items as $item): ?>
        <tr>
          <th scope="row"><?php echo esc_html($item['access_label']); ?></th>
          <td><?php echo nl2br(esc_html($item['access_value'])); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<?php get_footer(); ?>
