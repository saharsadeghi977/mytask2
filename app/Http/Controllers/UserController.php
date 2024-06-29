<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\post;
use App\Models\Fileable;
use App\Models\File;
use Carbon\Carbon;

class UserController extends Controller
{
    //

    public function index(){
        $users=User::all();
        return view('index',compact('users'));
    }

    public function show($user){

        $currentDateTime = Carbon::now();
        $posts = Post::query()->with(['files'])->where("user_id",$user)->where('publish_at','<=',$currentDateTime)->get();
        return view('posts.index', compact('posts'));
    }
}
