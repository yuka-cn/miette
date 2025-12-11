<?php

// テーマの基本設定
function miette_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
  register_nav_menus([
    'global' => 'グローバルナビゲーション',
    'footer' => 'フッターナビゲーション',
  ]);
}
add_action('after_setup_theme', 'miette_theme_setup');

// WordPress が sizes="auto" を自動で付けるのを停止
add_filter('wp_img_tag_add_auto_sizes', '__return_false');

// アセット読み込み
function miette_enqueue_assets() {
  // $theme_uri = get_theme_file_uri();
  $theme_uri = get_template_directory_uri(); 
  $theme_version = wp_get_theme()->get('Version');

  // Google Fonts
  wp_enqueue_style(
    'miette-google-fonts',
    'https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;500;700&family=Zen+Maru+Gothic&display=swap',
    [],
    null
  );

  // メインCSS
  wp_enqueue_style('miette-style', $theme_uri . '/assets/css/style.css', [], $theme_version);

  // Swiper CSS
  wp_enqueue_style('miette-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11');

  // jQuery（WordPress同梱）
  wp_enqueue_script('jquery');

  // Swiper JS
  wp_enqueue_script('miette-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', ['jquery'], '11', true);

  // inview（ローカル）
  wp_enqueue_script('miette-inview', $theme_uri . '/assets/js/jquery.inview.min.js', ['jquery'], $theme_version, true);

  // メインJS（ローカル）
  wp_enqueue_script('miette-script', $theme_uri . '/assets/js/script.js', ['jquery'], $theme_version, true);

  // ajaxurl
  wp_localize_script('miette-script', 'wpAjax', ['ajaxurl' => admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', 'miette_enqueue_assets');

// Google Fontsのpreconnect
function miette_google_fonts_preconnect() {
  echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
  echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'miette_google_fonts_preconnect');

//　　リンクの設定
function theme_get_links() {
  // カスタム投稿タイプのアーカイブ
  $lesson = esc_url( get_post_type_archive_link( 'lesson' ) );

  // タクソノミー（レッスンカテゴリ）
  $basic_term        = get_term_by( 'slug', 'basic', 'lesson_category' );
  $seasonal_term     = get_term_by( 'slug', 'seasonal', 'lesson_category' );
  $parent_child_term = get_term_by( 'slug', 'parent-child', 'lesson_category' );

  $lesson_basic        = $basic_term        ? esc_url( get_term_link( $basic_term ) )        : '#';
  $lesson_seasonal     = $seasonal_term     ? esc_url( get_term_link( $seasonal_term ) )     : '#';
  $lesson_parent_child = $parent_child_term ? esc_url( get_term_link( $parent_child_term ) ) : '#';
  
  // 固定ページ
  $home         = esc_url( home_url( '/' ) );
  $about        = esc_url( home_url( '/about/' ) );
  $lesson_guide = esc_url( home_url( '/lesson-guide/' ) );
  $blog         = esc_url( home_url( '/blog/' ) );
  $faq          = esc_url( home_url( '/faq/' ) );
  $access       = esc_url( home_url( '/access/' ) );
  $contact      = esc_url( home_url( '/contact/' ) );
  $reservation  = esc_url( home_url( '/reservation/' ) );
  $privacy      = esc_url( home_url( '/privacy/' ) );

  // 配列でまとめる
  $links = compact(
      'home', 'lesson', 'lesson_basic', 'lesson_seasonal', 'lesson_parent_child',
      'about', 'lesson_guide', 'blog', 'faq', 'access', 'contact', 'reservation', 'privacy'
  );

  return $links;
}


//　　アーカイブの表示件数変更
function change_posts_per_page($query) {
  if ( is_admin() || ! $query->is_main_query() ) {
      return;
  }
  if ( $query->is_post_type_archive('lesson') ) {
      $query->set( 'posts_per_page', 6 );
  }
  if ( is_tax('lesson_category') ) {
      $query->set( 'posts_per_page', 6 );
  }
}
add_action( 'pre_get_posts', 'change_posts_per_page' );


//　　投稿→ブログに変更
function change_post_menu_label() {
  global $menu, $submenu;
  $menu[5][0] = 'ブログ';
  $submenu['edit.php'][5][0]  = 'ブログ一覧';
  $submenu['edit.php'][10][0] = '新規追加';
}
add_action( 'admin_menu', 'change_post_menu_label' );

function change_post_object_label() {
  global $wp_post_types;
  $labels = &$wp_post_types['post']->labels;
  $labels->name               = 'ブログ';
  $labels->singular_name      = 'ブログ';
  $labels->all_items          = 'ブログ一覧';
  $labels->add_new_item       = '新規ブログを追加';
  $labels->edit_item          = 'ブログを編集';
  $labels->menu_name          = 'ブログ';
}
add_action( 'init', 'change_post_object_label' );


// 閲覧数を取得
function get_post_views($postID){
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  return $count ? $count : 0;
}

// 閲覧数を1増やす
function set_post_views($postID) {
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if($count==''){
      add_post_meta($postID, $count_key, '1');
  } else {
      $count++;
      update_post_meta($postID, $count_key, $count);
  }
}
  

//　　ページネーション
function my_custom_pagenavi($html) {
  // 前後ボタンの生成
  global $wp_query;

  $max_page = $wp_query->max_num_pages;
  $paged = max(1, get_query_var('paged'));

  if ($paged > 1) {
    $prev = get_previous_posts_link('前へ');
    $prev = preg_replace('/<a /', '<a class="pagination__prev" ', $prev, 1);
  } else {
    $prev = '<span class="pagination__prev pagination__disabled"></span>';
  }

  if ($paged < $max_page) {
    $next = get_next_posts_link('次へ', $max_page);
    $next = preg_replace('/<a /', '<a class="pagination__next" ', $next, 1);
  } else {
    $next = '<span class="pagination__next pagination__disabled"></span>';
  }

  // 5ページ以降にクラス付与
  $dom = new DOMDocument('1.0', 'UTF-8');
  libxml_use_internal_errors(true);

  $dom->loadHTML('<?xml encoding="UTF-8"><body>' . $html . '</body>');
  libxml_clear_errors();

  $links = $dom->getElementsByTagName('a');

  foreach ($links as $link) {
    $pageNum = (int)$link->nodeValue;

    if ($pageNum >= 5) {
      $existingClass = $link->getAttribute('class');
      $link->setAttribute('class', trim($existingClass . ' pagination__page--pc'));
    }
  }

  $body = $dom->getElementsByTagName('body')->item(0);
  $newHtml = '';
  if ($body) {
    foreach ($body->childNodes as $child) {
      $newHtml .= $dom->saveHTML($child);
    }
  }

  return $prev . $newHtml . $next;
}
add_filter('wp_pagenavi', 'my_custom_pagenavi');

function my_single_pagination() {
  // 前の記事
  $prev_post = get_previous_post();
  if ( $prev_post ) {
      echo '<div class="pagination__prev">';
      previous_post_link('%link', '前へ');
      echo '</div>';
  } else {
      echo '<div class="pagination__prev pagination__disabled"></div>';
  }

  // 次の記事
  $next_post = get_next_post();
  if ( $next_post ) {
      echo '<div class="pagination__next">';
      next_post_link('%link', '次へ');
      echo '</div>';
  } else {
      echo '<div class="pagination__next pagination__disabled"></div>';
  }
}

// CF7で自動挿入されるPタグ、brタグを削除
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false() {
  return false;
}

// レッスン予約の日程取得
function get_reservation_dates() {
  $page = get_page_by_path('reservation');
  if (!$page) return [];
  $page_id = $page->ID;

  $classes = [
    'ベーシッククラス' => 'reservation_basic',
    '季節のおやつクラス' => 'reservation_seasonal',
    '親子クラス' => 'reservation_parent_child'
  ];

  $results = [];

  foreach ($classes as $class_label => $class_field) {
    $class_data = get_field($class_field, $page_id);
    if (!$class_data) continue;

    for ($i = 1; $i <= 4; $i++) {
      if (empty($class_data['date_'.$i]['date'])) continue;

      $raw_date  = $class_data['date_'.$i]['date'];
      $status    = $class_data['date_'.$i]['status'];
      $timestamp = strtotime($raw_date);

      $display_date = date_i18n('Y/m/j(D) H:i〜', $timestamp);

      $results[] = [
        'class'     => $class_label,
        'timestamp' => $timestamp,
        'label'     => $display_date . '（' . $status . '）'
      ];
    }
  }

  return $results;
}

// CF7レッスン予約の希望日程の選択肢に反映
add_filter('wpcf7_form_tag', 'schedule_to_cf7');

function schedule_to_cf7($tag) {
  if ($tag['name'] !== 'schedule') return $tag;

  $dates = get_reservation_dates();
  
  // 日付順に並び替え
  usort($dates, function($a, $b) {
    return $a['timestamp'] <=> $b['timestamp'];
  });

  // 選択肢を作成して反映
  $options = ['以下から選択してください'];
  foreach ($dates as $item) {
    $options[] = $item['label'];
  }

  $tag['raw_values'] = $options;
  $tag['values']     = $options;
  $tag['labels']     = $options;

  return $tag;
}

// AJAX（JS → PHP）: 選択されたクラスに応じて日付を返す
add_action('wp_ajax_get_class_dates', 'ajax_get_class_dates');
add_action('wp_ajax_nopriv_get_class_dates', 'ajax_get_class_dates');

function ajax_get_class_dates() {

  $class_name = $_POST['class_name'] ?? '';

  $dates = get_reservation_dates();

  // クラスで絞り込み
  $filtered = array_filter($dates, function($item) use ($class_name) {
    return $item['class'] === $class_name;
  });

  // 並び替え
  usort($filtered, function($a, $b) {
    return $a['timestamp'] <=> $b['timestamp'];
  });

  // ラベル化
  $options = array_map(function($item) {
    return $item['label'];
  }, $filtered);

  wp_send_json($options);
}


// CF7送信後リダイレクト用のカスタムJSを読み込み
function enqueue_my_cf7_script() {
  wp_localize_script('miette-script', 'mySite', array(
      'homeUrl' => get_site_url()
  ));
}
add_action('wp_enqueue_scripts', 'enqueue_my_cf7_script');


// タイトルタグの上書き（アーカイブページ）
add_filter('ssp_output_title', function($title){
  $seo_page = get_page_by_path('seo-settings');
  if (!$seo_page) return $title;

  if (is_post_type_archive('campaign')) {
    $data = get_field('campaign_settings', $seo_page->ID);
    if (!empty($data['title'])) return $data['title'];
  } elseif (is_post_type_archive('voice')) {
    $data = get_field('voice_settings', $seo_page->ID);
    if (!empty($data['title'])) return $data['title'];
  }

  return $title;
});

// descriptionの上書き（アーカイブページ）
add_filter('ssp_output_description', function($desc){
  $seo_page = get_page_by_path('seo-settings');
  if (!$seo_page) return $desc;

  if (is_post_type_archive('campaign')) {
    $data = get_field('campaign_settings', $seo_page->ID);
    if (!empty($data['description'])) return $data['description'];
  } elseif (is_post_type_archive('voice')) {
    $data = get_field('voice_settings', $seo_page->ID);
    if (!empty($data['description'])) return $data['description'];
  }

  return $desc;
});


// WP標準タイトルタグの上書き（アーカイブページ）
add_filter('pre_get_document_title', function($title) {
  $seo_page = get_page_by_path('seo-settings');
  if (!$seo_page) return $title;

  if (is_post_type_archive('campaign')) {
    $data = get_field('campaign_settings', $seo_page->ID);
    if (!empty($data['title'])) return $data['title'];
  } elseif (is_post_type_archive('voice')) {
    $data = get_field('voice_settings', $seo_page->ID);
    if (!empty($data['title'])) return $data['title'];
  }

  return $title;
});
