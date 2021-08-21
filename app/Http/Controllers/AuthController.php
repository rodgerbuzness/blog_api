<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
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


    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        
        if($validator->fails()){
            $code = 400;
            $output = array(
                'error' => true,
                'code' => $code,
                'message' => $validator->errors()->all()
            );

            return response()->json($output,$code);
        }



        $encryptedPass = Hash::make($request->password);

        $user = new User();

        try{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $encryptedPass;
            $user->save();

            return $this->login($request);
        }
        catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);

        }

    }


    public function login(Request $request)
    {

        $creds = $request->only(['email','password']);

        $user = new User();
        $user->email = $request->email;
        $user->password = $request->password;

        if(!$token=Auth::attempt($creds)){
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials'
            ]);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public function logout(Request $request)
    {
        try{
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'logout success'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        
    }

    
}
