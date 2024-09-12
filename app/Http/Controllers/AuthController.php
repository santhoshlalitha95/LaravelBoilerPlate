<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     summary="Register a user",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="name", type="string", example="rohit sharma"),
     *             @OA\Property(property="email", type="string", example="rohitt@abcd.com"),
     *             @OA\Property(property="password", type="string", example="1234$@12"),
     *             @OA\Property(property="password_confirmation", type="string", example="1234$@12"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Successfully created",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="message", type="string", example="User successfully registered"),
     *             @OA\Property(property="user", type="object", example = {"name": "rohit sharma", "email": "rohitt@abcd.com"}),
     *             @OA\Property(property="token", type="string", example="ewetewdsgdsgsdgdsgdsgdsgdsgdsgdgdzrwehqwoicbarwfawnaoivaejkbaebaeboeaslkvsklcnsd")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *
     *     @OA\Tag(name="User Auth")
     * )
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (! is_string($validated['password'])) {
            return response()->json([
                'error' => 'Invalid password format',
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *     path="/api/user/login",
     *     summary="Login user",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="email", type="string", example="rohitt@abcd.com"),
     *             @OA\Property(property="password", type="string", example="1234$@12")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successfully created",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="message", type="string", example="User successfully login"),
     *             @OA\Property(property="token", type="string", example="ewetewdsgdsgsdgdsgdsgdsgdsgdsgdgdzrwehqwoicbarwfawnaoivaejkbaebaeboeaslkvsklcnsd")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *
     *     @OA\Tag(name="User Auth")
     * )
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'User successfully login',
            'token' => $token,
        ], Response::HTTP_OK);
    }
}
