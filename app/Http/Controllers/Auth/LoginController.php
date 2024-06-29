<?php

namespace App\Http\Controllers\Auth;
 use App\Http\Controllers\Auth\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
 use Illuminate\Http\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
class LoginController extends Controller
{
    //
     public function showLoginForm(){
      return view('auth.login');
     }

     
    public function login(LoginRequest $request)
    {
       if(!Auth::attempt($request->only('email','password'))){
        return redirect()->back();
       }
       $user=$request->user();
       $token=$user->createToken('authToken')->plainTextToken;
       return redirect()->route('home')->with('token',$token);
    }



    public function logout(LoginRequest $request){
      $request->user()->currentAccessToken()->delete();
      return redirect()->route('home')->with('message','logged out successfulyy');
    }
    }