<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<?php
$faqs = array_filter(SCF::get('faq'), function($faq){
  return !empty($faq['question']) && !empty($faq['answer']);
});
?>

<div class="faq faq-layout">
  <div class="faq__body">
    <div class="faq__inner inner">
      <?php if (empty($faqs)): ?>
        <p class="faq__no-post no-post">ただいま準備中です。<br>公開までしばらくお待ちください。</p>
      <?php else: ?>
        <div class="faq__items">
          <?php foreach ($faqs as $faq): ?>
            <details class="faq__item faq-item js-fadeIn" open>
              <summary><?php echo esc_html($faq['question']); ?></summary>
              <p><?php echo nl2br(esc_html($faq['answer'])); ?></p>
            </details>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>  
  
  <!-- レッスンメニューボタン -->
  <div class="faq__button">
    <a href="<?php echo $lesson; ?>" class="button">
      今月のお菓子と日程を見る
      <span></span>
    </a>
  </div>
</div>

<?php get_footer(); ?>
