<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Helper\Validate;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //Authentikasi
    public function register(Request $request) {
        try {
            $this->validate($request, Validate::register());
            $input = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ];
    
            $user = User::create($input);
            if ($user) {
                $response = [
                    'user' => User::latest()->first() ?? User::where('name', $request->name)->where('email', $request->email)->first(),
                    'token' => mt_rand()
                ];
                User::where('name', $request->name)
                ->where('email', $request->email)
                ->where('password', $request->password)
                ->update(['remember_token' => $response['token']]);
                return Response::res($response, 'User Created Successfully', 201);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return Response::res('Failed to create user', 400);
        }
    }

    public function login(Request $request) {
        try {
            $this->validate($request, Validate::login());
            $user = User::where('email', $request->email)
            ->where('password', $request->password)
            ->first();
            if ($user) {
                $response = [
                    'user' => $user,
                    'token' => mt_rand()
                ];
                User::where('email', $request->email)
                    ->where('password', $request->password)
                    ->update(['remember_token' => $response['token']]);
                return Response::res($response, 'User Login Successfully', 200);
            } else {
                return Response::res('Invalid Email or Password', 400);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return Response::res('Failed to login', 400);
        }
    }
}
