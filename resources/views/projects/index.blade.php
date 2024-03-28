@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>MANAGE PROJECTS</h1>
            <a href="{{ route('projects.create') }}" class="btn btn-success" style="float: right">Create Projects</a><br/><br/>
            <table class="table table-bordered">
                <thead>
                    <th width="80px">ID</th>
                    <th>TITLE</th>
                    <th width="150px">TIMER</th>
					<th width="150px">HOUR</th>
                </thead>
                <tbody>
                @foreach($projects as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>
                        <a href="{{ route('projects.show', $post->id) }}" class="btn btn-primary">START TIMER</a>						
                    </td>
					<td>
						<a href="{{ route('projecthours.index', $post->id) }}" class="btn btn-primary">VIEW HOURS</a>
					</td>
                </tr>
                @endforeach
                </tbody>
   
            </table>
        </div>
    </div>
</div>
@endsection