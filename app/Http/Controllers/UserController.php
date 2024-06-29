<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use Carbon\Carbon;

class UserController extends Controller
{
    //

    public function index(){
        $users=User::all();
        return view('index',compact('users'));
    }

    public function show(User $user){

        $currentDateTime = Carbon::now();
        $posts = User::with(['posts'=>function($query)use($currentDateTime){
            $query->where('publish_at','<=',$currentDateTime);
        }]);
       
        return view('posts.index', compact('user','posts'));
    }
}
