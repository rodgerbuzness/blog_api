<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Request $request){

        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->desc = $request->desc;

        if($request->photo != ''){
            $photo = time().'jpg';
            file_put_contents('storage/posts/'.$photo,base64_decode($request->$photo));
            $post->photo = $photo;
        }

        $post->save();
        $post->user;

        return response()->json([
            'success' => true,
            'message'=> 'posted',
            'post' => $post
        ]);

    }

    public function update(Request $request){

        $post = Post::find($request->id);

        if(Auth::user()->id != $request->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }

        $post->desc = $request->desc;
        $post->update();
        return response()->json([
            'success' => true,
            'message' => 'post edited'
        ]);

    }

    public function delete(Request $request){

        $post = Post::find($request->id);

        if(Auth::user()->id != $request->id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }

        if($post->photo != ''){
            Storage::delete('public/posts/'.$post->photo);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'post deleted'
        ]);

    }

    public function posts(){
        $posts = Post::orderBy('id','desc')->get();
        foreach($posts as $post){
            $post->user;
            $post['commentsCount'] = count($post->comments);
            $post['likesCount'] = count($post->likes);
            $post['selfLike'] = false;
            foreach($post->likes as $like){
                if($like->user_id == Auth::user()->id){
                    $post['selfLike'] = true;
                }
            }
        }

        return response()->json([
            'success' => true,
            'posts' => $posts
        ]);
    }
}
