 <div class="main-menu-v2 js_main-menu-v2 " data-heading="Browse categories" data-level="1">
     <menu class="main-menu-v2__controls">
         <li class="main-menu-v2__prev js_main-menu-prev"></li>
     </menu>
     <div class="main-menu-v2__item  js_main-menu-item main-menu-v2__item_expandable">
     @if($menus->count()>0)
     @foreach ($menus as $menu )
         <div class="main-menu-v2__title js_main-menu-title main-menu-v2__title_slim">
             <span>
                 <svg>
                     <use
                         xlink:href=bundles/asterfreelance/_layout/images/site/main-menu-v2/icons-sprite_v1.svg#writing-services>
                     </use>
                 </svg>
                 {{$menu->menuname}}
             </span>
         </div>
         <div class="main-dropdown-v2 js_main-dropdown-v2">
             <div class="main-dropdown-v2__left-side js_main-dropdown-left-side ">
                 <div class="main-dropdown-v2__header ">
                     <div class="main-dropdown-v2__title js_main-dropdown-title">Custom Writing
                         Service</div>
                 </div>
                 <div class="main-dropdown-v2__list js_main-dropdown-list">
                     <div class="main-dropdown-v2__item js_main-dropdown-item   main-dropdown-v2__item_expandable "
                         data-id=1>Essay Writing</div>
                     <a class="main-dropdown-v2__item js_main-dropdown-item    " href="research-papers-writing-services"
                         data-id=2>Research Papers</a>
                     <a class="main-dropdown-v2__item js_main-dropdown-item    " href="dissertation-writing-services"
                         data-id=6>Dissertation</a>
                     <a class="main-dropdown-v2__item js_main-dropdown-item    " href="case-study-writing-service"
                         data-id=5>Case Study</a>
                     <a class="main-dropdown-v2__item js_main-dropdown-item    " href="coursework-writing"
                         data-id=4>Coursework</a>
                     <a class="main-dropdown-v2__item js_main-dropdown-item    " href="term-papers-writing-services"
                         data-id=3>Term Papers</a>
                     <div class="main-dropdown-v2__item js_main-dropdown-item   main-dropdown-v2__item_expandable "
                         data-id=8>Others</div>
                 </div>
             </div>

         </div>
     @endforeach
         
         @endif
     </div>
 </div>
