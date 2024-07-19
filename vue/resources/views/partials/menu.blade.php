@if (count($menus)>0)
@foreach ($menus as $menu )
<div class="card mb-1 shadow-none">
    <div class="card-header" id="headingOne{{ $menu->id }}">
        <h6 class="m-0">
            <a href="#collapseOne{{ $menu->id }}" class="text-dark" data-toggle="collapse"
                    aria-expanded="true"
                    aria-controls="collapseOne{{ $menu->id }}">
                    {{ $menu->menuname }}
            </a>
        </h6>
    </div>

    <div id="collapseOne{{ $menu->id }}" class="collapse show"
            aria-labelledby="headingOne{{ $menu->id }}" data-parent="#accordion">
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal{{ $menu->id }}">
                Add Menu Items
                </button>
                <hr/>
                
                <!-- Modal -->
                <div class="modal " id="myModal{{ $menu->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">{{ $menu->menuname }}</h4>
                      </div>
                      <div class="modal-body">
                          <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/add-menu-page') }}">
                              {{ csrf_field() }}
                              
                      <input type="hidden" value="{{ $menu->id }}" name="mid"/>
                              
              
                              <div class="form-group  {{ $errors->has('page') ? ' has-error' : '' }}">
                                <label for="inputEmail4">Page</label>
                                <select name="page" class="form-control">
                                    @if(count($tpages)>0)
                                    @foreach($tpages as $page)
                                    <option value="{{$page->id}}">{{$page->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('page'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('page') }}</strong>
                                </span>
                                @endif
                            </div>
                              
                          
                                 
                              
                              <button type="submit" class="btn btn-primary shadow-btn">Save</button>  
                                    
                             
                          </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      
                      </div>
                    </div>
                  </div>
                </div>
                @php
                $children=App\Menuitem::where('menuid',$menu->id)->get();
                @endphp
            @if (count($children)>0)
            @foreach ($children as $child )
            @php
            $children=App\Blog::where('id',$child->page_id)->first();
            $grandchildren=App\Navmenu::where('navid',$child->id)->where('menuid',$menu->id)->get();
            @endphp
            
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                 
                    <span>{{   $children->title }}   </span> 
                </a>
    <span style="margin-left:75%">      <button type="button" class="btn btn-sm btn-info pull-right"  data-toggle="modal" data-target="#grandchild{{ $child->id }}">
        Add Child
        </button></span>
                <div class="modal " id="grandchild{{ $child->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel">{{ $child->title  }}</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/add-granchild-menu') }}">
                                {{ csrf_field() }}
                                
                        <input type="hidden" value="{{ $child->id }}" name="cid"/>
                        <input type="hidden" value="{{ $child->menuid }}" name="mid"/>
                        <div class="form-group  {{ $errors->has('page') ? ' has-error' : '' }}">
                            <label for="inputEmail4">Page</label>
                            <select name="page" class="form-control">
                                @if(count($tpages)>0)
                                @foreach($tpages as $page)
                                <option value="{{$page->id}}">{{$page->title}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('page'))
                            <span class="help-block">
                                <strong>{{ $errors->first('page') }}</strong>
                            </span>
                            @endif
                        </div>
                          
                               
                <button type="submit" class="btn btn-primary shadow-btn">Add</button>                                      
                           </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        
                        </div>
                      </div>
                    </div>
                  </div>
                @if(count($grandchildren)>0)

                <ul class="sub-menu" aria-expanded="true">
                    @foreach ($grandchildren as $grandchild )
                    @php
                    $grannychildpage=App\Blog::where('id',$grandchild->pageid)->first();
                     @endphp
                    <li><a href="javascript: void(0);">{{ $grannychildpage->title }}</a></li>
                    @endforeach
                   
                </ul>
                @endif
            </li>
            <br/>

                
            @endforeach

          
            @else
            <p>No Menu items in this menu</p>
        @endif
      
        </div>
      
    </div>
</div>
@endforeach
@endif