<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>
</main>

  <!-- topへ戻るボタン -->
  <button type="button" class="to-top" aria-label="ページの先頭へ戻る">
    <span></span>
  </button>
  <!-- フッター -->
  <footer class="footer footer-layout <?php echo (is_front_page() || is_page('about')) ? 'footer-layout--no-margin' : ''; ?>">
    <div class="footer__inner inner">
      <div class="footer__header">
        <div class="footer__logo">
          <a href="<?php echo $home ?>" class="footer__logolink">
            <img src="<?php echo get_theme_file_uri('/assets/images/common/miette.png'); ?>" alt="やさしいおやつ教室Miette">
          </a>
        </div>
        <div class="footer__sns">
          <a href="#" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo get_theme_file_uri('/assets/images/common/instagram.png'); ?>" alt="instagram">
          </a>
        </div>
      </div>

      <nav class="footer__nav nav js-nav">
        <ul class="nav__items">
          <li class="nav__item nav__item--has-subitem">
            <a href="<?php echo $lesson_guide; ?>">レッスン案内</a>
            <ul class="nav__subitem">
              <li><a href="<?php echo $lesson_guide; ?>#tab-basic">ベーシッククラス</a></li>
              <li><a href="<?php echo $lesson_guide; ?>#tab-seasonal">季節のおやつクラス</a></li>
              <li><a href="<?php echo $lesson_guide; ?>#tab-parent-child">親子クラス</a></li>
            </ul>
          </li>
          <li class="nav__item nav__item--has-subitem">
            <a href="<?php echo $lesson; ?>">レッスンメニュー</a>
            <ul class="nav__subitem">
              <li><a href="<?php echo $lesson_basic; ?>">ベーシッククラス</a></li>
              <li><a href="<?php echo $lesson_seasonal; ?>">季節のおやつクラス</a></li>
              <li><a href="<?php echo $lesson_parent_child; ?>">親子クラス</a></li>
            </ul>
          </li>
          <li class="nav__item"><a href="<?php echo $reservation; ?>">レッスン予約</a></li>
        </ul>
        <ul class="nav__items">
          <li class="nav__item"><a href="<?php echo $about; ?>">教室について</a></li>
          <li class="nav__item"><a href="<?php echo $access; ?>">アクセス</a></li>
          <li class="nav__item"><a href="<?php echo $faq; ?>">よくある質問</a></li>
          <li class="nav__item"><a href="<?php echo $blog; ?>">ブログ</a></li>
        </ul>
        <ul class="nav__items">
          <li class="nav__item"><a href="<?php echo $contact; ?>">お問い合わせ</a></li>
          <li class="nav__item"><a href="<?php echo $privacy; ?>">プライバシーポリシー</a></li>
        </ul>
      </nav>

      <p class="footer__copyright">
        &copy; 2025 やさしいおやつ教室 Miette. All Rights Reserved.
      </p>
    </div>
  </footer>

<?php wp_footer(); ?>
</body>
</html>
