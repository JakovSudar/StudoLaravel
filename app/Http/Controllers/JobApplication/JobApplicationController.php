<?php

namespace App\Http\Controllers\JobApplication;
use App\Http\Controllers\ApiController;

use App\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = JobApplication::all();
        return $this->returnAll($applications);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\JobApplication  $jobApplication
     * @return \Illuminate\Http\Response
     */
    public function show(JobApplication $jobApplication)
    {
        return response()->json($jobApplication);
    }

}
