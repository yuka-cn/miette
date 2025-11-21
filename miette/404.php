<?php get_header(); ?>
<main>
  <section class="not-found">
    <nav class="not-found__breadcrumb breadcrumb" aria-label="パンくずリスト">
      <div class="breadcrumb__inner inner">
        <ol class="breadcrumb__list">
          <li class="breadcrumb__item"><a href="<?php echo home_url(); ?>">TOP</a></li>
          <li class="breadcrumb__item" aria-current="page">404</li>
        </ol>
      </div>
    </nav>
    <div class="not-found__main">
      <div class="not-found__code">404</div>
      <h1 class="not-found__text">
        申し訳ありません。<br>お探しのページが見つかりません。
      </h1>
      <div class="not-found__button">
        <a href="<?php echo home_url(); ?>" class="button button--404">
          Page TOP
          <span></span>
        </a>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>