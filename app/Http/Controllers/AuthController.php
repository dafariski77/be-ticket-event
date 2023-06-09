<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|string",
            "password" => "required|string",
            "confirmPassword" => "required|string"
        ]);

        if($request->password !== $request->confirmPassword) {
            return response()->json([
                "message" => "Invalid Password!"
            ], Response::HTTP_BAD_REQUEST);
        }

        $email = User::firstWhere("email", $request->email);

        if ($email) {
            return response()->json([
                "message" => "Email already registered!"
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password
        ]);

        return response([
            "message" => "User Registered!",
            "data" => $user
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|string",
            "password" => "required|string"
        ]);

        $user = User::firstWhere("email", $request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "Invalid Credentials!"], Response::HTTP_BAD_REQUEST);
        }

        $token = $user->createToken("sanctum_token")->plainTextToken;

        return response()->json([
            "message" => "Login success!",
            "token" => $token
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "Logout Success"
        ], Response::HTTP_OK);
    }
}
