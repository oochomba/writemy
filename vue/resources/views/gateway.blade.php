@php
$setpg=App\Gateway::where('id',1)->first();
@endphp

@if($setpg->activepg==1)	

@elseif($setpg->activepg==2)


@elseif($setpg->activepg==3)


@else
Not Set
@endif


