<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\ApiController;
use App\Job;
use Illuminate\Http\Request;

class JobController extends ApiController
{

    public function index()
    {
        $jobs = Job::all();
        return $this->returnAll($jobs->reverse());
    }

    public function show(Job $job)
    {
        //$this->returnOne($job);
        return response()->json($job,200);
    }
    public function destroy(Job $job)
    {
        $job->delete();

        return $this->returnOne($job);
    }
}
