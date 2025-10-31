<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Services\CartService;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected CartService $cartService,
    ) {}

    /**
     * POST /api/register
     * Register a new user and issue an API token.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => UserRole::Customer, // Default role - only customers can register
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->created([
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role->value ?? $user->role, // fallback if not enum
            ],
            'token' => $token,
        ]);
    }

    /**
     * POST /api/login
     * Authenticate a user and issue a new token.
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // Invalid credentials
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->error('INVALID_CREDENTIALS', __('auth.failed'), [
                'email' => ['The provided credentials are incorrect.'],
            ], 422);
        }

        // Create new token (optionally revoke previous ones)
        // $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;

        // 🛒 Merge guest cart into user cart if a guest token exists
        $guestToken = $request->get('cart_token');
        if ($guestToken) {
            try {
                $this->cartService->mergeGuestCart($guestToken, $user->id);
            } catch (\Throwable $e) {
                // Do not block login on merge failure
            }
        }

        return $this->ok([
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role->value ?? $user->role,
            ],
            'token' => $token,
        ]);
    }

    /**
     * POST /api/logout
     * Revoke the current API token.
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();
        if ($token) {
            $token->delete();
        }

        return $this->ok(['message' => __('Logged out successfully')]);
    }

    /**
     * GET /api/user
     * Retrieve the currently authenticated user's details.
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->ok([
            'id'               => $user->id,
            'name'             => $user->name,
            'email'            => $user->email,
            'role'             => $user->role->value ?? $user->role,
            'email_verified_at'=> $user->email_verified_at,
            'created_at'       => $user->created_at,
        ]);
    }

    /**
     * POST /api/logout-all
     * Revoke all issued API tokens for the authenticated user.
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->ok(['message' => __('All sessions revoked successfully')]);
    }
}
