<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\Helper;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => 'The provided credentials are incorrect.',
                ]);
            }

            if ($user->status !== 'Active') {
                throw ValidationException::withMessages([
                    'email' => 'Your account is deactivated.',
                ]);
            }

            $token = JWTAuth::fromUser($user);
            $user = new UserResource($user);

            $data = [
                'token'      => $token,
                'token_type' => 'bearer',
                'user'       => $user,
            ];

            return Helper::sendResponse($data, "User Login Successfully");

        } catch (ValidationException $exception) {
            throw $exception;

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return Helper::sendError('Something went wrong');
        }

    }

    public function register(RegisterRequest $request)
    {
        try {
            // Create user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'role'     => 'user',
                'status'   => 'Active',
                'password' => Hash::make($request->password),
            ]);

            // Generate JWT token
            $token = JWTAuth::fromUser($user);
            $user  = new UserResource($user);

            $data = [
                'token'      => $token,
                'token_type' => 'bearer',
                'user'       => $user,
            ];

            return Helper::sendResponse($data, 'User registered successfully!');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return Helper::sendError('Something went wrong during registration.');
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return Helper::sendResponse(null, 'Logout successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return Helper::sendError('Logout failed.');
        }
    }
}
