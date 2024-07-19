 <style>
    p{
        font-weight:400;
        line-height: 1.5;
    }
    ul {
        font-size: 14px;
        font-weight:400;
        list-style-type: disc;
        padding-left: 2.5rem;
        }
    li{
         padding-bottom: 0.3rem}
    .stats {
		border: 1px solid #ddd;
		overflow: auto;
		padding: 18px 0;
		font-size: 14px;
		line-height: 1.3;
		background-color:#dcfce3;
	}
	.stats div {
		width: 33.33333%;
		float: left;
		text-align: center
	}
 </style>
    <div class="container">
        <div class="tile">
            <div class="wrapper">
                <div class="stats">
                    <div>
                        <p>Subject:</p> <a style="color: #23AF00">{{$subjects->subject}}</a>
                    </div>
                    <div style="border-left:2px solid #ddd;">
                        <p>Type of Work:</p> <a style="color: #23AF00">{{$types->type}}</a>
                    </div>
                    <div style="border-left:2px solid #ddd;">
                        <p>Academic Level:</p><a style="color: #23AF00">{{$levels->level}}</a>
                    </div>
                </div>
                <div class="stats">
                    <div>
                        <p> Language:</p>
                        <a style="color: #23AF00">{{$languages->language}} </>
                    </div>
                    <div style="border-left:2px solid #ddd;">
                        <p>Style:</p> <a style="color: #23AF00">{{$styles->style}}</a>
                    </div>
                    <div style="border-left:2px solid #ddd;">
                        <p>Assigned To:</p>
                      <a href="{{ url('/profile',$tutor->id) }}">{{ucfirst($tutor->name)}}</a>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <br>
        <br>
        <div class="wrapper">
            <div>
                <h4><b> Topic:</b> {!!$order->title!!}</h4>
                <h4><b> Instructions:</b></h4>
                <p>{!!$order->instructions!!}</p> 
            </div>      
       </div>
    </div>