<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    
    <link rel="apple-touch-icon" sizes="72x72" href="/vue/img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/vue/img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/vue/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/vue/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/vue/img/favicon-96x96.png">

   <title>@yield('title') | WriteMyPaperforMe.org</title>
    
    <script src="{{ URL::asset('writemypaperforme/asset/js/76332f5392c.js') }}" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script src="{{ URL::asset('writemypaperforme/asset/build/runtime392c.js') }}" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script src="{{ URL::asset('writemypaperforme/asset/build/js/Template/webpack_common_top_scripts392c.js') }}" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <link href="{{ URL::asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('writemypaperforme/asset/build/css/Template/site/Template/layout/common_head_styles392c.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('writemypaperforme/asset/build/css/Template/site/Template/layout_content/common_head_styles392c.css') }}">
    <link href="/writemypaperforme/asset/timepicker/jquery.datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="/vue/sbootstrap.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdn.tiny.cloud/1/w75xwosb7fak6zrt4r2hs4wjnvc53o7luvz03yuivs0rjwvv/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: 'textarea',
        plugins: 'charmap emoticons image link table lists linkchecker',
        toolbar: 'blocks fontsize | numlist bullist',
      });
    </script>
</head>

<body class="main-body-container ">
    @php
        $current=App\Order::where('user_id',Auth::user()->id)->where('status','!=',5)->where('is_deleted',0)->count();
        
        if(auth::user()->role==3) {
        $mycomplted=App\Order::where('user_id',Auth::user()->id)->where('status',5)->where('is_deleted',0)->count();
        $biddingscount =App\Order::where('user_id',Auth::user()->id)->where('status',1)->where('is_deleted',0)->count();
        $editingcount =App\Order::where('user_id',Auth::user()->id)->where('status',3)->where('is_deleted',0)->count();
        $revisioncount =App\Order::where('user_id',Auth::user()->id)->where('status',4)->where('is_deleted',0)->count();
        $assorders =App\Order::where('user_id',Auth::user()->id)->where('status',2)->where('is_deleted',0)->count();
        }elseif (auth::user()->role==4) {
        $mycomplted=App\Order::where('tutor_id',Auth::user()->id)->where('status',5)->where('is_deleted',0)->count();
        $biddingscount =App\Order::where('status',1)->where('is_deleted',0)->count();
        $editingcount =App\Order::where('tutor_id',Auth::user()->id)->where('status',3)->where('is_deleted',0)->count();
        $revisioncount
        =App\Order::where('tutor_id',Auth::user()->id)->where('status',4)->where('is_deleted',0)->count();
        $assorders =App\Order::where('tutor_id',Auth::user()->id)->where('status',2)->where('is_deleted',0)->count();
        # code...
        }elseif (auth::user()->role==2||auth::user()->role==1) {
        $mycomplted=App\Order::where('status',5)->where('is_deleted',0)->count();
        $biddingscount =App\Order::where('status',1)->where('is_deleted',0)->count();
        $editingcount =App\Order::where('status',3)->where('is_deleted',0)->count();
        $revisioncount =App\Order::where('status',4)->where('is_deleted',0)->count();
        $assorders =App\Order::where('status',2)->where('is_deleted',0)->count();
        }else {
        # code...
        }
    @endphp
    
    <header class="page-header js_header__wrapper">
        <div class="page-header__inner">
            <div class="row">
                <div class="page-header__content js_header__container">
                    <a href="/"><img src="/logo/logo.webp" height="270px" width="250px"></a>
                    <div class="main-menu-v2 js_main-menu-v2 " data-heading="Browse categories" data-level="1">
                        <menu class="main-menu-v2__controls">
                            <li class="main-menu-v2__prev js_main-menu-prev"></li>
                        </menu>
                        <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_desc">
                            <a class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim" href="{{ url('home') }}">
                                <span> Dashboard </span>
                            </a>
                        </div>
                        <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable">
                            <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim">
                                <span> My Orders </span>
                            </div>
                            <div class="main-dropdown-v2 js_main-dropdown-v2">
                                <div class="main-dropdown-v2__left-side js_main-dropdown-left-side">
                                    <div class="main-dropdown-v2__list js_main-dropdown-list">
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('available-orders') }}">Bidding<span class="badge badge-pill badge-primary float-right">{{ $biddingscount }}</span></a>
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('assigned-orders') }}">Assigned<span class="badge badge-pill badge-success float-right">{{ $assorders }}</span></a>
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('orders-in-editing') }}">Editing<span class="badge badge-pill badge-warning float-right">{{ $editingcount }}</span></a>
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('my-revisions') }}">Revision<span class="badge badge-pill badge-danger float-right">{{ $revisioncount }}</span></a>
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('completed-orders') }}">Completed<span class="badge badge-pill badge-success float-right">{{ $mycomplted }}</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable ">
                            <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim">
                                <span> Messages <span class="badge badge-pill badge-danger "style="font-size: 13px">{{count($umessages)||($received-messages)}}</strong></span></span>
                            </div>
                            <div class="main-dropdown-v2 js_main-dropdown-v2">
                                <div class="main-dropdown-v2__left-side js_main-dropdown-left-side ">
                                    <div class="main-dropdown-v2__list js_main-dropdown-list">
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('received-messages') }}">Received <span class="badge badge-pill badge-danger "style="font-size: 13px">{{count($umessages)||($received-messages)}}</strong></span></a>
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('sent-messages') }}">Sent</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        @if(auth::user()->role==1)
                            <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable ">
                                <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim">
                                    <span> Transactions</span>
                                </div>
                                <div class="main-dropdown-v2 js_main-dropdown-v2">
                                    <div class="main-dropdown-v2__left-side js_main-dropdown-left-side ">
                                        <div class="main-dropdown-v2__list js_main-dropdown-list">
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('/client-analysis') }}">Client Analysis</a>
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('/financials') }}">Financial Analysis</a> 
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('financial-transactions') }}">All Transactions</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(Auth::user()->role==1)
                        <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable">
                            <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim"><span>Pages</span></div>
                            <div class="main-dropdown-v2 js_main-dropdown-v2">
                                <div class="main-dropdown-v2__left-side js_main-dropdown-left-side ">
                                    <div class="main-dropdown-v2__list js_main-dropdown-list">
                    					<a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('create-page') }}">New Page</a>
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('view-pages') }}"> View Pages</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(Auth::user()->role==1)
                            <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable ">
                                <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim">
                                    <span>Posts</span>
                                </div>
                                <div class="main-dropdown-v2 js_main-dropdown-v2">
                                    <div class="main-dropdown-v2__left-side js_main-dropdown-left-side ">
                                        <div class="main-dropdown-v2__list js_main-dropdown-list">
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('create-post') }}">New Post</a>
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('create-category') }}">Create Category</a>
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('view-posts') }}">Posts</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(Auth::user()->role==1)
                            <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable ">
                                <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim">
                                    <span> System Users </span>
                                </div>
                                <div class="main-dropdown-v2 js_main-dropdown-v2">
                                    <div class="main-dropdown-v2__left-side js_main-dropdown-left-side ">
                                        <div class="main-dropdown-v2__list js_main-dropdown-list">
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('/add-user') }}">Add User </a>
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('/all-active-clients') }}">Active Clients </a>
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('/all-active-writers') }}">Active Writers</a>
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('/staff') }}">Staff </a> 
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('/deactivated-users') }}">Deactivated </a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(Auth::user()->role==1||Auth::user()->role==2||Auth::user()->role==4)
                        <div class="desktop-user-logged-block__pic" style="margin-left:10px;">
                            <a href="{{ url("view/profile") }}"> <img alt="customer-3704662" style="border-radius:10px;" src="{{ URL::asset('vue/public/assets/images/avatars/'.auth::user()->avatar) }}"> </a>
                        </div>
                        @endif
                        @if(Auth::user()->role==3)
                        <div class="desktop-user-logged-block__pic" style="margin-left:10px;">
                            <a href="{{ url("view/profile") }}"> <img alt="customer-3704662" src="/postsimages/z.png"> </a>
                        </div>
                        @endif
                        <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable">
                            <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim"> Hi, {{ ucfirst(auth::user()->name) }} </div>
                            <div class="main-dropdown-v2 js_main-dropdown-v2">
                                <div class="main-dropdown-v2__left-side js_main-dropdown-left-side ">
                                    <div class="main-dropdown-v2__list js_main-dropdown-list">
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('/view/profile') }}">My Profile</a>
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('financial-transactions') }}">My Wallet</a>
                                        @if(auth::user()->role==1)
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('settings') }}">Settings</a> 
                                        @endif
                                        @if(Session::get('imposter'))
                                            <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ action('UseraccountsController@stopImpersonate') }}">Stop Impersonate </a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;"> {{ csrf_field() }}</form>
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    @if(Auth::user()->role==1||Auth::user()->role==2||Auth::user()->role==4)
                        <div class="page-header__user-controllers">
                            <button class="page-header__hamburger js_hamburger-menu-v4"><span class="page-header__hamburger-ico"><span></span></span></button>
                        </div>
                    @endif
                    @if(Auth::user()->role==3)
                        <div class="page-header__user-controllers" >
                            &nbsp;&nbsp;
                            <a href="{{ url("/new-order") }}" class="btn_main">NEW ORDER</a>
                            <button class="page-header__hamburger js_hamburger-menu-v4"><span class="page-header__hamburger-ico"><span></span></span></button>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="front-page-wrapper  ">
        <div class="page-content">
            <div class="container">
                @include('flash::message')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
     </div>
    
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
                                <a href="/"> <img alt="paypal" src="/svg/paypal.webp" loading="lazy" width="280"></a>
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

    <link rel="stylesheet" href="{{ URL::asset('writemypaperforme/asset/build/css/Template/site/Template/layout/common_footer_styles392c.css') }}">
    <script src="{{ URL::asset('writemypaperforme/asset/build/js/Template/webpack_common_footer_scripts392c.js') }}" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script type="text/x-jquery-tmpl" id="popupSet"> {%tmpl(this.data) $('#_default_popup_data').template()%} data-popup-click=""</script>
    <script type="text/x-jquery-tmpl" id="popupSetAutoOpen"> {%tmpl(this.data) $('#_default_popup_data').template()%} data-popup-autoopen=""</script>
    <script type="text/x-jquery-tmpl" id="_default_popup_data"> data-popup-target="${popup}" data-popup-data='${JSON.stringify(this.data)}'</script>
    <script type="text/x-jquery-tmpl" id="_popup_tpl"><div class="modal uk-modal fade modal-allow-user js_popup_all" role="dialog" aria-hidden="true" data-backdrop="static"><div class="modal-dialog"><div class="modal-content js_popup_content">{%tmpl(popup_data) $(popup_id).template()%}</div></div></div></script>
    <script src="{{ URL::asset('writemypaperforme/asset/build/js/Template/header_banner392c.js') }}" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script src="{{ URL::asset('writemypaperforme/asset/build/js/Template/webpack_my_footer_scripts392c.js') }}" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script src="{{ URL::asset('writemypaperforme/asset/js/6bd2409392c.js') }}" type="c897897d8e32f3103afbfe14-text/javascript"></script>
    <script type="c897897d8e32f3103afbfe14-text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var TABLET_WIDTH_IN_PX = 768;
            if (window.innerWidth < TABLET_WIDTH_IN_PX) {
                new Widget.SlideInBanner.Core('.js_slide_in_banner', '.js_slide_in_close');
            }
        });
    </script>
    <script src="{{ URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
    <script src="{{ URL::asset('ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js') }}" data-cf-settings="c897897d8e32f3103afbfe14-|49" defer=""></script>
    <script src="/writemypaperforme/asset/timepicker/jquery.js"></script>
    <script src="/writemypaperforme/asset/timepicker/jquery.datetimepicker.js"></script>
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
    <script>
        jQuery('#datetimepicker').datetimepicker({
            format: 'm-d-Y H:i',
            minDate: 0
        });
    </script>
    <script>
        $(".readonly").keydown(function(e){
            e.preventDefault();
        });
    </script>
    <script>
        function refreshCsrfToken() {
            fetch('/refresh-csrf')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                    document.querySelectorAll('input[name="_token"]').forEach(input => input.value = data.csrf_token);
                });
        }
        // Refresh the CSRF token every 10 minutes
        setInterval(refreshCsrfToken, 10 * 60 * 1000);
    
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure CSRF tokens are refreshed on page load
            refreshCsrfToken();
        });
    </script>

</body>
</html>