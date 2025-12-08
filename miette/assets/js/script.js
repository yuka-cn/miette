"use strict";

/* ----------------------------------------------------
 * jQuery scripts
 * ---------------------------------------------------- */

jQuery(function ($) {
  /* pcの初回表示のみローディングアニメーション */
  // if (window.matchMedia("(max-width: 767px)").matches) {
  //   mvSwiper();
  // } else {
  //   const loadingEl = document.querySelector(".loading");
  //   const header = document.querySelector(".header");
  //   const mvHeader = document.querySelector(".mv__header");
  //   const isFirstVisit = !sessionStorage.getItem("firstVisit");

  //   if (loadingEl && isFirstVisit) {
  //     sessionStorage.setItem("firstVisit", "done");

  //     loadingEl.style.display = "block";
  //     document.body.style.overflow = "hidden";
  //     loadingEl.addEventListener("animationend", function () {
  //       if(mvHeader){
  //         mvHeader.style.opacity = "1";
  //       }
  //       setTimeout(mvSwiper, 1000);
  //       setTimeout(function () {
  //         loadingEl.style.opacity = "0";
  //       }, 1000);
  //       setTimeout(function () {
  //         loadingEl.style.display = "none";
  //         document.body.style.overflow = "";
  //       }, 2000);
  //     });
  //   } else {
  //     if(mvHeader){
  //       mvHeader.style.opacity = "1";
  //     }
  //     if (header) {
  //       header.classList.remove("header--top");
  //     }
  //     mvSwiper();
  //   }
  // }

  /* スクロール位置に応じて、ヘッダーの背景色とロゴ・ハンバーガーメニューの色を変える */
  var header = $(".header");
  var logo = $(".header__logolink img");
  var hamburger = $(".hamburger");
  var pcNav = $(".pc-nav");
  function checkScroll() {
    var headerHeight = header.height();
    var isFront = $(".mv").length > 0; // front-page を判定
    var target = isFront ? $(".mv") : $(".page-header__image");
    var height = target.height();
    var scrollTop = $(window).scrollTop();
    if (scrollTop > height - headerHeight) {
      if (isFront) {
        header.addClass("is-show");
        hamburger.addClass("is-color");
        logo.attr("src", logo.data("color"));
      } else {
        header.addClass("is-color");
        hamburger.addClass("is-color");
        pcNav.addClass("is-color");
        logo.attr("src", logo.data("color"));
      }
    } else {
      if (isFront) {
        header.removeClass("is-show");
      } else {
        header.removeClass("is-color");
        hamburger.removeClass("is-color");
        pcNav.removeClass("is-color");
        logo.attr("src", logo.data("white"));
      }
    }
  }
  $(window).scroll(checkScroll);
  checkScroll();

  /* ハンバーガーメニュー */
  hamburger.click(function () {
    $(".js-hamburger, .header, .sp-nav").toggleClass("is-active");
    if ($(this).hasClass("is-active")) {
      $("body").css("overflow", "hidden");
      logo.attr("src", logo.data("white"));
    } else {
      $("body").css("overflow", "auto");
      checkScroll();
    }
  });

  //pc画面幅ではハンバーガーメニューを非表示にする
  $(window).resize(function () {
    if ($(window).width() >= 768) {
      $(".sp-nav").removeClass("is-active").css("display", "");
      $(".header").removeClass("is-active").css("display", "");
    }
  });

  /* topへ戻るボタン */
  var topBtn = $(".to-top");
  topBtn.hide();

  // ボタンの表示設定
  $(window).scroll(function () {
    if ($(this).scrollTop() > 90) {
      // 指定px以上のスクロールでボタンを表示
      topBtn.fadeIn();
    } else {
      // 画面が指定pxより上ならボタンを非表示
      topBtn.fadeOut();
    }
  });

  // ボタンをクリックしたらスクロールして上に戻る
  topBtn.click(function () {
    $("body,html").animate({
      scrollTop: 0
    }, 300, "swing");
    return false;
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
    autoHeight: true,
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

//ハッシュリンク対応スクロール
function scrollToHash() {
  var hash = window.location.hash;
  if (!hash) return;
  var headerOffset = document.querySelector('header').offsetHeight;

  //informationページ
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
      top: buttonTop - headerOffset,
      behavior: 'smooth'
    });
  } else {
    //priceページ
    var targetSection = document.querySelector(hash);
    if (targetSection) {
      var sectionTop = targetSection.getBoundingClientRect().top + window.scrollY;
      window.scrollTo({
        top: sectionTop - headerOffset,
        behavior: 'smooth'
      });
    }
  }

  //sp-navが開いていたら閉じる
  if ($(".sp-nav").hasClass("is-active")) {
    $(".js-hamburger, .header, .sp-nav").removeClass("is-active");
    $("body").css("overflow", "auto");
  }
}
window.addEventListener('load', scrollToHash);
window.addEventListener('hashchange', scrollToHash);

// サイドバーのアーカイブ開閉
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
  window.location.href = mySite.homeUrl + '/thanks/';
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