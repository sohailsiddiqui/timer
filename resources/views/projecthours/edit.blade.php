@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
	
		<div class="col-md-12">
            <h1>EDIT DATES</h1>
            
			<button id="homeButton" class="btn btn-success">Go to Main Menu</button>
			<br/><br/>
			</div>
		</div>
	
        <div class="col-md-12">
           			
			<!-- Inline JavaScript in Blade Template -->
			<script>
				document.getElementById('homeButton').addEventListener('click', function() {
					window.location.href = "{{ route('projects.index') }}";
				});
			</script>
			
			<div class="col-md-4" >
				<div class="card">
					<div class="card-body">
						
						
						
						<form method="post" action="{{ route('projecthours.datesubmit') }}" style="text-align:center">
							@csrf
							
							@foreach($projecthours as $post)
							<div class="form-group">
							<label>START DATE</label><br/>
								<input type="text" name="publish_date" value="{{ $post->publish_date }}" />								
							</div>
							<div class="form-group">
								<label>END DATE</label><br/>
								<input type="text" name="publishdate_end" value="{{ $post->publishdate_end }}" />									
							</div>
							<input type="hidden" name="id" value="{{ $post->id }}" />
							@endforeach
							
							<input type="submit" class="btn btn-success" value="SUBMIT" />
							
							
						</form>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">			
			
			@if($errors->any())
			<h4>{{$errors->first()}}</h4>
			@endif
			
				</div>
				</div>
			</div>
			
			
			
           
        </div>
    </div>
</div>
@endsection