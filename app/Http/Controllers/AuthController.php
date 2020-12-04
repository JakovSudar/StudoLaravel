<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;

        try{
            $response = $http->post('http://studo.test/oauth/token',[
                'form_params' => [
                    'grant_type' =>'password',
                    'client_id' => 2,
                    'client_secret' => 'wtCn03fJNWpa6FqbW0FrrKEeL7jonAIov1dInD3r',
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' =>'',
                ],
            ]);
            return $response->getBody();

        } catch(\GuzzleHttp\Exception\BadResponseException $e){
            if($e->getCode() == 400){
                return response()->json('Invalid Request nesta nevalja', $e->getCode());
            } else if ($e->getCode() == 401){
                return response()->json('Bad credentials.', $e->getCode());
            }
            return response()->json('Something went wrong', $e->getCode());
        }
    }

    public function logout()
    {
        auth()->user()->tokens->each(function($token,$key){
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);

    }
}
