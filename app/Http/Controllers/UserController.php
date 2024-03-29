<?php

namespace App\Http\Controllers;

use App\Models\majoring;
use App\Models\majorings;
use App\Models\status;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\user_infor;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{

    
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


    public function login(Request $request)
    {
        try {
            

            $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);

            $user = User::where('email', $request['email'])->first();

            if (!$user)  return response()->json($data = ['mess' => 'Email not valid'], $status = 201);

            $token = JWTAuth::attempt([
                "email" => $request['email'],
                "password" => $request['password'],
            ]);

            if (empty($token)) return response()->json(
                $data = ['mess' => 'Password not valid'],
                $status = 201
            );

            $user = auth()->user();
            $user->user_infor;
            return
                response()->json($data = [
                    'mess' => "Login successful",
                    'access_token' => $token,
                    'user' => $user,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::factory()->getTTL() * 60
                ], $status = 200);
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
            'status' => true,
            'message' => 'Successfully logged out',

        ], 200);
    }


    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json($data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], $status = 200);
    }


    public function getMajoring()
    {
        try {

            $majorings = majoring::get();
            return response()->json(
                $majorings,
                200
            );
        } catch (\Exception $error) {
            return ($error);
        }
    }

    public function getStatus()
    {
        try {

            $status = status::get();
            return response()->json(
                $status,
                200
            );
        } catch (\Exception $error) {
            return ($error);
        }
    }


    public function getUserByMajoring(Request $request, string $majoring_id)
    {
        try {
            // return $request;
            // return $majoring_id;

            $users = user_infor::where('majoring_id', $majoring_id)->get();

            foreach ($users as $item) {
                $item->user;
            }
            return response()->json(
                $users,
                200
            );
        } catch (\Exception $error) {
            return ($error);
        }
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
