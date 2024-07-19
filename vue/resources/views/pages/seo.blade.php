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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SEO Details</a></li>
                 
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
			<th scope="col">Page</th>
			<th scope="col">Title</th>
			<th scope="col">Metadescription</th>
			<th scope="col">Keywords</th>
			<th scope="col">Keyphrase</th>
			<th scope="col">View</th>
		  </tr>
		</thead>
		<tbody>
            @php
                $homepage=App\Pageseo::where('page',1)->first();
            @endphp
            <tr>
                <th scope="row">1</th>
                <td>{{ ucfirst($homepage->label) }}</td>
                <td>{{ ucfirst($homepage->title) }}</td>
                <td>{{ $homepage->metadescription }}</td>
                <td>{{ $homepage->keywords }}</td>
                <td>{{ $homepage->keyphrase }}</td>
                <td><a href="{{ url('/seo-edit', $homepage->id) }}" class="btn btn-primary">Edit</a></td>
              </tr>	
            @foreach ($posts as $key=> $post)
            <tr>
                <th scope="row">{{ $key+2 }}</th>
                <td>{{ ucfirst($post->label) }}</td>
                <td>{{ ucfirst($post->title) }}</td>
                <td>{{ $post->metadescription }}</td>
                <td>{{ $post->keywords }}</td>
                <td>{{ $post->keyphrase }}</td>
                <td><a href="{{ url('/edit-post', $post->id) }}" class="btn btn-primary">Edit</a></td>
              </tr>	
            @endforeach
		 	 
		</tbody>
	  </table>
</div>
</div>
</div>
@stop