<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    //
    /**
     * Register a new user.
     */
    // public function register(Request $request)
    // {
    //     $fields = $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);

    //     $user = User::create([
    //         'name' => $fields['name'],
    //         'email' => $fields['email'],
    //         'password' => Hash::make($fields['password']),
    //     ]);

    //     $token = $user->createToken('mobile')->plainTextToken;

    //     return response()->json([
    //         'message' => 'User registered successfully',
    //         'user' => $user,
    //         'token' => $token,
    //     ], 201);
    // }

    /**
     * Login user and return access token.
     * 
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password.'],
            ]);
        }

        // Delete old tokens (optional for security)
        $user->tokens()->delete();

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Return the authenticated user.
     * 
     * @param Request $request
     * @return Response
     */
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    /**
     * Logout user and revoke token.
     * 
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Logout user from all devices (optional).
     * 
     * @param Request $request
     * @return Response
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out from all devices',
        ]);
    }

    /**
     * Send a password reset link to the user's email.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Use Laravel’s built-in Password Broker
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], 200);
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }

    /**
     * Change password for authenticated (API) user.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'], // expects new_password_confirmation
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        $user->forceFill([
            'password' => Hash::make($request->new_password),
        ])->save();

        // (Optional) Revoke all other tokens for security
        $user->tokens()->delete();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }


}
