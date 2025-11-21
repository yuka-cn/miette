<?php get_header(); ?>

<!-- ページコンテンツ -->
<?php
$faqs = array_filter(SCF::get('faq'), function($faq){
  return !empty($faq['question']) && !empty($faq['answer']);
});
?>

<div class="page-faq page-faq-layout">
  <div class="page-faq__body faq">
    <div class="faq__inner inner">
      <?php if (empty($faqs)): ?>
        <p class="page-faq__no-post no-post">ただいま準備中です。<br>公開までしばらくお待ちください。</p>
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

<?php get_footer(); ?>
