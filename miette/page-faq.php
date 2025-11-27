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
  <div class="faq__body faq">
    <div class="faq__inner inner">
      <?php if (empty($faqs)): ?>
        <p class="faq__no-post no-post">ただいま準備中です。<br>公開までしばらくお待ちください。</p>
      <?php else: ?>
        <?php foreach ($faqs as $faq): ?>
          <details class="faq__item" open>
            <summary><?php echo esc_html($faq['question']); ?></summary>
            <p><?php echo nl2br(esc_html($faq['answer'])); ?></p>
          </details>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>  
</div>

<!-- レッスンメニュー -->
<div class="faq__button">
  <a href="<?php echo $lesson; ?>" class="button">
    今月のお菓子と日程を見る
    <span></span>
  </a>
</div>

<?php get_footer(); ?>
