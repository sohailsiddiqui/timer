@extends('layouts.app')
   
@section('content')

    
  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>PROJECT HOURS</h1>
			<h4>@foreach($projectname as $posts)
			{{ $posts->title }}
			@endforeach</h4>
            <br/><br/>
            <table class="table table-bordered" id="transactionsTable">
                <thead>
                    <th width="80px">ID</th>
                    <th>START DATE</th>
					<th>END DATE</th>
					<th>TIME</th>
                    <th width="150px">EDIT</th>
					<th width="150px">DELETE</th>
                </thead>
                <tbody>
                @foreach($projecthours as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->publish_date }}</td>
					<td>{{ $post->publishdate_end }}</td>
					<td>{{ catchdate($post->publish_date,$post->publishdate_end) }}</td>
                    <td>
					<a href="{{ route('projecthours.edit', $post->id) }}" class="btn btn-primary">EDIT</a>                        						
                    </td>
					<td>
						<a href="{{ route('projecthours.destroy', $post->id) }}" class="btn btn-primary">DELETE</a>
					</td>
                </tr>
                @endforeach
                </tbody>
   
            </table>
			
			   <button onclick="exportTableToExcel('transactionsTable', 'SettlementTransactions')">
      Export Table Data To Excel File
    </button>
	
	<button id="homeButton">Go to Main Menu</button>

<!-- Inline JavaScript in Blade Template -->
<script>
    document.getElementById('homeButton').addEventListener('click', function() {
        window.location.href = "{{ route('projects.index') }}";
    });
</script>
	
	
        </div>
    </div>
</div>


<script>
function exportTableToExcel(transactionsTable, filename = ''){
  let downloadLink;
  const dataType = 'application/vnd.ms-excel';
  const tableSelect = document.getElementById(transactionsTable);
  const tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
  
  // Specify file name
  filename = filename?filename+'.xls':'excel_data.xls';
  
  // Create download link element
  downloadLink = document.createElement("a");
  
  document.body.appendChild(downloadLink);
  
  if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
          type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
  }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
  
      // Setting the file name
      downloadLink.download = filename;
      
      //triggering the function
      downloadLink.click();
  }
}
</script>

<?php


function catchdate($datetime1,$datetime2){
		
		// Create DateTime objects for the two datetime values
		$datetime1_obj = new DateTime($datetime1);
		$datetime2_obj = new DateTime($datetime2);

		// Calculate the difference between the two datetime values
		$interval = $datetime1_obj->diff($datetime2_obj);

		// Format the output
		//$total_time = $interval->format('%d days, %h hours, %i minutes, %s seconds');

		$total_time = $interval->format(' %h hours, %i minutes, %s seconds');
		
		// Output the result
		//return "Total time between $datetime1 and $datetime2 is $total_time.";
		
		echo $total_time;
		
}

?>

@endsection