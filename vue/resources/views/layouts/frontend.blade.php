<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="apple-touch-icon" sizes="72x72" href="/vue/img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/vue/img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/vue/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/vue/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/vue/img/favicon-96x96.png">
        @php
            $url=url()->current();
        @endphp
    
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    

    
    
    <link rel="canonical" href="{{$url}}">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keyphrase" content="@yield('keyphrase')">
    
    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{$url}}">
    <meta property="og:image" content="/vue/img/welcome.webp">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:site_name" content="WriteMyPaperforMe.org">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@writemy_paper">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('description')">
    <meta name="twitter:image" content="/vue/img/welcome.webp">

    <script src="/writemypaperforme/asset/js/76332f5392c.js" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script src="/writemypaperforme/asset/build/runtime392c.js" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script src="/writemypaperforme/asset/build/js/Template/webpack_common_top_scripts392c.js" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <link rel="stylesheet" href="/writemypaperforme/asset/build/css/Template/site/Template/layout/common_head_styles392c.css">
    <link rel="stylesheet" href="/writemypaperforme/asset/build/css/Template/site/Template/layout/common_body.css">
    <link rel="stylesheet" href="/writemypaperforme/asset/build/css/Template/site/Template/layout_content/common_head_styles392c.css">
    
   
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Article",
          "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "https://writemypaperforme.org/"
          },
          "headline": "Write My Paper for Me",
          "description": "Paper writing services for all academic projects",
          "image": "https://writemypaperforme.org/favicon.webp",  
          "author": {
            "@type": "Organization",
            "name": "WriteMyPaperforMe.org",
            "url": "https://writemypaperforme.org/"
          },  
          "publisher": {
            "@type": "Organization",
            "logo": {
              "@type": "ImageObject",
              "url": "https://writemypaperforme.org/favicon.webp"
            }
          },
          "dateModified": "2023-09-21"
        }
    </script>
    
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "WriteMyPaperforMe.org",
          "url": "https://writemypaperforme.org/",
          "logo": "https://writemypaperforme.org/logo/logo.webp",
          "sameAs": [
            "https://www.facebook.com/writemypaperforme.org/",
            "https://twitter.com/writemy_paper",
            "https://www.instagram.com/writemypaperforme_org/",
            "https://www.pinterest.com/writemypaperforme_org/"
          ]
        }
    </script>
</head>

<body class="main-body-container ">
    @php
        $menus=App\Menu::orderBy('id','asc')->get();
    @endphp
    <header  class="{{ Request::is('/') ? 'page-header js_header__wrapper' : 'page-header js_header__wrapper inner-page header_in'}}">
        <div class="page-header__inner">
            <div class="row">
                <div class="page-header__content js_header__container">
                    <a href="/" class="logo"><img alt="WriteMyPaperforMe" src="/logo/logo.webp"  width="250" height="83"></a>
                    <div class="main-menu-v2 js_main-menu-v2 " data-heading="Browse categories" data-level="1">
                        <menu class="main-menu-v2__controls">
                            <li class="main-menu-v2__prev js_main-menu-prev"></li>
                        </menu>
                        @if($menus->count()>0)
                        @foreach ($menus as $menu )
                        @php
                            $pages=App\Blog::where('type',1)->where('menuitem',$menu->id)->orderBy('label','ASC')->get();
                        @endphp
                        @if($menu->id==1||$menu->id==2||$menu->id==5||$menu->id==6)
                        <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable">
                            <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim">
                                <span>{{$menu->menuname}}</span>
                            </div>
                             <div class="main-dropdown-v2 js_main-dropdown-v2">
                                <div class="main-dropdown-v2__left-side js_main-dropdown-left-side ">
                                    <div class="main-dropdown-v2__list js_main-dropdown-list">
                                        @if($pages->count())
                                        @foreach ($pages as $page )
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="/{{$page->slug}}" data-id=2>{{$page->label}}</a>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                             </div>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                    <div class="shadow-v2 js_shadow-v2" style="display: none"></div>
                    <script type="c897897d8e32f3103afbfe14-text/javascript">
                        document.addEventListener('DOMContentLoaded', function () {
                            new Header.DropdownMenu('', {
                                "toggleActiveLeftSide": true,
                                "highlightCurrentLink": true,
                                "breakpoint": 1176,
                                "mobileOnDesktopIfLogged": true,
                                "removeCloseBtn": true,
                                "defaultMenuPosition": "afterLogo"
                            });
                        })
                    </script>
                    <div class="page-header__user-controllers">
                        <a href="{{url('/login')}}" class="btn btn_second-accent">Log in</a>
                        <a href="/order" class="btn btn_main d-none-mobile">Hire Writer</a>
                        <div class="page-header__hamburger js_hamburger-menu-v4"><span class="page-header__hamburger-ico"><span></span></span></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
        @yield('content')
    <div>
        <footer class="footer"><br>
            <div class="row">
                <div class="footer__wrap"> 
                    <div class="footer__col df">
                        <a href="/"> <img alt="RPH" src="/logo/logo.webp"  loading="lazy" width="260" height="70" style="background:#056A20;border-radius:10px;"></a>
                        <p class="footer__text">WriteMyPaperforMe.org provides paper writing services for limited use only. The materials provided by our experts are intended to be used strictly as references for study purposes. We do not encourage or condone plagiarism.</p>
                    </div>
                    <div class="footer__col">
                        <div class="footer__title">ABOUT US:</div>
                        <div class="footer__section">
                            <div class="footer__section-content footer__text">
                                <p><a href="/about-us">About Us</a></p>
                                <p><a href="/how-it-works">How it works?</a></p>
                                <p><a href="/refund-policy">Refund Policy</a></p>
                                <p><a href="/revision-policy">Revision Policy</a></p>
                                <p><a href="/terms-and-conditions">Terms & Conditions</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="footer__col">
                        <div class="footer__title">Contact Us</div>
                        <div class="footer__section">
                            <div class="footer__section-content footer__text">
                                <a href="mailto:support@writemypaperforme.org">support@writemypaperforme.org</a>
                            </div><br>
                            <div class="footer__section-item footer__social-item">
                                <div>
                                    <a href="https://www.facebook.com/writemypaperforme.org/" target="_blank"><img src="/svg/fb.svg" alt="F" width="20" height="20"></a>
                                    <a href="https://www.instagram.com/writemypaperforme_org/" target="_blank"><img src="/svg/ig.svg" alt="I" width="20" height="20"></a>
                                    <a href="https://twitter.com/writemy_paper" target="_blank"><img src="/svg/twt.svg" alt="T" width="16" height="16"></a>
                                    <a href="https://www.pinterest.com/writemypaperforme_org/" target="_blank"><img src="/svg/pnt.svg" alt="Y" width="20" height="20"></a>
                                </div>
                            </div>
                             <div class="footer__col">
                                <img alt="paypal" src="/svg/paypal.webp" loading="lazy" width="280" height="30">
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="footer__wrap"> 
                    <div class="footer__col">
                        <div class="footer__section">
                            <div class="footer__section-content footer__text">
                                <p><a href="/">Write My Essay for Me</a></p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="footer__col">
                        <div class="footer__section">
                            <div class="footer__section-content footer__text">
                                <p><a href="/">Write My Assignment for Me</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="footer__col">
                        <div class="footer__section">
                            <div class="footer__section-content footer__text">
                                <p><a href="/">Write My Research for Me</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="footer__col">
                        <div class="footer__section">
                            <div class="footer__section-content footer__text">
                                <p><a href="/">Write My Projet for Me</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="footer__bottom-wrap">
                    <p>2024 © WriteMyPaperforMe.org. All Rights Reserved</p>
                </div>
            </div>
        </footer>
    </div>
    
    <link rel="stylesheet" href="/writemypaperforme/asset/build/css/Template/site/Template/layout/common_footer_styles392c.css?1608809042">
    <script data-cfasync="false" src="/writemypaperforme/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="/writemypaperforme/asset/build/js/Template/webpack_common_footer_scripts392c.js?1608809042"  type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script type="text/x-jquery-tmpl" id="popupSet">{%tmpl(this.data) $('#_default_popup_data').template()%}data-popup-click=""</script>
    <script type="text/x-jquery-tmpl" id="popupSetAutoOpen">{%tmpl(this.data) $('#_default_popup_data').template()%} data-popup-autoopen=""</script>
    <script type="text/x-jquery-tmpl" id="_default_popup_data">data-popup-target="${popup}" data-popup-data='${JSON.stringify(this.data)}'</script>
    <script type="text/x-jquery-tmpl" id="_popup_tpl"><div class="modal uk-modal fade modal-allow-user js_popup_all" role="dialog" aria-hidden="true" data-backdrop="static"><div class="modal-dialog"><div class="modal-content js_popup_content">{%tmpl(popup_data) $(popup_id).template()%} </div></div></div></script>
    <script type="c897897d8e32f3103afbfe14-text/javascript">
        new PopupBodyLoad.Core();
        $(document).on('popup_login_content_loaded', function () {
            new ShowHidePassword.Handler()
        });
        var headerController = new Header.HeaderController(807);
        $(document).on('event_order_create_success event_order_create_success_unauthorised', function () {
            headerController.recalculateMenuHeight();
        });
        if (document.querySelector('.js_user-balance')) {
            new Header.BalanceDropdown();
        }
        sbjs.init();
        document.addEventListener('DOMContentLoaded', function () {});
    </script>
    <script src="/writemypaperforme/asset/build/js/Template/header_banner392c.js?1608809042" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script src="/writemypaperforme/asset/build/js/Template/webpack_my_footer_scripts392c.js?1608809042" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script src="/writemypaperforme/asset/js/6bd2409392c.js?1608809042" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script type="c897897d8e32f3103afbfe14-text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var TABLET_WIDTH_IN_PX = 768;
            if (window.innerWidth < TABLET_WIDTH_IN_PX) {
                new Widget.SlideInBanner.Core('.js_slide_in_banner', '.js_slide_in_close');
            }
        });
    </script>
    <script src="/ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="c897897d8e32f3103afbfe14-|49" defer=""></script>
    
    <script>
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/63f4d4524247f20fefe1d0c8/1gpq5qpra';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>

	<script>
      let accordions = document.querySelectorAll('.accordion');
      let panels = document.querySelectorAll('.panel');
      accordions.forEach((accordion, index) => {
        accordion.addEventListener('click', function() {
          let isActive = this.classList.contains('active');
          panels.forEach(panel => {
            panel.style.display = 'none';
          });
          accordions.forEach(acc => {
            acc.classList.remove('active');
          });
          if (!isActive) {
            this.classList.toggle('active');
            panels[index].style.display = 'block';
          }
        });
      });
    </script>
    
	<script>
    document.addEventListener("DOMContentLoaded", function() {
        const testimonialWrapper = document.querySelector(".writers-wrapper");
        const prevArrow = document.querySelector(".prev-arrow");
        const nextArrow = document.querySelector(".next-arrow");
        const testimonialWidth = document.querySelector(".paper-writer").offsetWidth;
        let touchStartX = 0;
        let touchEndX = 0;

        let currentPosition = 0;
        let testimonialCount = testimonialWrapper.childElementCount;
        let currentSlide = 0;
        let autoSlideInterval;

        function slideTestimonials(direction) {
            if (direction === "prev") {
                currentPosition += testimonialWidth;
                currentSlide--;
                if (currentSlide < 0) {
                    currentSlide = testimonialCount - 1;
                    currentPosition = -testimonialWidth * (testimonialCount - 1);
                }
            } else if (direction === "next") {
                currentPosition -= testimonialWidth;
                currentSlide++;
                if (currentSlide === testimonialCount) {
                    currentSlide = 0;
                    currentPosition = 0;
                }
            }
            testimonialWrapper.style.transform = `translateX(${currentPosition}px)`;
            }
            function startAutoSlide() {
                autoSlideInterval = setInterval(function() {
                    slideTestimonials("next");
                }, 5000);
            }
            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }
            function handleTouchStart(event) {
                touchStartX = event.touches[0].clientX;
            }
            function handleTouchEnd(event) {
                touchEndX = event.changedTouches[0].clientX;
                handleSwipe();
            }
            function handleSwipe() {
                const swipeDistance = touchEndX - touchStartX;
                if (swipeDistance > 0) {
                    stopAutoSlide();
                    slideTestimonials("prev");
                    startAutoSlide();
                } else if (swipeDistance < 0) {
                    stopAutoSlide();
                    slideTestimonials("next");
                    startAutoSlide();
                }
            }
            prevArrow.addEventListener("click", function() {
                stopAutoSlide();
                slideTestimonials("prev");
                startAutoSlide();
            });
            nextArrow.addEventListener("click", function() {
                stopAutoSlide();
                slideTestimonials("next");
                startAutoSlide();
            });
            testimonialWrapper.addEventListener("mouseover", function() {
                stopAutoSlide();
            });
            testimonialWrapper.addEventListener("mouseout", function() {
                startAutoSlide();
            });
            testimonialWrapper.addEventListener("touchstart", handleTouchStart);
            testimonialWrapper.addEventListener("touchend", handleTouchEnd);
    
            function autoSlideTestimonials() {
                slideTestimonials("next");
            }
            startAutoSlide();
        });
    </script>
    
    <script>
        let lastScrollTop = 0;
        
        function toggleReadMore() {
            const dots = document.getElementById("dots");
            const moreText = document.getElementById("more");
            const btnText = document.getElementById("readMoreBtn");
    
            if (dots.style.display === "none") {
                // Scroll back to the previous position
                window.scrollTo(0, lastScrollTop);
                dots.style.display = "inline";
                btnText.innerHTML = "Read More";
                moreText.style.display = "none";
            } else {
                // Save the current scroll position
                lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
                dots.style.display = "none";
                btnText.innerHTML = "Read Less";
                moreText.style.display = "block";
            }
        }
    </script>
    
    <script>
      const headings = document.querySelectorAll('.blogcont > h3');
      const tocList = document.createElement('ul');
    
      headings.forEach((heading, index) => {
        const listItem = document.createElement('li');
        const anchor = document.createElement('a');
        const sectionId = `section-${index + 1}`;
    
        anchor.href = `#${sectionId}`;
        anchor.textContent = heading.textContent;
    
        heading.id = sectionId;
    
        anchor.addEventListener('click', (event) => {
          event.preventDefault();
    
          const offset = 88;
          const targetId = event.target.getAttribute('href').substring(1); 
    
          const targetElement = document.getElementById(targetId);
          const targetOffsetTop = targetElement.offsetTop - offset;
    
          window.scrollTo({
            top: targetOffsetTop,
            behavior: 'smooth'
          });
        });
    
        listItem.appendChild(anchor);
        tocList.appendChild(listItem);
      });
    
      const tableOfContents = document.getElementById('tableOfContents');
      tableOfContents.appendChild(tocList);
    </script>

</body>
</html>
