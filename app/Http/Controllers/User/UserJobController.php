<?php

namespace App\Http\Controllers\User;

use App\Job;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers;
use App\Http\Controllers\FcmController;

class UserJobController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $jobs = $user->jobs()
            ->with('applications')
            ->get();
        return $this->returnAll($jobs);
    }


    public function store(Request $request, User $user)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'city' => 'required',
            'wage' => 'numeric|min:25',
            'employer' => 'required',
            'requirements' => 'required'
        ];
        $this->validate($request,$rules);
        $data = $request->all();
        $data['user_id']= $user->id;
        $data['notes']= "nema";

        $job = Job::create($data);

        $fcmController = new FcmController();
        $title = "Dodan je novi posao!";
        $body = "Klikni i saznaj više!";
        $fcmController->sendNotificationToAll($fcmController->getAllTokens(),$title,$body,$job);
        return response()->json($job,201);

    }


    public function update(Request $request, User $user	, Job $job)
    {
        $this->checkEmployer($user,$job);

        $job->fill($request->all());

        $job->save();
        return $this->returnOne($job);
    }


    public function destroy(User $user, Job $job)
    {
        $this->checkEmployer($user,$job);
        $job->delete();
        return $this->returnOne($job);
    }

    protected function checkEmployer(User $user, Job $job)
    {
        if($user->id != $job->user_id){
            throw new HttpException(422, 'Nije vlasnik posla!');
        }
    }
}
