<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h3> Recent Orders </h3>
                <div class="table-responsive">
                    <table class="table mb-0 table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Pages</th>
                                <th>Subject</th>
                                <th>Timer</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($arecent)>0)
                                @foreach ($arecent as $key=> $recent)
                                @php
                                $t=time();
                                $str=$recent->duedate;
                                $timestamp = strtotime($str)-$t;
                                	$subjects=App\Subject::findOrFail($recent->subject);
                            @endphp
                            <tr>
                                <td><a href="{{ url('/order',$recent->id) }}">{{ $recent->id }}</a></td>
                                <td><p>{{ str_limit($recent->title ,40)}}</p></td>
                                <td><span class="badge badge-primary badge-pill">{{ $recent->pages }}</span></td>
                                <td><p>{{$subjects->subject}}</p></td>
                                <td nowrap>
                                    @if(strtotime($str)>$t)
                                    <b style="color: #23AF00">{{secondsToTime($timestamp)}}</b>
                                    @else
                                   <span class="badge badge-danger">Past Due({{secondsToTime($timestamp)}})
                                   </span>
                                    @endif</td>   
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
        </div>
    </div>
</div>