@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        
		
		
		<button id="homeButton" class="btn btn-success">Go to Main Menu</button>

		<!-- Inline JavaScript in Blade Template -->
		<script>
			document.getElementById('homeButton').addEventListener('click', function() {
				window.location.href = "{{ route('projects.index') }}";
			});
		</script>

		
		<div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    
                    
                    
                    <form method="post" action="{{ route('projecthours.starttime') }}" style="text-align:center">
                        @csrf
						<!--
                        <div class="form-group">
                            
                            <input type="text" name="start" class="form-control" required/>
                        </div>
						-->
                        <div class="form-group">
							<input type="hidden" name="post_id" value="{{ $projects->id }}" />
                            <input type="submit" class="btn btn-success" value="START TRACKER" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
		
		
		<div class="col-md-4">
            <div class="card">
                <div class="card-body">                
                    
                    
                    <form method="post" action="{{ route('projecthours.endtime') }}" style="text-align:center">
                        @csrf
						<!--
                        <div class="form-group">                           
							
                            <input type="text" name="end" class="form-control" required/>
                        </div>
						-->
						
                        <div class="form-group">
							<input type="hidden" name="post_id" value="{{ $projects->id }}" />
                            <input type="submit" class="btn btn-success" value="END TRACKER" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
		
		
		
		
		
		

		
		
		
		
    </div>
</div>




<div class="container">
    <div class="row justify-content-center">
	
			<div class="col-md-12">
            <div class="card">
                <div class="card-body">
				
				<center>

		@if($errors->any())
		<h4>{{$errors->first()}}</h4>
		@endif
		</center>
		</div>
		</div>
		</div>
    
	
	</div>
</div>


@endsection