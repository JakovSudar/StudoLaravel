<?php

namespace App\Http\Controllers\User;
use App\Job;
use App\User;
use App\JobApplication;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\FcmController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserJobApplicationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $applications = $user->applications()->with("job")
            ->get();
            //->pluck('job');
        return response()->json($applications);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,  User $user)
    {
        $rules = [
            'about_me' => 'required',
            'job_id' => 'required',
            'phone' => 'required',
            'email' => 'email|required'
        ];
        $this->validate($request,$rules);

        $data = $request->all();
        $data['user_id']= $user->id;
        $appliedJobs = $user->applications;
        foreach($appliedJobs as $job){
            if($job->job_id == $data['job_id']){
                return response()->json("Vec si prijavljen!",405);
            }
        }
        if($user->type == User::STUDENT){
            $jobApp = JobApplication::create($data);
            $fcmController = new FcmController();
            $job = Job::where('id',$data['job_id'])->get()->first();

            $fcmController->sendNotificationToEmployer($job);
            return response()->json($jobApp,201);
        }else
            return response()->json("Nije student",400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }


    public function destroy(User $user, JobApplication $jobApplication)
    {
        $this->checkUser($user,$jobApplication);
        $jobApplication->delete();
        return response()->json($jobApplication,200);
    }

    protected function checkUser(User $user, JobApplication $jobApplication)
    {
        if($user->id != $jobApplication->user_id){
            throw new HttpException(422, 'Nije vlasnik prijave!');
        }
    }
}
