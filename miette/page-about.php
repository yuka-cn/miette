<?php get_header(); ?>

<?php
$links = theme_get_links();
extract($links, EXTR_SKIP);
?>

<!-- ページコンテンツ -->
<div class="about about-layout">
  <!-- コンセプト -->
  <section class="about__concept concept">
    <div class="concept__inner inner">
      <h2 class="concept__header section-header section-header--center js-fadeIn">
        <span class="section-header__ja">コンセプト</span>
        <span class="section-header__en">concept</span>
      </h2>
      <p class="concept__text js-fadeIn">
        毎日の暮らしに寄り添う<br>
        やさしいおやつづくりを
      </p>
      <p class="concept__text js-fadeIn">
        特別な日じゃなくても<br>
        焼きたての甘い香りがあるだけで<br>
        ふと心がやわらぐ
      </p>
      <p class="concept__text js-fadeIn">
        忙しい日々の中に<br>
        ほっと心がほどけるひとときを
      </p>
      <p class="concept__text js-fadeIn">
        素材にこだわり<br>
        子どもと一緒に安心して食べられる<br>
        やさしいおやつを家でも気軽に
      </p>
      <p class="concept__text js-fadeIn">
        ひとくちで思わず笑顔になる<br>
        そんな“ミエット（小さなかけら）”のような<br>
        幸せを届けられますように
      </p>
    </div>
    <div class="about__divider divider divider--a divider--bottom"></div>
  </section>


  <!-- プロフィール -->
  <section class="about__profile profile">
    <div class="profile__inner inner">
      <h2 class="profile__header section-header js-fadeIn">
        <span class="section-header__ja">プロフィール</span>
        <span class="section-header__en">profile</span>
      </h2>
      <div class="profile__body">
        <div class="profile__image js-fadeIn">
          <img src="<?php echo get_theme_file_uri('/assets/images/common/profile.jpg'); ?>" alt="">
        </div>
        <div class="profile__text js-fadeIn">
          <div class="profile__info">
            <p class="profile__name">高橋 ことね</p>
            <ul class="profile__career">
              <li>兵庫県の製菓専門学校卒</li>
              <li>パティスリー勤務歴3年</li>
              <li>2022年から自宅教室を開講</li>
            </ul>
          </div>
          <div class="profile__message">
            <p>
              仕事や家事の合間に<br>
              おやつづくりが心を整える時間になればと思い<br>
              出産を機に、小さな教室をはじめました。
            </p>
            <p>
              無理なく続けられるやさしいレシピを中心に<br>
              暮らしの中に寄り添うおやつづくりを<br class="u-mobile">お伝えしています。
            </p>
            <p>
              焼きたてのおやつで、ふと笑顔になれる時間を<br>
              一緒に楽しんでいただけたらうれしいです。
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php get_footer(); ?>
