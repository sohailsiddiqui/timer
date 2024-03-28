<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

use Carbon\Carbon;
use Redirect;
use DateTime;
use DatePeriod;
use DateInterval;

class ProjectController extends Controller
{
     public function index()
    {       			
		$projects = Project::all();
        return view('projects.index', compact('projects'));
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$request->validate([
            'title'=>'required',
            'body'=>'required',
        ]);
    
        Project::create($request->all());
    
        return redirect()->route('projects.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		
    	$projects = Project::find($id);
				
        return view('projects.show', compact('projects'));
    }
}
