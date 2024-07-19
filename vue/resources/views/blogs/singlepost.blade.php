@extends('layouts.app')
@section('title')
{{ ucfirst($post->title) }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Posts</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0"><li class="breadcrumb-item"><a href="javascript: void(0);">Posts</a></li></ol>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
	<div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Title:</th>
                    <td><h4>{{ ucfirst($post->title) }}</h4></td>
                </tr>
                <tr>
                    <th>Keywords:</th>
                    <td>{{($post->keywords) }}</td>
                </tr>
                <tr>
                    <th>Keyphase:</th>
                    <td>{{ $post->keyphrase }}</td>
                </tr>
                <tr>
                    <th>Featured Image:</th>
                    <td>{{ $post->fimage}}</td>
                </tr>
                <tr>
                    <th nowrap>Meta Description:</th>
                    <td>{!! $post->metadescription !!}</td>
                </tr>
                <tr>
                    <th>Post Body:</th>
                    <td>{!! $post->body !!}</td>
                </tr>
                 @if(auth::user()->role==1)
                <tr>
                    <th>Actions</th>
                    <td>
                        <a href="{{ url('/edit-post', $post->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ url('/delete-post', $post->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
                            @if($post->status==0)
                        <a href="{{ url('/toggle-status', $post->id) }}" class="btn btn-success">Publish</a>
                        @else 
                        <a href="{{ url('/toggle-status', $post->id) }}" class="btn btn-warning">Unpublish</a>
                        @endif
                    </td>
                </tr>
                @endif
            </table>
        </div>
    </div>
</div>
@stop