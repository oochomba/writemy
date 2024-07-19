@extends('layouts.app')
@section('title')
 Posts
@endsection
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Blog Posts</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Posts</a></li>
            
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="card mb-3">
<div class="card-body">
<div class="table-responsive">
	<table class="table">
		<thead>
		  <tr>
			<th>#</th>
			<th>Title</th>
			<th>Body</th>
			<th>Keywords</th>
			<th>View</th>
		  </tr>
		</thead>
		<tbody style="font-size:12px">
            @foreach ($posts as $key=> $post)
            <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td>{{ ucfirst($post->title) }}</td>
                <td>{!! \Illuminate\Support\Str::limit($post->body,80) !!}</td>
                <td>{{ $post->keywords }}</td>
                <td><a href="{{ url('/view-post', $post->id) }}" class="btn btn-primary">View</a></td>
              </tr>	
            @endforeach		 	 
		</tbody>
	  </table>
</div>
{!!$posts->links('pagination::bootstrap-4')!!}
</div>
</div>
@stop