<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    use ApiResponse;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show()
    {
        $user = Auth::guard('api')->user();
        if (!$user instanceof User) {
            return $this->errorResponse('You must be logged in to view this user.',  Response::HTTP_UNAUTHORIZED);
        }

        $token = JWTAuth::getToken();
        if (!$token) {
            return $this->errorResponse('Token not found.', Response::HTTP_UNAUTHORIZED);
        }

        return $this->successUserResponse($user, (string) $token);
    }

    public function store(StoreRequest $request)
    {
        $user = $this->user->create($request->validated()['user']);
        Auth::guard('api')->login($user);
        $token = JWTAuth::fromUser($user);

        return $this->successUserResponse($user, $token);
    }

    public function update(UpdateRequest $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user instanceof User) {
            return $this->errorResponse('You must be logged in to update your profile.', Response::HTTP_UNAUTHORIZED);
        }

        $user->update($request->validated()['user']);
        $token = JWTAuth::fromUser($user);

        return $this->successUserResponse($user, $token);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated()['user'] ?? $request->validated();

        if ($token = Auth::guard('api')->attempt($credentials)) {
            $user = Auth::guard('api')->user();
            return $this->successUserResponse($user, $token);
        }

        return $this->errorResponse('Invalid credentials',Response::HTTP_FORBIDDEN);
    }

    protected function successUserResponse(User $user, string $jwtToken)
    {
        return response()->json([
            'user' => [
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
                'token'    => $jwtToken,
                'bio'      => $user->bio ?? '',
                'image'    => $user->image ?? null,
            ]
        ]);
    }
}
