<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
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

    public function like(Request $request){

        $like = Like::where('post_id',$request->id)->where('user_id',Auth::user()->id)->get();

        if(count($like) > 0){
            $like[0]->delete();
            return response()->json([
                'success' => true,
                'meessage' => 'unliked'
            ]);
        }

        $like = new Like();
        $like->user_id = Auth::user()->id;
        $like->post_id = $request->id;
        $like->save();

        return response()->json([
            'success' => true,
            'meessage' => 'liked'
        ]);

    }
}
