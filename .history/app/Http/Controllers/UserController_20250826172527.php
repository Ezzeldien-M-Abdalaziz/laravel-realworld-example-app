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
        $token = JWTAuth::getToken();
        if (!$token) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        return $this->userResponse($token->get());
    }

    public function store(StoreRequest $request): array
    {
        $user = $this->user->create($request->validated()['user']);
        $token = JWTAuth::fromUser($user);
        return $this->userResponse($token);
    }

    public function update(UpdateRequest $request): array
    {
        $user = Auth::guard('api')->user();
        if (!$user instanceof User) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        $user->update($request->validated()['user']);
        $token = JWTAuth::getToken();
        return $this->userResponse($token ? $token->get() : JWTAuth::fromUser($user));
    }

    public function login(LoginRequest $request): array
    {
        // if ($token = Auth::guard('api')->attempt($request->validated()['user'])) {
        //     return $this->userResponse($token);
        // }
        return $request->validated();

        if ($token = Auth::guard('api')->attempt($request->validated())) {
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
                'name' => $user->name,
                'email' => $user->email,
            ]
        ];
    }
}
