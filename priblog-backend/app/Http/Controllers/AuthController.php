<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()
            ->create($request->validated());

        return UserResource::make($user)
            ->response();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (! auth()->attempt($credentials)) {
            return response()
                ->json(['message' => 'The given data was invalid'], 422);
        }

        /** @var User $user */
        $user = User::query()->where('email', '=', $request->input('email'))
            ->first();

        $token = $user->createToken('test-token')->plainTextToken;

        return response()->json(['acces_token' => $token]);
    }
}
