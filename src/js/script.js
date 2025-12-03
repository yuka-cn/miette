jQuery(function ($) {
  // この中であればWordpressでも「$」が使用可能になる

// pcの初回表示のみローディングアニメーション
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

  // スクロール位置に応じて、ヘッダーの背景色とロゴ・ハンバーガーメニューの色を変える
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

  // ハンバーガーメニュー
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

  //pc画面幅ではドロワーメニューを非表示にする
  $(window).resize(function () {
    if ($(window).width() >= 768) {
      $(".sp-nav").removeClass("is-active").css("display", "");
      $(".header").removeClass("is-active").css("display", "");
    }
  });

// レッスンメニューカードのスライダー
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
      speed: 3000,
      autoHeight: true,
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

// 画像アニメーション
  // 要素の取得とスピードの設定
  let imageAnimation = $(".information__image, .voice-card__image, .price__image"),
    speed = 700;

  // ..information__image, .voice-card__image, .price__image の付いた全ての要素に対して処理を行う
  if (imageAnimation.length) {
    imageAnimation.each(function () {
      let $this = $(this);

      // <div class="color"></div> を追加
      $this.append('<div class="color"></div>');

      let color = $this.find(".color"),
        image = $this.find("img"),
        counter = 0;

      // 初期スタイル設定
      image.css("opacity", "0");
      color.css("width", "0%");

      // inviewイベントを適用（背景色が画面に現れたら処理をする）
      $this.on("inview", function (event, isInView) {
        if (isInView && counter === 0) {
          color.delay(200).animate({ width: "100%" }, speed, function () {
            image.css("opacity", "1");
            $(this).css({ left: "0", right: "auto" });
            $(this).animate({ width: "0%" }, speed);
          });
          counter = 1; // 2回目の起動を制御
        }
      });
    });
  }

// topへ戻るボタン
  let topBtn = $(".to-top");
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
    $("body,html").animate(
      {
        scrollTop: 0,
      },
      300,
      "swing"
    );
    return false;
  });


// aboutページのモーダル
  const modal = document.getElementById('modal');
  if (modal) {
    const overlay = modal.querySelector('.modal__overlay');
    const backgroundInner = modal.querySelector('.modal__background .inner');
    const content = modal.querySelector('.modal__content');

  // クリック時の処理
    if (window.innerWidth >= 768) {
    document.querySelectorAll('.gallery__item img').forEach(img => {
      img.addEventListener('click', () => {
        const column = img.closest('.gallery__column');
        if (!column) return;
        // モーダル内に画像を複製
        const clickedImg = img.cloneNode(true);
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

  // 閉じる処理
    function closeModal() {
      modal.setAttribute('aria-hidden', 'true');
      content.innerHTML = '';
      backgroundInner.innerHTML = '';
      document.body.style.overflow = '';
    }
    overlay.addEventListener('click', closeModal);
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
        closeModal();
        }
      });
    }
  }

// informationのタブ
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

  //ハッシュリンク対応スクロール
  function scrollToHash() {
    const hash = window.location.hash;
    if (!hash) return;

    const headerOffset = document.querySelector('header').offsetHeight;

    //informationページ
    const targetTabButton = document.querySelector(`[data-target="${hash}"]`);
    const targetPanel = document.querySelector(hash);

    if (targetTabButton && targetPanel) {
      document.querySelectorAll('.tab-button.is-active, .tab-panel.is-active').forEach(el => {
        el.classList.remove('is-active');
      });
      targetTabButton.classList.add('is-active');
      targetPanel.classList.add('is-active');

      const buttonTop = targetTabButton.getBoundingClientRect().top + window.scrollY;
      window.scrollTo({ top: buttonTop - headerOffset, behavior: 'smooth' });
    } else{

    //priceページ
      const targetSection = document.querySelector(hash);

      if (targetSection) {
        const sectionTop = targetSection.getBoundingClientRect().top + window.scrollY;
        window.scrollTo({ top: sectionTop - headerOffset, behavior: 'smooth' });
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
document.querySelectorAll('.archive-list__year-button').forEach(button => {
  const year = button.closest('.archive-list__year');
  const months = year.querySelector('.archive-list__months');

  // 初期状態
  const isOpen = year.classList.contains('is-open');
  months.style.height = isOpen ? months.scrollHeight + 'px' : '0';
  button.setAttribute('aria-expanded', isOpen);

  // クリックイベント
  button.addEventListener('click', () => {
    const expanded = button.getAttribute('aria-expanded') === 'true';
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



//contact
  //独自送信ボタン
  const submitBtn = document.getElementById('submit');
  if (submitBtn) {
    submitBtn.addEventListener('click', function() {
      const form = document.getElementById('my-cf7-form');
      if (form) {
        const submitEvent = new Event('submit', { bubbles: true, cancelable: true });
        form.dispatchEvent(submitEvent);
      }
    });
  }

  //エラー時の処理
  document.addEventListener('wpcf7invalid', function() {

    //エラーメッセージの表示
    const errorContainer = document.querySelector('.contact__error');
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
    window.location.href = mySite.homeUrl + '/thanks/';
  });
});
