
<!-- ページタイトル -->
<?php
$post_type = get_post_type();
$template = get_page_template_slug();
$page_id  = get_the_ID();
$slug     = get_post_field('post_name', $page_id);

// ----------------------
// デフォルト
$header_pc = get_theme_file_uri('/assets/images/pages/mv-about_pc.jpg');
$header_sp = get_theme_file_uri('/assets/images/pages/mv-about_sp.jpg');
$header_title = get_the_title();

// ----------------------
// blogページ
if ($template === 'home.php' || $post_type === 'post') {
  $header_pc = get_theme_file_uri('/assets/images/pages/mv-blog_pc.jpg');
  $header_sp = get_theme_file_uri('/assets/images/pages/mv-blog_sp.jpg');
  $header_title = 'ブログ';

// ----------------------
// lessonページ
} elseif (is_post_type_archive('lesson') || is_tax('lesson_category') || is_singular('lesson') ){
  $header_pc = get_theme_file_uri('/assets/images/pages/mv-lesson_pc_2.jpg');
  $header_sp = get_theme_file_uri('/assets/images/pages/mv-lesson_sp_2.jpg');
  $header_title = 'レッスンメニュー';

// ----------------------
// contactページ
} elseif ($slug === 'contact' || $slug === 'thanks') {
  $header_pc = get_theme_file_uri('/assets/images/pages/mv-contact_pc.jpg');
  $header_sp = get_theme_file_uri('/assets/images/pages/mv-contact_sp.jpg');
  $header_title = 'お問い合わせ';

// ----------------------
// reservationページ
} elseif ($slug === 'reservation' || $slug === 'thanks') {
  $header_pc = get_theme_file_uri('/assets/images/pages/mv-reservation_pc.jpg');
  $header_sp = get_theme_file_uri('/assets/images/pages/mv-reservation_sp.jpg');
  $header_title = 'レッスン予約';

// ----------------------
// その他ページ
} else {
    switch ($slug) {
      case 'about':
          $header_pc = get_theme_file_uri('/assets/images/pages/mv-about_pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/mv-about_sp.jpg');
          $header_title = '教室について';
          break;
      case 'lesson-guide':
          $header_pc = get_theme_file_uri('/assets/images/pages/mv-lesson_pc_1.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/mv-lesson_sp_1.jpg');
          $header_title = 'レッスン案内';
          break;
      case 'faq':
          $header_pc = get_theme_file_uri('/assets/images/pages/mv-faq_pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/mv-faq_sp.jpg');
          $header_title = 'よくある質問';
          break;
      case 'access':
          $header_pc = get_theme_file_uri('/assets/images/pages/mv-access_pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/mv-access_sp.jpg');
          $header_title = 'アクセス';
          break;
      case 'privacy':
          $header_pc = get_theme_file_uri('/assets/images/pages/mv-privacy_pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/mv-privacy_sp.jpg');
          $header_title = 'プライバシーポリシー';
          break;
      default:
          break;
    }
}
?>

<section class="page-header">
  <div class="page-header__image">
    <picture>
      <source srcset="<?php echo esc_url($header_pc); ?>" media="(min-width:768px)">
      <img src="<?php echo esc_url($header_sp); ?>" alt="">
    </picture>
  </div>
  <div class="page-header__body">
    <div class="page-header__divider divider divider--c divider--top"></div>
    <div class="page-header__inner inner">
      <h1 class="page-header__title"><?php echo esc_html($header_title); ?></h1>
      <div class="page-header__breadcrumb">
        <?php get_template_part('template-parts/breadcrumb'); ?>
      </div>
    </div>
  </div>
</section>
