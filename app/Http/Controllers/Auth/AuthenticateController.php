<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
        	// if(!Auth::attempt($credentials)){
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            $user = Auth::user();
            $roles = DB::table('user_role_xref')->where('user_id', $user->id)->get();
            // dd($roles);
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token', 'roles'));
    }

    public function index(Request $request){
		$user = JWTAuth::parseToken()->authenticate();
    	return response()->json($user);
    }
}
