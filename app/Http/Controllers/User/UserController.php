<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function index()
    {
        $users = User::all();
        return $this->returnAll($users);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
        $this->validate($request, $rules);

        $data = $request->all();

        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::VERIFIED;
        $data['verification_token'] = User::generateVerificationToken();

        $user = User::create($data);

        return response()->json(['data'=>$user],201);
    }

    public function show(User $user)
    {
        return $this->returnOne($user);
    }

    public function update(Request $request, User $user)
    {
        if ($request->has('name')) {
            $user->name=$request->name;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return $this->returnOne($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return $this->returnOne($user);
    }
}
