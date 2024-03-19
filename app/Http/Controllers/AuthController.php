<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request):JsonResponse
    {
        $user = new User();
        $user->name = $request->post('name');
        $user->email = $request->post('email');
        $user->phone_number = $request->post('phone_number');
        $user->password = bcrypt($request->post('password'));
        $user->save();

        return response()->json([
            'message' => 'You are registration successfully!',
        ], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->userAgent())->plainTextToken,
            'token_type' => 'Bearer',
            'user' => UserResource::make($user),
        ], 200);
    }


    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
