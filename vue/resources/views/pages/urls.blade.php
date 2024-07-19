
<ul>
    @foreach($posts as $post)
<li><a href="/{{$post->slug}}">{{$post->title}}</a></li>

@endforeach
</ul>