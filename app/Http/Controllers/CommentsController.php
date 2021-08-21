<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
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

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->id;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'comment added'
        ]);

    }

    public function update(Request $request){
        $comment = Comment::find($request->id);

        if($request->user_id != Auth::user()->id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorize access'
            ]);
        }

        $comment->comment = $request->comment;
        $comment->update();

        return response()->json([
            'success' => false,
            'message' => 'comment edited'
        ]);

    }

    public function delete(Request $request){
        $comment = Comment::find($request->id);

        if($request->user_id != Auth::user()->id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorize access'
            ]);
        }

        $comment->delete();

        return response()->json([
            'success' => false,
            'message' => 'comment deleted'
        ]);

    }


    public function comments(Request $request){

        $comments = Comment::where('post_id',$request->id)->get();

        foreach($comments as $comment){
            $comment->user;
        }

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);

    }


}
