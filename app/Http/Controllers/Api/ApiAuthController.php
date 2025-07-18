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
    /**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="Login user and get JWT token",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="test@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="msg", type="string", example="User Login Successfully"),
 *             @OA\Property(property="result", type="object",
 *                 @OA\Property(property="token", type="string"),
 *                 @OA\Property(property="token_type", type="string", example="bearer"),
 *                 @OA\Property(property="user", type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="John Doe"),
 *                     @OA\Property(property="email", type="string", example="john@example.com")
 *                 )
 *             )
 *         )
 *     )
 * )
 */
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

    /**
 * @OA\Post(
 *     path="/api/register",
 *     tags={"Authentication"},
 *     summary="Register new user and return JWT token",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "phone", "password"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="phone", type="string", example="01700000000"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="msg", type="string", example="User registered successfully!"),
 *             @OA\Property(property="result", type="object",
 *                 @OA\Property(property="token", type="string"),
 *                 @OA\Property(property="token_type", type="string", example="bearer"),
 *                 @OA\Property(property="user", type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="John Doe"),
 *                     @OA\Property(property="email", type="string", example="john@example.com")
 *                 )
 *             )
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\Post(
 *     path="/api/logout",
 *     tags={"Authentication"},
 *     summary="Logout user (JWT token invalidation)",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Logout successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="msg", type="string", example="Logout successfully."),
 *             @OA\Property(property="result", type="string", nullable=true, example=null)
 *         )
 *     )
 * )
 */

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
