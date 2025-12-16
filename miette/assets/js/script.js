"use strict";

/* ----------------------------------------------------
 * jQuery scripts
 * ---------------------------------------------------- */

jQuery(function ($) {
  /* 予約ページの希望日程 */
  // 選択クラスに応じて日程を更新する
  $('input[name="lesson_class"]').on('change', function () {
    var className = $(this).val();
    var select = $('#schedule');
    select.empty();
    $.ajax({
      url: wpAjax.ajaxurl,
      type: 'POST',
      data: {
        action: 'get_class_dates',
        class_name: className
      },
      success: function success(options) {
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
document.addEventListener('DOMContentLoaded', function () {
  var loading = document.getElementById('loading');
  var logo = document.querySelector('.loading__logo');
  if (!loading || !logo) return;
  var isVisited = sessionStorage.getItem('visited');
  if (!isVisited) {
    sessionStorage.setItem('visited', 'true');
    document.body.classList.add('is-loading');

    // reduced-motionでanimationedが発火しなくてもローディング終了
    var fallbackTimer = setTimeout(function () {
      loading.style.display = 'none';
      document.body.classList.remove('is-loading');
      document.body.classList.add('is-loaded');
    }, 2000);
    logo.addEventListener('animationend', function () {
      clearTimeout(fallbackTimer);
      loading.style.display = 'none';
      document.body.classList.remove('is-loading');
      document.body.classList.add('is-loaded');
    }, {
      once: true
    });
  } else {
    loading.style.display = 'none';
    document.body.classList.add('is-loaded');
  }
});

/* スクロール位置に応じてヘッダーの色を切り替える */
{
  var checkScroll = function checkScroll() {
    if (!header) return;
    var headerHeight = header.offsetHeight;
    var isFront = document.querySelector('.mv') !== null;
    var target = isFront ? document.querySelector('.mv') : document.querySelector('.page-header__image');
    if (!target) return;
    var scrollTop = window.pageYOffset;
    var over = scrollTop > target.offsetHeight - headerHeight;
    if (over) {
      hamburger === null || hamburger === void 0 ? void 0 : hamburger.classList.add('is-color');
      pcNav === null || pcNav === void 0 ? void 0 : pcNav.classList.add('is-color');
      logo === null || logo === void 0 ? void 0 : logo.setAttribute('src', logo.dataset.color);
      header.classList.toggle('is-show', isFront);
      header.classList.toggle('is-color', !isFront);
    } else {
      hamburger === null || hamburger === void 0 ? void 0 : hamburger.classList.remove('is-color');
      pcNav === null || pcNav === void 0 ? void 0 : pcNav.classList.remove('is-color');
      logo === null || logo === void 0 ? void 0 : logo.setAttribute('src', logo.dataset.white);
      header.classList.remove('is-show');
      header.classList.remove('is-color');
    }
  };
  var header = document.querySelector('.header');
  var logo = document.querySelector('.header__logolink img');
  var hamburger = document.querySelector('.hamburger');
  var pcNav = document.querySelector('.pc-nav');
  window.addEventListener('scroll', checkScroll, {
    passive: true
  });
  checkScroll();

  // ハンバーガー閉時にロゴ・ヘッダーの色を更新するためのカスタムイベント
  window.addEventListener('forceScrollCheck', checkScroll);
}

/* ハンバーガーメニュー */
{
  var _hamburger = document.querySelector('.hamburger');
  var _header = document.querySelector('.header');
  var spNav = document.querySelector('.sp-nav');
  var _logo = document.querySelector('.header__logolink img');
  _hamburger && _hamburger.addEventListener('click', function () {
    _hamburger.classList.toggle('is-active');
    _header === null || _header === void 0 ? void 0 : _header.classList.toggle('is-active');
    spNav === null || spNav === void 0 ? void 0 : spNav.classList.toggle('is-active');
    var isActive = _hamburger.classList.contains('is-active');
    _hamburger.setAttribute('aria-expanded', isActive);
    _hamburger.setAttribute('aria-label', isActive ? 'メニューを閉じる' : 'メニューを開く');
    if (isActive) {
      document.body.style.overflow = 'hidden';
      _logo === null || _logo === void 0 ? void 0 : _logo.setAttribute('src', _logo.dataset.white);
    } else {
      document.body.style.overflow = '';
      window.dispatchEvent(new Event('forceScrollCheck'));
    }
  });

  //pc画面幅ではハンバーガーメニューを非表示にする
  window.addEventListener('resize', function () {
    if (window.innerWidth >= 768) {
      spNav === null || spNav === void 0 ? void 0 : spNav.classList.remove('is-active');
      _header === null || _header === void 0 ? void 0 : _header.classList.remove('is-active');
      spNav === null || spNav === void 0 ? void 0 : spNav.style.removeProperty('display');
      _header === null || _header === void 0 ? void 0 : _header.style.removeProperty('display');
    }
  });
}

/* トップに戻るボタン */
{
  var topBtn = document.querySelector('.to-top');
  if (topBtn) {
    var toggleTopButton = function toggleTopButton() {
      topBtn.classList.toggle('is-show', window.scrollY > 90);
    };
    window.addEventListener('scroll', toggleTopButton, {
      passive: true
    });
    toggleTopButton();
    topBtn.addEventListener('click', function (e) {
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
var INNER_WIDTH = 1080;

// SwiperのspaceBetweenを計算
function getSpaceBetween() {
  var windowWidth = window.innerWidth;
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
var lessonSwiper;
function initSwiper() {
  if (!document.querySelector(".js-lessonSwiper")) return;
  // 既存のSwiperを削除
  if (lessonSwiper) {
    lessonSwiper.destroy(true, true);
  }

  // 計算した spaceBetween を適用
  var spaceBetweenValue = getSpaceBetween();

  // Swiperを再初期化
  lessonSwiper = new Swiper(".js-lessonSwiper", {
    spaceBetween: spaceBetweenValue,
    slidesPerView: "auto",
    loop: true,
    loopedSlides: 4,
    speed: 1500,
    autoHeight: false,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    },
    a11y: {
      enabled: true,
      prevSlideMessage: '前へ',
      nextSlideMessage: '次へ'
    }
  });
}

// 初回実行
initSwiper();

// リサイズ時にSwiperを再初期化
window.addEventListener("resize", initSwiper);

/* レッスン案内ページのタブ */
var tabButtons = document.querySelectorAll(".tab-button");
var tabPanels = document.querySelectorAll(".tab-panel");
if (tabButtons.length && tabPanels.length) {
  tabButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      var targetId = this.getAttribute("data-target");
      var targetPanel = document.querySelector(targetId);

      // ボタンのactive切り替え
      tabButtons.forEach(function (btn) {
        return btn.classList.remove("is-active");
      });
      this.classList.add("is-active");

      // パネルの表示切り替え
      tabPanels.forEach(function (panel) {
        return panel.classList.remove("is-active");
      });
      if (targetPanel) {
        targetPanel.classList.add("is-active");
      }
    });
  });
}

//タブ切り替え時のハッシュスクロール
function scrollToHash() {
  var hash = window.location.hash;
  if (!hash) return;
  var header = document.querySelector(".header");
  var headerHeight = header ? header.offsetHeight : 0;
  var targetTabButton = document.querySelector("[data-target=\"".concat(hash, "\"]"));
  var targetPanel = document.querySelector(hash);
  if (targetTabButton && targetPanel) {
    document.querySelectorAll('.tab-button.is-active, .tab-panel.is-active').forEach(function (el) {
      el.classList.remove('is-active');
    });
    targetTabButton.classList.add('is-active');
    targetPanel.classList.add('is-active');
    var buttonTop = targetTabButton.getBoundingClientRect().top + window.scrollY;
    window.scrollTo({
      top: buttonTop - headerHeight,
      behavior: 'smooth'
    });
  }

  //sp-navが開いていたら閉じる
  var spNav = document.querySelector(".sp-nav");
  if (spNav && spNav.classList.contains("is-active")) {
    document.querySelectorAll(".js-hamburger, .header, .sp-nav").forEach(function (el) {
      return el.classList.remove("is-active");
    });
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
document.querySelectorAll('.category-button').forEach(function (button) {
  button.addEventListener('click', function () {
    sessionStorage.setItem('scrollCategoryTop', 'true');
  });
});
window.addEventListener('load', function () {
  var _document$querySelect;
  if (sessionStorage.getItem('scrollCategoryTop') !== 'true') return;
  sessionStorage.removeItem('scrollCategoryTop');
  var target = document.getElementById('category-top');
  if (!target) return;
  var headerHeight = ((_document$querySelect = document.querySelector('.header')) === null || _document$querySelect === void 0 ? void 0 : _document$querySelect.offsetHeight) || 0;
  var top = target.getBoundingClientRect().top + window.scrollY;
  window.scrollTo({
    top: top - headerHeight,
    behavior: 'smooth'
  });
});

/* galleryのモーダル */
var modal = document.getElementById('modal');
if (modal) {
  var overlay = modal.querySelector('.modal__overlay');
  var content = modal.querySelector('.modal__content');

  // クリック時の処理
  if (window.innerWidth >= 768) {
    // 閉じる処理
    var closeModal = function closeModal() {
      modal.setAttribute('aria-hidden', 'true');
      content.innerHTML = '';
      document.body.style.overflow = '';
      document.body.style.paddingRight = '';
    };
    document.querySelectorAll('.gallery__item img').forEach(function (img) {
      img.addEventListener('click', function () {
        // モーダル内に画像を複製
        var clickedImg = img.cloneNode(true);
        content.innerHTML = '';
        content.appendChild(clickedImg);
        // モーダル表示 + スクロール禁止
        var scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = scrollBarWidth + 'px';
        modal.setAttribute('aria-hidden', 'false');
      });
    });
    overlay.addEventListener('click', closeModal);
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
        closeModal();
      }
    });
  }
}

/* サイドバーのアーカイブ開閉 */
document.querySelectorAll('.archive-list__year-button').forEach(function (button) {
  var year = button.closest('.archive-list__year');
  var months = year.querySelector('.archive-list__months');

  // 初期状態
  var isOpen = year.classList.contains('is-open');
  months.style.height = isOpen ? months.scrollHeight + 'px' : '0';
  button.setAttribute('aria-expanded', isOpen);

  // クリックイベント
  button.addEventListener('click', function () {
    var expanded = button.getAttribute('aria-expanded') === 'true';
    button.setAttribute('aria-expanded', String(!expanded));
    year.classList.toggle('is-open');
    if (!expanded) {
      months.style.height = months.scrollHeight + 'px';
      months.style.opacity = '1';
    } else {
      months.style.height = '0';
      months.style.opacity = '0';
    }
  });
});

/* お問い合わせとレッスン予約の送信 */
//エラー時の処理
document.addEventListener('wpcf7invalid', function () {
  //エラーメッセージの表示
  var errorContainer = document.querySelector('.contact__error') || document.querySelector('.reservation__error');
  if (errorContainer) {
    errorContainer.innerHTML = '※必須項目が入力されていません。<br>入力してください。';
    errorContainer.style.display = 'block';
    var headerOffset = document.querySelector('header').offsetHeight;
    var errorTop = errorContainer.getBoundingClientRect().top + window.scrollY;
    window.scrollTo({
      top: errorTop - headerOffset,
      behavior: 'smooth'
    });
  }

  //エラー枠の強調
  setTimeout(function () {
    document.querySelectorAll('.wpcf7-not-valid').forEach(function (inputEl) {
      var row = inputEl.closest('.form__row');
      if (row) row.classList.add('form__row--error');
    });

    // acceptance チェックボックスの未チェックを直接判定
    var acceptanceInput = document.querySelector('.form__agreement input[type="checkbox"]');
    if (acceptanceInput && !acceptanceInput.checked) {
      var agreement = acceptanceInput.closest('.form__agreement');
      if (agreement) agreement.classList.add('form__agreement--error');
    }
  }, 10);
});

// 入力中にエラー枠の強調を外す
document.addEventListener('input', function (event) {
  var _event$target$closest;
  var row = event.target.closest('.form__row');
  if (row && row.classList.contains('form__row--error')) {
    row.classList.remove('form__row--error');
  }
  if (event.target.type === 'checkbox' && (_event$target$closest = event.target.closest('.form__agreement')) !== null && _event$target$closest !== void 0 && _event$target$closest.classList.contains('form__agreement--error')) {
    var agreement = event.target.closest('.form__agreement');
    agreement.classList.remove('form__agreement--error');
  }
});

//送信成功時の処理
document.addEventListener('wpcf7mailsent', function (event) {
  var formId = event.detail.contactFormId;

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
var fadeInTargets = document.querySelectorAll(".js-fadeIn");
var options = {
  threshold: 0.25
};
var observer = new IntersectionObserver(function (entries) {
  entries.forEach(function (entry) {
    if (entry.isIntersecting) {
      entry.target.classList.add("is-active");
      observer.unobserve(entry.target);
    }
  });
}, options);
fadeInTargets.forEach(function (target) {
  return observer.observe(target);
});