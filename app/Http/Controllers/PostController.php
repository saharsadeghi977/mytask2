<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Repositories\FileRepository;
use App\Http\Services\AttachmentService;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\post;
use App\Models\Fileable;
use App\Models\File;
use Illuminate\support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $posts=Auth::user()->posts;
        return view('posts.index',compact('posts'));
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
        return view('posts.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $file=(new FileRepository())->upload('image', ['public']);
       
        $request->merge(['user_id'=> auth()->user()->id]);
        if($request->validated()){
            $post=Post::create([
                'name'=> $request->input('name'),
                'type' => $request->input('type'),
                'slug'=>$request->input('slug'),
                'description'=>$request->input('description'),
                'image'=>$request->input('image'),
                 'publish_at'=>$request->input('publish_at'),
                 'user_id'=>$request->input('user_id'),
            ]); 
        }
        
        return redirect(route('posts.index', compact('post')));

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
       
    }

   
    public function destroy(post $post)
    {
      
    }
}
