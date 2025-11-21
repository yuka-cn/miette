<?php get_header(); ?>

<!-- ページコンテンツ -->
<div class="page-information page-information-layout">
  <div class="page-information__body tab">
    <div class="tab__inner inner">
      <!-- tabボタン -->
      <div class="tab__buttons tab-buttons">
        <button class="tab-buttons__item tab-button is-active" type="button" data-target="#tab-license">
          <span class="tab-button__icon"></span>
          <span class="tab-button__text">ライセンス<br>講習</span>
        </button>
        <button class="tab-buttons__item tab-button" type="button" data-target="#tab-fun-diving">
          <span class="tab-button__icon"></span>
          <span class="tab-button__text">ファン<br>ダイビング</span>
        </button>
        <button class="tab-buttons__item tab-button" type="button" data-target="#tab-trial-diving">
          <span class="tab-button__icon"></span>
          <span class="tab-button__text">体験<br>ダイビング</span>
        </button>
      </div>
      <!-- tabパネル -->
      <div class="tab__panels tab-panels">
        <div class="tab-panels__item tab-panel is-active" id="tab-license">
          <div class="tab-panel__body">
            <h2 class="tab-panel__title">ライセンス講習</h2>
            <p class="tab-panel__text">
              泳げない人も、ちょっと水が苦手な人も、ダイビングを「安全に」楽しんでいただけるよう、スタッフがサポートいたします！スキューバダイビングを楽しむためには最低限の知識とスキルが要求されます。知識やスキルと言ってもそんなに難しい事ではなく、安全に楽しむ事を目的としたものです。プロダイバーの指導のもと知識とスキルを習得しCカードを取得して、ダイバーになろう！
            </p>
          </div>
          <div class="tab-panel__image">
            <img src="<?php echo get_theme_file_uri('/assets/images/pages/information_1.jpg'); ?>" alt="">
          </div>
        </div>
        <div class="tab-panels__item tab-panel" id="tab-fun-diving">
          <div class="tab-panel__body">
            <h2 class="tab-panel__title">ファンダイビング</h2>
            <p class="tab-panel__text">
              ブランクダイバー、ライセンスを取り立ての方も安心！沖縄本島を代表する「青の洞窟」（真栄田岬）やケラマ諸島などメジャーなポイントはモチロンのこと、最北端「辺戸岬」や最南端の「大渡海岸」等もご用意！
            </p>
          </div>
          <div class="tab-panel__image">
            <img src="<?php echo get_theme_file_uri('/assets/images/pages/information_2.jpg'); ?>" alt="">
          </div>
        </div>
        <div class="tab-panels__item tab-panel" id="tab-trial-diving">
          <div class="tab-panel__body">
            <h2 class="tab-panel__title">体験ダイビング</h2>
            <p class="tab-panel__text">
              ブランクダイバー、ライセンスを取り立ての方も安心！沖縄本島を代表する「青の洞窟」（真栄田岬）やケラマ諸島などメジャーなポイントはモチロンのこと、最北端「辺戸岬」や最南端の「大渡海岸」等もご用意！
            </p>
          </div>
          <div class="tab-panel__image">
            <img src="<?php echo get_theme_file_uri('/assets/images/pages/information_3.jpg'); ?>" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
