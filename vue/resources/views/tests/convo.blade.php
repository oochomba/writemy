@if(Auth::user()->role==1)
    <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable 
        ">
        <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim">
            <span>

                Pages
            </span>
        </div>
        <div class="main-dropdown-v2 js_main-dropdown-v2">
            <div class="main-dropdown-v2__left-side js_main-dropdown-left-side ">

                <div class="main-dropdown-v2__list js_main-dropdown-list">

                 

						  <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('create-page') }}">New
                                            Page</a>
                                        <a class="main-dropdown-v2__item js_main-dropdown-item" href="{{ url('view-pages') }}"> View
                                            Pages</a>
                </div>
            </div>

        </div>
    </div>

@endif
