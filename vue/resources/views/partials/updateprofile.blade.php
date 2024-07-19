@if($user->role!=3)
<div id="collapseTwoDefault" class="collapse" data-parent="#accordion-default">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/update-profile') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('education') ? ' has-error' : '' }}">
                    <label for="inputAddress"> Education</label>
                    <input type="text" class="form-control" name="education" id="inputAddress" value="{!!($bio!='') ? $bio->education:''!!}" required="true" placeholder="Your education level">
                    @if ($errors->has('education'))
                    <span class="help-block">
                        <strong>{{ $errors->first('education') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('major') ? ' has-error' : '' }}">
                    <label for="inputAddress"> Major</label>
                    <input type="text" class="form-control" name="major" id="inputAddress" value="{!!($bio!='') ? $bio->major:''!!}" required="true" placeholder="Your major">
                    @if ($errors->has('major'))
                    <span class="help-block">
                        <strong>{{ $errors->first('major') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 {{ $errors->has('bio') ? ' has-error' : '' }}">
                        <label for="inputEmail4">Bio</label>
                        <textarea width="100%" id="detailsee" name="bio" >{!!($bio!="") ? $bio->bio:''!!}</textarea>
                    </div>
                    @if ($errors->has('bio'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bio') }}</strong>
                    </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-info shadow-btn">Update Profile</button>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="accordion" id="accordion-default">
            <a class=" btn btn-info" data-toggle="collapse" href="#collapseTwoDefault">Update Profile </a>  
        </div>
        <br>
        <h3>Bio</h3>
            <p>{!!($bio!="") ? $bio->bio:''!!}</p>
        <hr>
        <h3>Education</h3>
        <div class="m-t-20">
            <div class="media m-b-30">
                <div class="media-body m-l-20">
                    <h6 class="m-b-0">{{($bio!="") ? $bio->education:''}}</h6>
                    <span class=" text-success"><i><strong><i class="fas fa-graduation-cap"></i> <small>Degree Verified</small></strong></i></span>
                </div>
            </div>
        </div>
        <hr>
        <h3>Specialilty</h3>
            @if($speciality!="")
            <?php
            $categories = '';
            $cats = explode(",",(string)$speciality->course);
            foreach($cats as $cat){
                $cat = trim($cat);
                $cat ;
                echo('<span class=" badge badge-pill badge-info">'.$cat.'</span>'."&nbsp;");
            }
            ?>
            @else
            <span class="badge badge-pill badge-info">General Writer</span>
            @endif
        <hr>
        @php
        $fields=App\Discipline::orderBy('fields','ASC')->get();
        @endphp
        <form class="form-horizontal"  role="form"  method="post" action="{{ url('/update-specialization') }}">
            {{ csrf_field() }}
            @foreach($fields as $field)
            <?php
            $categories = '';
            $cats = explode(",",(string)$field->fields);
            foreach($cats as $cat){
                $cat = trim($cat);
                $cat ;
                echo('<span class="btn btn-xs rounded-border btn-outline-primary">'.$cat." " .Form::checkbox('specialization[]',$field->fields ).'</span>'."&nbsp;")."&nbsp;&nbsp;";
            }
            ?>
            @endforeach
            <input type="submit" value="Update Speciality" class="btn btn-sm btn-success" />
        </form>
    </div>
</div>
<script>
    CKEDITOR.replace( 'detailsee' );
</script> 
@endif