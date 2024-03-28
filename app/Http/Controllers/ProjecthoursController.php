<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Projecthour;
use App\Project;

use Carbon\Carbon;
use Redirect;
use DateTime;
use DatePeriod;
use DateInterval;

class ProjecthoursController extends Controller
{
   

     public function index(Request $request)
    {     
	
	    //return redirect()->route('home');
			
		$id = $request->id;
		
		$projectname = Project::where('id', '=', $id)->get();
		
		
		
		$projecthours = Projecthour::where('post_id', '=', $id)->get();
		return view('projecthours.index',compact('projecthours','projectname'));
		
    }
	
	
	public function create()
    {
		echo "helo world";
	}
	
	public function datesubmit(Request $request)
    {
		$this->validate($request,[
			'publish_date'=> 'required|date_format:Y-m-d H:i:s|before_or_equal:publishdate_end',
			'publishdate_end'=> 'required|date_format:Y-m-d H:i:s|after_or_equal:publish_date'
		]);
				
		Projecthour::where('id', '=', $_REQUEST['id']  )->update(['publishdate_end' => $_REQUEST['publishdate_end'] , 'publish_date' => $_REQUEST['publish_date'] ]);
		
		//return back();
		
		return Redirect::back()->withErrors(['msg' => 'Record Has Updted !']);
		//return redirect()->route('projects.index');
		
		
	}
	
	public function edit(Request $request)
    {
		
		$id = $request->id;
		
		$projecthours = Projecthour::where('id', '=', $id)->get();
		return view('projecthours.edit',compact('projecthours'));
		
		
		exit();
		echo $request->id;
		
		echo "a gaya";
		
		exit();
		
		//return view('projecthours.edit',compact('projecthoursedit'));
	}


	public function destroy(Request $request)
    {
		$id  =  $request->id;
		$res =  Projecthour::where('id',$id)->delete();
		return back();
		
		
		
		//return view('projecthours.edit',compact('projecthours'));
	}

   public function store(Request $request)
    {
		/*		
    	$request->validate([
            'body'=>'required',
        ]);
		*/
		
		
     
	    //echo Carbon::now()->format('Y-m-d  h:m:s');
		//exit();
		//2024-03-16 23:38:46
	 
        $input = $request->all();
		
        $input['user_id'] = auth()->user()->id;
		$input['publish_date'] =  Carbon::now()->toDateTimeString();
		$input['post_id'] = 1;
		$input['body'] = 2;
		
		
		//echo "<pre>";
		//print_r($input);
		//exit();
		
    
        Project::create($input);
   
        return back();
    }
	
	
	
	public function starttime(Request $request)
    {
		
		$input = $request->all();
		
		$input['user_id'] = auth()->user()->id;
		$input['publish_date'] =  Carbon::now()->toDateTimeString();
		$input['post_id'] = $input['post_id'];
		$input['body'] = 2;
		$input['isactive'] = 1;
		
		$commentsCheck = Projecthour::where('post_id',$input['post_id'])->orWhere('user_id', $input['user_id'] )->get(); 
		
		
		
		if($commentsCheck->isEmpty()){
			
			// if post not exists
			
			Projecthour::create($input);   
			return Redirect::back()->withErrors(['msg' => 'The Timer Has Started !']);
			
			
			
		}else{
			
			//echo "There is a records";
			
			$comments = Projecthour::where('post_id',$input['post_id'])->orWhere('user_id', $input['user_id'] )->orderBy('id', 'desc')->get()->first();
			
			if(isset($comments->isactive) && $comments->isactive == 1){
				return Redirect::back()->withErrors(['msg' => 'The Timer Has Already Started !']);
			}else{
				Projecthour::create($input);   
				return Redirect::back()->withErrors(['msg' => 'The Timer Has Started !']);
			}
			
			
			
		}
				
		/*	
		$input['post_id']		
    	$request->validate([
            'body'=>'required',
        ]);
		*/

    }
	
	public function endtime(Request $request)
    {
	
		$input = $request->all();
		
		$input['user_id'] = auth()->user()->id;
		$input['publish_date'] =  Carbon::now()->toDateTimeString();
		$input['post_id'] = $input['post_id'];
		$input['body'] = 2;
		$input['isactive'] = 1;
		
		$commentsCheck = Projecthour::where('post_id',$input['post_id'])->orWhere('user_id', $input['user_id'] )->get(); 
		
		// when ending a ticker it always have data
		
		if($commentsCheck->isEmpty()){
			
			return Redirect::back()->withErrors(['msg' => 'The Timer Has Not Started !']);
			
		}else{
			
			//echo "There is a records";
			
			$comments = Projecthour::where('post_id',$input['post_id'])->orWhere('user_id', $input['user_id'] )->orderBy('id', 'desc')->get()->first();
			
			if(isset($comments->isactive) && $comments->isactive == 1){
				
				// here call an update query 
				$pub_date = $comments->publish_date;
				$end_pub_date = Carbon::now()->toDateTimeString();
				
				
				//$pub_date     =  '2024-03-27 11:14:58';
				//$end_pub_date = '2024-03-28 11:20:58';
				
				
				
				
				if ($this->areStartAndEndDateSame($pub_date, $end_pub_date)) {
					//echo "Start and end dates are the same.";
					
					//$totalHours = $this->getHoursBetweenDateTimeRange($pub_date, $end_pub_date);
					
					$timeDifference = $this->calculateTimeDifference($pub_date, $end_pub_date);

					$hours   = $timeDifference->h;
					$minutes = $timeDifference->i;
					$seconds = $timeDifference->s;

					$totalHours = $this->convertToHours($hours, $minutes, $seconds);							
					
					Projecthour::where('id', '=', $comments->id)->update(['publishdate_end' => $end_pub_date , 'isactive' => 0, 'hours' => $totalHours ]);
					
					return Redirect::back()->withErrors(['msg' => 'The Timer Has Finished Execution !']);
					
				} else {
					
					//echo "Start and end dates are different.";
					
					$startDateTime = $pub_date;
					$endDateTime = $end_pub_date;
					
					$dailyRanges = $this->splitDateTimeRangeByDay($startDateTime, $endDateTime);
                    
					$i = 1;
					
					foreach($dailyRanges as $range){
						
						$input['publish_date']    =  $range['start'];
						$input['publishdate_end'] =  $range['end'];
						
						if($i == 1){
							
							//$totalHours = $this->getHoursBetweenDateTimeRange($input['publish_date'], $input['publishdate_end']);
							
							//$timeDifference = $this->calculateTimeDifference($input['publish_date'], $input['publishdate_end']);
							$timeDifference = $this->calculateTimeDifference($comments->publish_date, $input['publishdate_end']);

							$hours   = $timeDifference->h;
							$minutes = $timeDifference->i;
							$seconds = $timeDifference->s;

							$totalHours = $this->convertToHours($hours, $minutes, $seconds);
							
							Projecthour::where('id', '=', $comments->id)->update(['publishdate_end' => $input['publishdate_end'], 'isactive' => 0, 'hours' => $totalHours  ]);							
						}else{
							
							//$totalHours = $this->getHoursBetweenDateTimeRange($input['publish_date'], $input['publishdate_end']);
							
							$timeDifference = $this->calculateTimeDifference($input['publish_date'], $input['publishdate_end']);

							$hours   = $timeDifference->h;
							$minutes = $timeDifference->i;
							$seconds = $timeDifference->s;

							$totalHours = $this->convertToHours($hours, $minutes, $seconds);
							
							
							
							$comcat = Projecthour::create($input);
							$lastId = $comcat->id;
							Projecthour::where('id', '=', $lastId )->update([ 'isactive' => 0,  'hours' => $totalHours  ]);
						}
						
						$i++;						
					}
					
					return Redirect::back()->withErrors(['msg' => 'The Timer Has Finished Execution !']);
				
				}
				
				
			}
			
		}		
		
    }
	
	
	function getHoursBetweenDateTimeRange($startDateTime, $endDateTime) {
		// Create DateTime objects for start and end date-times
		$start = new DateTime($startDateTime);
		$end = new DateTime($endDateTime);

		// Calculate the difference between two date-time objects
		$interval = $start->diff($end);

		// Get the total number of hours from the interval
		$totalHours = $interval->h + ($interval->days * 24);

		return $totalHours;
	}
	
	
	public function areStartAndEndDateSame($startDateTime, $endDateTime) {
		$startDate = new DateTime($startDateTime);
		$endDate = new DateTime($endDateTime);

		// Compare dates without considering the time portion
		return $startDate->format('Y-m-d') == $endDate->format('Y-m-d');
	}
	
	
	function splitDateTimeRangeByDay($startDateTime, $endDateTime) {
		$start = new DateTime($startDateTime);
		$end = new DateTime($endDateTime);
		
		$interval = new DateInterval('P1D'); // 1 day interval
		$period = new DatePeriod($start, $interval, $end);

		$result = array();
		foreach ($period as $dt) {
			$result[] = array(
				'date' => $dt->format('Y-m-d'),
				'start' => $dt->format('Y-m-d 00:00:00'),
				'end' => $dt->format('Y-m-d 23:59:59')
			);
		}

		return $result;
	}
	
	public function splitDateTimeRangeByMonth($startDateTime, $endDateTime) {
		$start = new DateTime($startDateTime);
		$end = new DateTime($endDateTime);

		$interval = DateInterval::createFromDateString('1 month');
		$period = new DatePeriod($start, $interval, $end);

		$result = array();
		foreach ($period as $dt) {
			$startOfMonth = new DateTime($dt->format('Y-m-01'));
			$endOfMonth = new DateTime($dt->format('Y-m-t 23:59:59'));
			
			// Adjust start and end dates to the range if they go beyond it
			$rangeStart = ($startOfMonth > $start) ? $startOfMonth : $start;
			$rangeEnd = ($endOfMonth < $end) ? $endOfMonth : $end;
			
			$result[] = array(
				'start' => $rangeStart->format('Y-m-d H:i:s'),
				'end' => $rangeEnd->format('Y-m-d H:i:s')
			);
		}

		return $result;
	}
	
	function calculateTimeDifference($startDateTime, $endDateTime) {
		// Create DateTime objects for start and end date-times
		$start = new DateTime($startDateTime);
		$end = new DateTime($endDateTime);

		// Calculate the difference between two date-time objects
		$interval = $start->diff($end);

		return $interval;
	}

	function convertToHours($hours, $minutes, $seconds) {
		// Convert minutes to hours
		$minutesInHours = $minutes / 60;

		// Convert seconds to hours
		$secondsInHours = $seconds / 3600;

		// Total hours
		$totalHours = $hours + $minutesInHours + $secondsInHours;

		return $totalHours;
	}
	
	
	
}
