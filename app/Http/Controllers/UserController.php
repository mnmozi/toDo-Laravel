<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{
    public function signup(Request $request)
    {
      $this->validate($request,[
          'name'=>'required',
          'email'=>'required|email|unique:users',//the unique work like this pass argument and the table name
          'password'=>'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])/'
      ]);
      $user = new User([
          'name'=>$request->input('name'),
          'email'=>$request->input('email'),
          'password'=>bcrypt($request->input('password'))
      ]);
      $user->save();
      return response()->json([
          'message'=>'Successfully created user!'
      ],201);

    }
    
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function signin(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $credentials = request(['email', 'password']);
        try{
            if (! $token= auth()->attempt($credentials)){
                return response()->json([
                   'error'=>'invalid User'
                ],401);
            }
        }catch(JWTException $e){
            return response()->json([
                'error'=>'could not create token!'
             ],500);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}