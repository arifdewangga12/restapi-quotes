<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
       $this->validate($request,[
         'name' => 'required',
         'email' => 'required|email|unique:users,email',
         'password' => 'required'
       ]);
       $user = User::create([
         'name' => $request->name,
         'email' => $request->email,
         'password' => bcrypt($request->password),
         'api_token' => Str::random(80),
       ]);
       return (new UserResource($user))->additional([
         'meta' => [
           'token' => $user->api_token,
         ]
       ]) ;

    }

    public function login(Request $request)
    {
      $this->validate($request,[
        'email' => 'required|email',
        'password' => 'required'
      ]);

      if(auth()->attempt($request->only('email','password'))){
        $currentUser = auth()->user();

        return (new UserResource($currentUser))->additional([
          'meta' => [
            'token' => $currentUser->api_token,
          ],
        ]) ;
      }
      return  response()->json([
        'error' => 'Login Error',
      ], 404);
    }
}
