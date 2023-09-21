<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Models\User;

class AuthController extends ParentController
{
    /**
     * Create user 
     * return sunctum token and user
     * 
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken("api_token")->plainTextToken;
            $user["api_token"] = $token;

        }catch (Exception $e) {
            info($e);
            return $this->sendError($e->getMessage(), 500);
        }

        return $this->sendResponse($user, 'User create successfully', 201);
    }

    /**
     * Login user 
     * return sunctum token and user
     * 
     */
    public function login(LoginRequest $request)
    {
        try {
            if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = auth()->user();
                $token = $user->createToken("api_token")->plainTextToken;
                $user["api_token"] = $token;
                return $this->sendResponse($user, 'User login successfully', 200);
            } else {
                return $this->sendError("login or password incorrect", 401);
            }
        }catch (Exception $e) {
            info($e);
            return $this->sendError($e->getMessage(), 500);
        }
    }
}
