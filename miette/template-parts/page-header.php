
<!-- ページタイトル -->
<?php
$post_type = get_post_type();
$template = get_page_template_slug();
$page_id  = get_the_ID();
$slug     = get_post_field('post_name', $page_id);

// ----------------------
// デフォルト
$header_pc = get_theme_file_uri('/assets/images/pages/blog-fv-pc.jpg');
$header_sp = get_theme_file_uri('/assets/images/pages/blog-fv-sp.jpg');
$header_title = get_the_title();

// ----------------------
// blogページ
if ($template === 'home.php' || $post_type === 'post') {
    $header_title = 'Blog';

// ----------------------
// campaignページ
} elseif (is_post_type_archive('campaign') || is_tax('campaign_category')){
  $header_pc = get_theme_file_uri('/assets/images/pages/campaign-fv-pc.jpg');
  $header_sp = get_theme_file_uri('/assets/images/pages/campaign-fv-sp.jpg');
  $header_title = 'Campaign';

// ----------------------
// voiceページ
} elseif (is_post_type_archive('voice') || is_tax('voice_category')) {
  $header_pc = get_theme_file_uri('/assets/images/pages/voice-fv-pc.jpg');
  $header_sp = get_theme_file_uri('/assets/images/pages/voice-fv-sp.jpg');
  $header_title = 'Voice';

// ----------------------
// contactページ
} elseif ($slug === 'contact' || $slug === 'thanks') {
  $header_pc = get_theme_file_uri('/assets/images/pages/contact-fv-pc.jpg');
  $header_sp = get_theme_file_uri('/assets/images/pages/contact-fv-sp.jpg');
  $header_title = 'Contact';

// ----------------------
// その他ページ
} else {
    switch ($slug) {
      case 'about-us':
          $header_pc = get_theme_file_uri('/assets/images/pages/about-fv-pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/about-fv-sp.jpg');
          $header_title = 'About us';
          break;
      case 'information':
          $header_pc = get_theme_file_uri('/assets/images/pages/information-fv-pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/information-fv-sp.jpg');
          $header_title = 'Information';
          break;
      case 'price':
          $header_pc = get_theme_file_uri('/assets/images/pages/price-fv-pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/price-fv-sp.jpg');
          $header_title = 'Price';
          break;
      case 'faq':
          $header_pc = get_theme_file_uri('/assets/images/pages/faq-fv-pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/faq-fv-sp.jpg');
          $header_title = 'FAQ';
          break;
      case 'sitemap':
          $header_pc = get_theme_file_uri('/assets/images/pages/policy-fv-pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/policy-fv-sp.jpg');
          $header_title = 'SiteMAP';
          break;
      case 'privacypolicy':
          $header_pc = get_theme_file_uri('/assets/images/pages/policy-fv-pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/policy-fv-sp.jpg');
          $header_title = 'Privacy Policy';
          break;
      case 'terms-of-service':
          $header_pc = get_theme_file_uri('/assets/images/pages/policy-fv-pc.jpg');
          $header_sp = get_theme_file_uri('/assets/images/pages/policy-fv-sp.jpg');
          $header_title = 'Terms of Service';
          break;
      default:
          break;
    }
}
?>

<div class="page-header">
  <h1 class="page-header__title"><?php echo esc_html($header_title); ?></h1>
  <div class="page-header__image">
      <picture>
          <source srcset="<?php echo esc_url($header_pc); ?>" media="(min-width:768px)">
          <img src="<?php echo esc_url($header_sp); ?>" alt="">
      </picture>
  </div>

  <!-- パンくずリスト -->
  <div class="page-header__breadcrumb">
      <?php get_template_part('template-parts/breadcrumb'); ?>
  </div>
</div>
