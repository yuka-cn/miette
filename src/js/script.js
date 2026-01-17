/* ----------------------------------------------------
 * jQuery scripts
 * ---------------------------------------------------- */

jQuery(function ($) {
  
/* 予約ページの希望日程 */
  // 選択クラスに応じて日程を更新する
  $('input[name="lesson_class"]').on('change', function () {
    const className = $(this).val();
    const select = $('#schedule');
    
    select.empty();
    
    $.ajax({
      url: wpAjax.ajaxurl,
      type: 'POST',
      data: {
        action: 'get_class_dates',
        class_name: className
      },
      success: function (options) {
        select.empty();
        select.append('<option value="">以下から選択してください</option>');
        options.forEach(function (opt) {
          select.append('<option>' + opt + '</option>');
        });
      }
    });
  });

});

/* ----------------------------------------------------
 * Vanilla JavaScript (Native JS)
 * ---------------------------------------------------- */

/* ローディングアニメーション*/
  document.addEventListener('DOMContentLoaded', () => {
    const loading = document.getElementById('loading');
    const logo = document.querySelector('.loading__logo');

    if (!loading || !logo) return;

    const isVisited = sessionStorage.getItem('visited');
    const isLoaded = sessionStorage.getItem('loaded');

    if (!isVisited || !isLoaded) {
      sessionStorage.setItem('visited', 'true');
      document.body.classList.add('is-loading');

      // reduced-motionでanimationedが発火しなくてもローディング終了
      const fallbackTimer = setTimeout(() => {
        loading.style.display = 'none';
        document.body.classList.remove('is-loading');
      }, 2000);

      logo.addEventListener('animationend', () => {
        clearTimeout(fallbackTimer);
        loading.style.display = 'none';
        document.body.classList.remove('is-loading');
        sessionStorage.setItem('loaded', 'true');
      }, { once: true });
    } else {
      loading.style.display = 'none';
      document.body.classList.add('is-loaded');
    }
  });

/* スクロール位置に応じてヘッダーの色を切り替える */
{
  const header = document.querySelector('.header');
  const logo = document.querySelector('.header__logolink img');
  const hamburger = document.querySelector('.hamburger');
  const pcNav = document.querySelector('.pc-nav');

  function checkScroll() {
    if (!header) return;

    const headerHeight = header.offsetHeight;
    const isFront = document.querySelector('.mv') !== null;
    const target = isFront
      ? document.querySelector('.mv')
      : document.querySelector('.page-header__image');

    if (!target) return;

    const scrollTop = window.pageYOffset;
    const over = scrollTop > target.offsetHeight - headerHeight;

    if (over) {
      hamburger?.classList.add('is-color');
      pcNav?.classList.add('is-color');
      logo?.setAttribute('src', logo.dataset.color);

      header.classList.toggle('is-show', isFront);
      header.classList.toggle('is-color', !isFront);
    } else {
      hamburger?.classList.remove('is-color');
      pcNav?.classList.remove('is-color');
      logo?.setAttribute('src', logo.dataset.white);

      header.classList.remove('is-show');
      header.classList.remove('is-color');
    }
  }

  window.addEventListener('scroll', checkScroll, { passive: true });
  checkScroll();

  // ハンバーガー閉時にロゴ・ヘッダーの色を更新するためのカスタムイベント
  window.addEventListener('forceScrollCheck', checkScroll);
}

/* ハンバーガーメニュー */
{
  const hamburger = document.querySelector('.hamburger');
  const header = document.querySelector('.header');
  const spNav = document.querySelector('.sp-nav');
  const logo = document.querySelector('.header__logolink img');

  hamburger && hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('is-active');
    header?.classList.toggle('is-active');
    spNav?.classList.toggle('is-active');

    const isActive = hamburger.classList.contains('is-active');

    hamburger.setAttribute('aria-expanded', isActive);
    hamburger.setAttribute(
      'aria-label',
      isActive ? 'メニューを閉じる' : 'メニューを開く'
    );

    if (isActive) {
      document.body.style.overflow = 'hidden';
      logo?.setAttribute('src', logo.dataset.white);
    } else {
      document.body.style.overflow = '';
      window.dispatchEvent(new Event('forceScrollCheck'));
    }
  });

  //pc画面幅ではハンバーガーメニューを非表示にする
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
      spNav?.classList.remove('is-active');
      header?.classList.remove('is-active');

      spNav?.style.removeProperty('display');
      header?.style.removeProperty('display');
    }
  });
}

/* トップに戻るボタン */
{
  const topBtn = document.querySelector('.to-top');
  if (topBtn){
    const toggleTopButton = () => {
      topBtn.classList.toggle('is-show', window.scrollY > 90);
    };

    window.addEventListener('scroll', toggleTopButton, { passive: true });
    toggleTopButton();

    topBtn.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
}

/* レッスンメニューのカードスライダー */
  // inner幅の基準値を設定
  const INNER_WIDTH = 1080;

  // SwiperのspaceBetweenを計算
  function getSpaceBetween() {
    let windowWidth = window.innerWidth;

    if (windowWidth <= 375) {
      return windowWidth * (10.6 / 100); // 375px以下は 10.6vw ←(40px/375px)×100
    } else if (windowWidth > 375 && windowWidth < 768) {
      return 40; // 376px〜767px は固定 24px
    } else if (windowWidth >= 768 && windowWidth < INNER_WIDTH) {
      return windowWidth * (7.4 / 100); // 768px〜inner幅未満は 7.4vw ←(80px/1080px)×100
    } else {
      return 80; // inner幅以上は固定 80px
    }
  }
  
  // Swiperインスタンスを管理する変数
  let lessonSwiper;

  function initSwiper() {
    if (!document.querySelector(".js-lessonSwiper")) return;
    // 既存のSwiperを削除
    if (lessonSwiper) {
      lessonSwiper.destroy(true, true);
    }

    // 計算した spaceBetween を適用
    let spaceBetweenValue = getSpaceBetween();

    // Swiperを再初期化
    lessonSwiper = new Swiper(".js-lessonSwiper", {

      spaceBetween: spaceBetweenValue,
      slidesPerView: "auto",
      loop: true,
      loopedSlides: 4,
      speed: 800,
      autoHeight: false,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      a11y: {
        enabled: true,
        prevSlideMessage: '前へ',
        nextSlideMessage: '次へ',
      },
    });

  }

  // 初回実行
  initSwiper();

  // リサイズ時にSwiperを再初期化
  window.addEventListener("resize", initSwiper);

/* レッスン案内ページのタブ */
  const tabButtons = document.querySelectorAll(".tab-button");
  const tabPanels = document.querySelectorAll(".tab-panel");
  
  if (tabButtons.length && tabPanels.length) {
    tabButtons.forEach(button => {
      button.addEventListener("click", function () {
        const targetId = this.getAttribute("data-target");
        const targetPanel = document.querySelector(targetId);

        // ボタンのactive切り替え
        tabButtons.forEach(btn => btn.classList.remove("is-active"));
        this.classList.add("is-active");

        // パネルの表示切り替え
        tabPanels.forEach(panel => panel.classList.remove("is-active"));
        if (targetPanel) {
          targetPanel.classList.add("is-active");
        }
      });
    });
  }

  //タブ切り替え時のハッシュスクロール
  function scrollToHash() {
    const hash = window.location.hash;
    if (!hash) return;

    const header = document.querySelector(".header");
    const headerHeight = header ? header.offsetHeight : 0;
    const targetTabButton = document.querySelector(`[data-target="${hash}"]`);
    const targetPanel = document.querySelector(hash);

    if (targetTabButton && targetPanel) {
      document.querySelectorAll('.tab-button.is-active, .tab-panel.is-active').forEach(el => {
        el.classList.remove('is-active');
      });
      targetTabButton.classList.add('is-active');
      targetPanel.classList.add('is-active');

      setTimeout(() => {
        const buttonTop = targetTabButton.getBoundingClientRect().top + window.scrollY;
        window.scrollTo({
          top: buttonTop - headerHeight,
          behavior: 'smooth'
        });
      }, 100);
    }
    
    //sp-navが開いていたら閉じる
    const spNav = document.querySelector(".sp-nav");
    if (spNav && spNav.classList.contains("is-active")) {
      document
        .querySelectorAll(".js-hamburger, .header, .sp-nav")
        .forEach(el => el.classList.remove("is-active"));
  
      document.body.style.overflow = "auto";
    }
  }

  window.addEventListener('load', scrollToHash);
  window.addEventListener('hashchange', scrollToHash);


/* レッスンメニューページのカテゴリーボタンクリック時のスクロール */
  // ブラウザの自動スクロール復元を無効化
  if ("scrollRestoration" in history) {
    history.scrollRestoration = "manual";
  }

  /* カテゴリーボタンクリック時のみスクロール */
  document.querySelectorAll('.category-button').forEach(button => {
    button.addEventListener('click', () => {
      sessionStorage.setItem('scrollCategoryTop', 'true');
    });
  });

  window.addEventListener('load', () => {
    if (sessionStorage.getItem('scrollCategoryTop') !== 'true') return;
    sessionStorage.removeItem('scrollCategoryTop');
  
    const target = document.getElementById('category-top');
    if (!target) return;
  
    const headerHeight = document.querySelector('.header')?.offsetHeight || 0;
    const top = target.getBoundingClientRect().top + window.scrollY;
  
    window.scrollTo({
      top: top - headerHeight,
      behavior: 'smooth'
    });
  });


/* galleryのモーダル */
  const modal = document.getElementById('modal');
  if (modal) {
    const overlay = modal.querySelector('.modal__overlay');
    const content = modal.querySelector('.modal__content');

  // クリック時の処理
    if (window.innerWidth >= 768) {
    document.querySelectorAll('.gallery__item img').forEach(img => {
      img.addEventListener('click', () => {
        // モーダル内に画像を複製
        const clickedImg = img.cloneNode(true);
        content.innerHTML = '';
        content.appendChild(clickedImg);
        // モーダル表示 + スクロール禁止
        const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = scrollBarWidth + 'px';
        modal.setAttribute('aria-hidden', 'false');
      });
    });

  // 閉じる処理
    function closeModal() {
      modal.setAttribute('aria-hidden', 'true');
      content.innerHTML = '';
      document.body.style.overflow = '';
      document.body.style.paddingRight = '';
    }
    overlay.addEventListener('click', closeModal);
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
        closeModal();
        }
      });
    }
  }

/* トグル開閉 */
  function setupToggle({
    triggerSelector,
    groupSelector,
    contentSelector,
    openClass = 'is-open',
    enabled = () => true
  }) {
    document.querySelectorAll(triggerSelector).forEach(trigger => {
      const group = trigger.closest(groupSelector);
      const content = group.querySelector(contentSelector);

      if (!group) return;

      const applyState = (isOpen) => {
        group.classList.toggle(openClass, isOpen);
        trigger.setAttribute('aria-expanded', isOpen);
        if (content) {
          content.style.height = isOpen ? content.scrollHeight + 'px' : '0';
          content.style.opacity = isOpen ? '1' : '0';
        }
      };

      // 初期状態
      if (enabled()) {
        applyState(group.classList.contains(openClass));
      }

      trigger.addEventListener('click', () => {
        if (!enabled()) return;

        const expanded = trigger.getAttribute('aria-expanded') === 'true';
        applyState(!expanded);
      });
    });
  }

  //トップページのレッスン日程表
  setupToggle({
    triggerSelector: '.schedule-table td[rowspan]',
    groupSelector: '.schedule-table tbody',
    contentSelector: null,
    enabled: () => window.innerWidth < 768
  });
  
  //ブログサイドバーのアーカイブ
  setupToggle({
    triggerSelector: '.archive-list__year-button',
    groupSelector: '.archive-list__year',
    contentSelector: '.archive-list__months'
  });


/* お問い合わせとレッスン予約の送信 */
  //エラー時の処理
  document.addEventListener('wpcf7invalid', function() {

    //エラーメッセージの表示
    const errorContainer = document.querySelector('.contact__error') || document.querySelector('.reservation__error');
    if (errorContainer) {
      errorContainer.innerHTML = '※必須項目が入力されていません。<br>入力してください。';
      errorContainer.style.display = 'block';
  
      const headerOffset = document.querySelector('header').offsetHeight;
      const errorTop = errorContainer.getBoundingClientRect().top + window.scrollY;
      window.scrollTo({ top: errorTop - headerOffset, behavior: 'smooth' });
    }

    //エラー枠の強調
    setTimeout(() => {
      document.querySelectorAll('.wpcf7-not-valid').forEach(inputEl => {
        const row = inputEl.closest('.form__row');
        if (row) row.classList.add('form__row--error');
      });

      // acceptance チェックボックスの未チェックを直接判定
      const acceptanceInput = document.querySelector('.form__agreement input[type="checkbox"]');
      if (acceptanceInput && !acceptanceInput.checked) {
        const agreement = acceptanceInput.closest('.form__agreement');
        if (agreement) agreement.classList.add('form__agreement--error');
      }
    }, 10);
  });

  // 入力中にエラー枠の強調を外す
  document.addEventListener('input', function(event) {
    const row = event.target.closest('.form__row');
    if (row && row.classList.contains('form__row--error')) {
      row.classList.remove('form__row--error');
    }

    if (event.target.type === 'checkbox' && event.target.closest('.form__agreement')?.classList.contains('form__agreement--error')) {
      const agreement = event.target.closest('.form__agreement');
      agreement.classList.remove('form__agreement--error');
    }
  });

  //送信成功時の処理
  document.addEventListener('wpcf7mailsent', function(event) {
    const formId = event.detail.contactFormId;
  
    // お問い合わせフォーム
    if (formId === 5) {
      window.location.href = mySite.homeUrl + '/contact-thanks/';
    }
  
    // レッスン予約フォーム
    if (formId === 128) {
      window.location.href = mySite.homeUrl + '/reservation-thanks/';
    }
  });

/* フェードイン */
  const fadeInTargets = document.querySelectorAll(".js-fadeIn");

  const options = {
    threshold: 0.25,
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("is-active");
        observer.unobserve(entry.target);
      }
    });
  }, options);

  fadeInTargets.forEach((target) => observer.observe(target));