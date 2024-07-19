@extends('layouts.app')
@section('title')
 Posts
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Pages</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                 
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
			<th scope="col">#</th>
			<th scope="col">Title</th>
			<th scope="col">Body</th>
			<th scope="col">Keywords</th>
			<th scope="col">View</th>
		  </tr>
		</thead>
		<tbody>
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