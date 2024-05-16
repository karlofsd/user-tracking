<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function index()
    {
        $users = User::all();
        $data = [
            'users' => $users
        ];

        return response()->json($data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|unique:users,email',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Request field error',
                'errors' => $validator->errors()
            ], 400);
        }

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();


        return response()->json($user);
    }

    public function signin(Request $request)
    {
        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $user->token =  $token;
            return response()->json([
                'user' => $user
            ]);
        } else {
            return response('Access denied', HttpResponse::HTTP_UNAUTHORIZED);
        }
    }
}
