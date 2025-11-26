<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <?php wp_head(); ?>
</head>

<body>
<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ヘッダー -->
<header class="header header-layout <?php echo is_front_page() ? 'header--top' : ''; ?>">
  <div class="header__inner">
    <?php if ( is_front_page() ) : ?>
      <h1 class="header__logo">
        <a href="<?php echo $home; ?>" class="header__logolink">
          <img
            src="<?php echo get_theme_file_uri('/assets/images/common/miette.svg'); ?>"
            data-color="<?php echo get_theme_file_uri('/assets/images/common/miette-color.svg'); ?>"
            data-white="<?php echo get_theme_file_uri('/assets/images/common/miette.svg'); ?>"
            alt="やさしいおやつ教室Miette"
          >
        </a>
      </h1>
    <?php else : ?>
      <div class="header__logo">
        <a href="<?php echo $home; ?>" class="header__logolink">
          <img
            src="<?php echo get_theme_file_uri('/assets/images/common/miette.svg'); ?>"
            data-color="<?php echo get_theme_file_uri('/assets/images/common/miette-color.svg'); ?>"
            data-white="<?php echo get_theme_file_uri('/assets/images/common/miette.svg'); ?>"
            alt="やさしいおやつ教室Miette"
          >
        </a>
      </div>
    <?php endif; ?>

    <!-- ハンバーガー -->
    <button class="header__drawer hamburger js-hamburger">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- sp-nav -->
    <nav class="header__sp-nav sp-nav js-sp-nav">
      <ul class="sp-nav__items">
        <li class="sp-nav__item"><a href="<?php echo $about; ?>">教室について</a></li>
        <li class="sp-nav__item"><a href="<?php echo $lesson_guide; ?>">レッスン案内</a></li>
        <li class="sp-nav__item"><a href="<?php echo $blog; ?>">ブログ</a></li>
        <li class="sp-nav__item"><a href="<?php echo $faq; ?>">よくある質問</a></li>
        <li class="sp-nav__item"><a href="<?php echo $access; ?>">アクセス</a></li>
        <li class="sp-nav__item"><a href="<?php echo $contact; ?>">お問い合わせ</a></li>
        <li class="sp-nav__item"><a href="<?php echo $reservation; ?>">レッスン予約</a></li>
      </ul>
    </nav>

    <!-- pc-nav -->
    <nav class="header__pc-nav pc-nav js-pc-nav">
      <ul class="pc-nav__items">
        <li class="pc-nav__item"><a href="<?php echo $about; ?>">教室について</a></li>
        <li class="pc-nav__item"><a href="<?php echo $lesson_guide; ?>">レッスン案内</a></li>
        <li class="pc-nav__item"><a href="<?php echo $blog; ?>">ブログ</a></li>
        <li class="pc-nav__item"><a href="<?php echo $faq; ?>">よくある質問</a></li>
        <li class="pc-nav__item"><a href="<?php echo $access; ?>">アクセス</a></li>
        <li class="pc-nav__item"><a href="<?php echo $contact; ?>">お問い合わせ</a></li>
      </ul>
      <div class="pc-nav__cta">
        <a href="<?php echo $reservation; ?>">レッスン予約</a>
      </div>
    </nav>
  </div>
</header>

<?php if ( !is_front_page() && !is_404() ) : ?>
  <main>
    <?php get_template_part( 'template-parts/page-header' ); ?>
<?php endif; ?>
