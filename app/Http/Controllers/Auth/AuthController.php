<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a new user
     *
     * @param RegistrationRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(RegistrationRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            return sendResponse(
                'User registered successfully',
                $user,
                Response::HTTP_CREATED
            );
        } catch (\Exception $exception) {
            return sendInternalServerError($exception);
        }
    }
    /**
     * Login user
     *
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->guard('api')->attempt($data)) {
            $user = Auth::guard('api')->user();
            $response = [
                'token' => JWTAuth::fromUser($user),
                'user' => $user,
            ];
            return sendResponse(
                'Login successfully.',
                $response,
                Response::HTTP_OK
            );
        } else {
            return sendError(
                'Credentials not match.',
                [],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
