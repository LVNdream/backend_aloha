<?php

namespace App\Http\Controllers;

use App\Models\majoring;
use App\Models\majorings;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    // }
    //  ham xu li add user
    public function addUser(Request $request)
    {

        try {
            $request->validate([
                "email" => "required| email:rfc,dns",
                "password" => "required",
                "majoring_id" => "required",
                "fullname" => "required",
                "birthday" => "required |date_format:Y-m-d",
                "gender" => "required",
                "phone" => "required",
                "avata" => "required",
            ]);

            $user = User::create(
                [
                    "email" => $request['email'],
                    "password" => $request['password'],
                    "group" => $request['group'],
                ]
            );
            $user->user_infor()->create([
                "majoring_id" => $request['majoring_id'],
                "fullname" => $request["fullname"],
                "birthday" => $request["birthday"],
                "gender" => $request["gender"],
                "phone" => $request["phone"],
                "avata" => $request["avata"],
            ]);


            return response()->json($data = 'Add user successfully', $status = 200);
        } catch (\Exception $e) {

            return $e;
        }
    }



    // public function signin(Request $request)
    // {
    //     try{
    //         $request->validate([
    //             "email"=>"required| email:rfc,dns",
    //             "password" => "required",
    //         ]);

    //     $user = User::where('email',$request['email'])->first();

    //         if(!$user)  return response()->json($data = 'Email not valid', $status = 200);

    //         if (!(Hash::check($request['password'], $user['password']))) return response()->json($data = 'Password not valid', $status = 200);

    //         return response()->json($data = 'Login successfully', $status = 200);
    //     }
    //     catch(\Exception $e){
    //         return $e;
    //     }
    // }



    public function login(Request $request)
    {
        try {
            // $credentials = request(['email', 'password']);

            // if (! $token = auth()->attempt($credentials)) {
            //     return response()->json(['error' => 'Unauthorized'], 401);
            // }

            $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);

            $user = User::where('email', $request['email'])->first();

            if (!$user)  return response()->json($data = 'Email not valid', $status = 200);

            $token = JWTAuth::attempt([
                "email" => $request['email'],
                "password" => $request['password'],
            ]);

            if (empty($token)) return response()->json([
                "status" => false,
                "message" => "Login faild"
            ]);

            return $this->respondWithToken($token);
        } catch (\Exception $err) {
            return $err;
        }
    }

    public function profile()
    {
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "user" => $userData
        ]);
    }


    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status'=>true,
            'message' => 'Successfully logged out',
            
        ]);
    }


    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }


    public function addMajoring(Request $request)
    {
        try {
            $request->validate([
                'majoring_name' => 'required',
            ]);
            $majoring = majoring::create(
                $request->all()
            );
            return response()->json($data = 'Add majoring successfully', $status = 200);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }
}
