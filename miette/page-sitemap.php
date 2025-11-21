<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>
<div class="page-site-map__main">
  <div class="page-site-map__body">
    <div class="page-site-map__inner inner">
      <div class="page-site-map__nav nav nav--site-map">
        <div class="nav__left">
          <div class="nav__block">
            <ul class="nav__items">
              <li class="nav__item"><a href="<?php echo $campaign; ?>">キャンペーン</a></li>
              <li class="nav__item"><a href="<?php echo $campaign_license; ?>">ライセンス講習</a></li>
              <li class="nav__item"><a href="<?php echo $campaign_trial; ?>">体験ダイビング</a></li>
              <li class="nav__item"><a href="<?php echo $campaign_fun; ?>">ファンダイビング</a></li>
            </ul>
            <ul class="nav__items">
              <li class="nav__item"><a href="<?php echo $about; ?>">私たちについて</a></li>
            </ul>
          </div>
          <div class="nav__block">
            <ul class="nav__items">
              <li class="nav__item"><a href="<?php echo $information; ?>">ダイビング情報</a></li>
              <li class="nav__item"><a href="<?php echo $information; ?>#tab-license">ライセンス講習</a></li>
              <li class="nav__item"><a href="<?php echo $information; ?>#tab-trial-diving">体験ダイビング</a></li>
              <li class="nav__item"><a href="<?php echo $information; ?>#tab-fun-diving">ファンダイビング</a></li>
            </ul>
            <ul class="nav__items">
              <li class="nav__item"><a href="<?php echo $blog; ?>">ブログ</a></li>
            </ul>
          </div>
        </div>
        <div class="nav__right">
          <div class="nav__block">
            <ul class="nav__items">
              <li class="nav__item"><a href="<?php echo $voice; ?>">お客様の声</a></li>
            </ul>
            <ul class="nav__items">
              <li class="nav__item"><a href="<?php echo $price; ?>">料金一覧</a></li>
              <li class="nav__item"><a href="<?php echo $price; ?>#price-license">ライセンス講習</a></li>
              <li class="nav__item"><a href="<?php echo $price; ?>#price-trial-diving">体験ダイビング</a></li>
              <li class="nav__item"><a href="<?php echo $price; ?>#price-fun-diving">ファンダイビング</a></li>  
            </ul>
          </div>
          <div class="nav__block">
            <ul class="nav__items">
              <li class="nav__item"><a href="<?php echo $faq; ?>">よくある質問</a></li>
            </ul>
            <ul class="nav__items u-mobile">
              <li class="nav__item nav__item--multiline">
                <a href="<?php echo $privacy; ?>">プライバシー<br>ポリシー</a>
              </li>
            </ul>
            <ul class="nav__items u-desktop">
              <li class="nav__item">
                <a href="<?php echo $privacy; ?>">プライバシーポリシー</a>
              </li>
            </ul>
            <ul class="nav__items">
              <li class="nav__item">
                <a href="<?php echo $terms; ?>">利用規約</a>
              </li>
            </ul>
            <ul class="nav__items">
              <li class="nav__item">
                <a href="<?php echo $contact; ?>">お問い合わせ</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>

<?php get_footer(); ?>
