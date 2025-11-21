"use strict";

jQuery(function ($) {
  // この中であればWordpressでも「$」が使用可能になる

  // メインビューのスライダー
  function mvSwiper() {
    if (document.querySelector(".js-mvSwiper")) {
      new Swiper(".js-mvSwiper", {
        effect: "fade",
        fadeEffect: {
          crossFade: true
        },
        speed: 3000,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false
        },
        loop: true
      });
    }
  }

  // pcの初回表示のみローディングアニメーション
  if (window.matchMedia("(max-width: 767px)").matches) {
    mvSwiper();
  } else {
    var loadingEl = document.querySelector(".loading");
    var _header = document.querySelector(".header");
    var mvHeader = document.querySelector(".mv__header");
    var isFirstVisit = !sessionStorage.getItem("firstVisit");
    if (loadingEl && isFirstVisit) {
      sessionStorage.setItem("firstVisit", "done");
      loadingEl.style.display = "block";
      document.body.style.overflow = "hidden";
      loadingEl.addEventListener("animationend", function () {
        if (mvHeader) {
          mvHeader.style.opacity = "1";
        }
        setTimeout(mvSwiper, 1000);
        setTimeout(function () {
          loadingEl.style.opacity = "0";
        }, 1000);
        setTimeout(function () {
          loadingEl.style.display = "none";
          document.body.style.overflow = "";
        }, 2000);
      });
    } else {
      if (mvHeader) {
        mvHeader.style.opacity = "1";
      }
      if (_header) {
        _header.classList.remove("header--top");
      }
      mvSwiper();
    }
  }

  // MVやページヘッダーとヘッダーの下ラインが重なった時に、ヘッダーに背景色をつける
  var header = $(".header");
  var headerHeight = $(".header").height();
  var target = $(".mv").length ? $(".mv") : $(".page-header__image");
  var height = target.height();
  $(window).scroll(function () {
    if ($(this).scrollTop() > height - headerHeight) {
      header.addClass("is-color");
    } else {
      header.removeClass("is-color");
    }
  });

  //ドロワーメニュー
  $(function () {
    $(".js-hamburger").click(function () {
      $(".js-hamburger, .header, .js-sp-nav").toggleClass("is-active");
      if ($(".js-hamburger").hasClass("is-active")) {
        $("body").css("overflow", "hidden"); //背景がスクロールされないようにする
      } else {
        $("body").css("overflow", "auto");
      }
    });
  });

  //pc画面幅ではドロワーメニューを非表示にする
  $(window).resize(function () {
    if ($(window).width() >= 768) {
      $(".js-sp-nav").removeClass("is-active").css("display", ""); // is-active を削除
      $(".header").removeClass("is-active").css("display", ""); // is-active を削除
    }
  });

  // キャンペーンカードのスライダー
  // inner幅の基準値を設定
  var INNER_WIDTH = 1080;

  // SwiperのspaceBetweenを計算
  function getSpaceBetween() {
    var windowWidth = window.innerWidth;
    if (windowWidth <= 375) {
      return windowWidth * (6.4 / 100); // 375px以下は 6.4vw ←(24px/375px)×100
    } else if (windowWidth > 375 && windowWidth < 768) {
      return 24; // 376px〜767px は固定 24px
    } else if (windowWidth >= 768 && windowWidth < INNER_WIDTH) {
      return windowWidth * (3.7 / 100); // 768px〜inner幅未満は 3.7vw ←(40px/1080px)×100
    } else {
      return 40; // inner幅以上は固定 40px
    }
  }

  // Swiperインスタンスを管理する変数
  var campaignSwiper;
  function initSwiper() {
    if (!document.querySelector(".js-campaignSwiper")) return;
    // 既存のSwiperを削除
    if (campaignSwiper) {
      campaignSwiper.destroy(true, true);
    }

    // 計算した spaceBetween を適用
    var spaceBetweenValue = getSpaceBetween();

    // Swiperを再初期化
    campaignSwiper = new Swiper(".js-campaignSwiper", {
      spaceBetween: spaceBetweenValue,
      slidesPerView: "auto",
      loop: true,
      loopedSlides: 4,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
      },
      autoplay: {
        delay: 2000,
        disableOnInteraction: false
      }
    });
  }

  // 初回実行
  initSwiper();

  // リサイズ時にSwiperを再初期化
  window.addEventListener("resize", initSwiper);

  // 画像アニメーション
  // 要素の取得とスピードの設定
  var imageAnimation = $(".information__image, .voice-card__image, .price__image"),
    speed = 700;

  // ..information__image, .voice-card__image, .price__image の付いた全ての要素に対して処理を行う
  if (imageAnimation.length) {
    imageAnimation.each(function () {
      var $this = $(this);

      // <div class="color"></div> を追加
      $this.append('<div class="color"></div>');
      var color = $this.find(".color"),
        image = $this.find("img"),
        counter = 0;

      // 初期スタイル設定
      image.css("opacity", "0");
      color.css("width", "0%");

      // inviewイベントを適用（背景色が画面に現れたら処理をする）
      $this.on("inview", function (event, isInView) {
        if (isInView && counter === 0) {
          color.delay(200).animate({
            width: "100%"
          }, speed, function () {
            image.css("opacity", "1");
            $(this).css({
              left: "0",
              right: "auto"
            });
            $(this).animate({
              width: "0%"
            }, speed);
          });
          counter = 1; // 2回目の起動を制御
        }
      });
    });
  }

  // topへ戻るボタン
  var topBtn = $(".c-to-top");
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

  // aboutページのモーダル
  var modal = document.getElementById('modal');
  if (modal) {
    var overlay = modal.querySelector('.modal__overlay');
    var backgroundInner = modal.querySelector('.modal__background .inner');
    var content = modal.querySelector('.modal__content');

    // クリック時の処理
    if (window.innerWidth >= 768) {
      // 閉じる処理
      var closeModal = function closeModal() {
        modal.setAttribute('aria-hidden', 'true');
        content.innerHTML = '';
        backgroundInner.innerHTML = '';
        document.body.style.overflow = '';
      };
      document.querySelectorAll('.gallery__item img').forEach(function (img) {
        img.addEventListener('click', function () {
          var column = img.closest('.gallery__column');
          if (!column) return;
          // モーダル内に画像を複製
          var clickedImg = img.cloneNode(true);
          content.innerHTML = '';
          content.appendChild(clickedImg);
          // 背景として.gallery__columnを複製
          backgroundInner.innerHTML = '';
          backgroundInner.appendChild(column.cloneNode(true));
          // モーダル表示 + スクロール禁止
          document.body.style.overflow = 'hidden';
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

  // informationのタブ
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
    if ($(".js-sp-nav").hasClass("is-active")) {
      $(".js-hamburger, .header, .js-sp-nav").removeClass("is-active");
      $("body").css("overflow", "auto");
    }
  }
  window.addEventListener('load', scrollToHash);
  window.addEventListener('hashchange', scrollToHash);

  // サイドバーのアーカイブ開閉
  document.addEventListener('DOMContentLoaded', function () {
    var archiveYears = document.querySelectorAll('.archive-list__year');
    archiveYears.forEach(function (year) {
      var button = year.querySelector('.archive-list__year-button');
      var months = year.querySelector('.archive-list__months');
      if (!button || !months) return;

      // 初期ARIAセット
      var isOpen = year.classList.contains('is-open');
      var monthsId = months.id || "archive-months-".concat(Math.random().toString(36).slice(2, 9));
      months.id = monthsId;
      button.setAttribute('aria-controls', monthsId);
      button.setAttribute('aria-expanded', String(isOpen));
      months.hidden = !isOpen;

      // クリックでトグル
      button.addEventListener('click', function () {
        var expanded = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', String(!expanded));
        year.classList.toggle('is-open');
        months.hidden = expanded;
      });
    });
  });

  //contact
  //独自送信ボタン
  var submitBtn = document.getElementById('submit');
  if (submitBtn) {
    submitBtn.addEventListener('click', function () {
      var form = document.getElementById('my-cf7-form');
      if (form) {
        var submitEvent = new Event('submit', {
          bubbles: true,
          cancelable: true
        });
        form.dispatchEvent(submitEvent);
      }
    });
  }

  //エラー時の処理
  document.addEventListener('wpcf7invalid', function () {
    //エラーメッセージの表示
    var errorContainer = document.querySelector('.page-contact__error');
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
});