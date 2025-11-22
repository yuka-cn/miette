<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);

$exclude_pages = array('contact', 'thanks');

if (!(is_page($exclude_pages[0]) || is_page($exclude_pages[1])) && !is_404()) :
?>
  </main>

  <!-- contactセクション -->
  <section class="contact contact-layout <?php echo is_page() ? 'contact-page-layout' : ''; ?>">
    <div class="contact__inner inner">
      <div class="contact__box">
        <div class="contact__company-overview company">
          <div class="company__name">
            <img src="<?php echo get_theme_file_uri('/assets/images/common/codeups.png'); ?>" alt="CodeUps">
          </div>
          <div class="company__flex">
            <div class="company__details">
              <p class="company__address">沖縄県那覇市1-1</p>
              <p class="company__tel">TEL:0120-000-0000</p>
              <p class="company__business-hours">営業時間:8:30-19:00</p>
              <p class="company__closed-day">定休日:毎週火曜日</p>
            </div>
            <div class="company__map">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1881.7860220603193!2d127.67874270072544!3d26.21403021336403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34e5699dc05bf813%3A0x3501764c0a57176d!2z44CSOTAwLTAwMTUg5rKW57iE55yM6YKj6KaH5biC5LmF6IyC5Zyw77yR5LiB55uu77yR4oiS77yR!5e0!3m2!1sja!2sjp!4v1741890163409!5m2!1sja!2sjp"
                style="border:0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="map"></iframe>
            </div>
          </div>
        </div>
        <div class="contact__block">
          <div class="contact__header section-header">
            <p class="section-header__entitle section-header__entitle--big">Contact</p>
            <h2 class="section-header__jatitle section-header__jatitle--big">お問い合わせ</h2>
          </div>
          <p class="contact__text">ご予約・お問い合わせはコチラ</p>
          <div class="contact__button">
            <a href="<?php echo $contact; ?>" class="button">
              Contact us
              <span></span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

  <!-- topへ戻るボタン -->
  <button type="button" class="to-top" aria-label="ページの先頭へ戻る">
    <span></span>
  </button>
  <!-- フッター -->
  <footer class="footer footer-layout <?php echo is_404() ? 'footer-layout--404' : ''; ?>">
    <div class="footer__inner inner">
      <div class="footer__header">
        <div class="footer__logo">
          <a href="<?php echo $home ?>" class="footer__logolink">
            <img src="<?php echo get_theme_file_uri('/assets/images/common/miette.svg'); ?>" alt="やさしいおやつ教室Miette">
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
              <li><a href="#">ベーシッククラス</a></li>
              <li><a href="#">季節のおやつクラス</a></li>
              <li><a href="#">親子クラス</a></li>
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
