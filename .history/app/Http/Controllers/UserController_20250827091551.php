<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Traits\ApiResponse;

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
            return $this->errorResponse('You must be logged in to view this user.', );
        }

        $token = JWTAuth::getToken();
        if (!$token) {
            return $this->errorResponse('Token not found.', 401);
        }

        return $this->successUserResponse($user, (string) $token);
    }

    public function store(StoreRequest $request)
    {
        $user = $this->user->create($request->validated()['user']);
        Auth::guard('api')->login($user);
        $token = JWTAuth::fromUser($user);

        return $this->successUserResponse($user, $token, 'User created and logged in successfully');
    }

    public function update(UpdateRequest $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user instanceof User) {
            return $this->errorResponse('You must be logged in to update your profile.', 401);
        }

        $user->update($request->validated()['user']);
        $token = JWTAuth::fromUser($user);

        return $this->successUserResponse($user, $token, 'User updated successfully');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated()['user'] ?? $request->validated();

        if ($token = Auth::guard('api')->attempt($credentials)) {
            $user = Auth::guard('api')->user();
            return $this->successUserResponse($user, $token, 'Logged in successfully');
        }

        return $this->errorResponse('Invalid credentials', 403);
    }

    protected function successUserResponse(User $user, string $jwtToken, string $message = 'Success')
    {
        return $this->successResponse([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'token' => $jwtToken,
        ], $message);
    }
}
