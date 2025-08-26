<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show(): array
    {
        $user = Auth::guard('api')->user();

        if (!$user instanceof User) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        $token = JWTAuth::getToken();
        if (!$token) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return $this->userResponse((string) $token);
    }

    public function store(StoreRequest $request): array
{
    $user = $this->user->create($request->validated()['user']);
    Auth::guard('api')->login($user);
    $token = JWTAuth::fromUser($user);
    return $this->userResponse($token,);
}
    public function update(UpdateRequest $request): array
    {
        $user = Auth::guard('api')->user();
        if (!$user instanceof User) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        $user->update($request->validated()['user']);

        // either keep the current token or issue a new one
        $token = JWTAuth::refresh(JWTAuth::getToken());

        return $this->userResponse($token);
    }

    public function login(LoginRequest $request): array
    {
        $credentials = $request->validated();
        if ($token = Auth::guard('api')->attempt($credentials)) {
            return $this->userResponse($token);
        }
        abort(Response::HTTP_FORBIDDEN);
    }

    protected function userResponse(string $jwtToken): array
    {
        $user = Auth::guard('api')->user();
        if (!$user instanceof User) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        return [
            'user' => [
                'token' => $jwtToken,
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ]
        ];
    }
}
