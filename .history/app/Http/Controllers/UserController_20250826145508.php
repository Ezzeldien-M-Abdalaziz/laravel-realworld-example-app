<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        return $this->userResponse(Auth::guard('api')->getToken()->get());
    }

    public function store(StoreRequest $request): array
    {
        $user = $this->user->create($request->validated()['user']);
        $token = Auth::guard('api')->login($user);
        return $this->userResponse($token);
    }

    public function update(UpdateRequest $request): array
    {
        Auth::guard('api')->user()->update($request->validated()['user']);
        return $this->userResponse(Auth::guard('api')->getToken()->get());
    }

    public function login(LoginRequest $request): array
    {
        if ($token = Auth::guard('api')->attempt($request->validated()['user'])) {
            return $this->userResponse($token);
        }

        abort(Response::HTTP_FORBIDDEN);
    }

    protected function userResponse(string $jwtToken): array
    {
        return ['user' => ['token' => $jwtToken] + Auth::guard('api')->user()->toArray()];
    }
}
