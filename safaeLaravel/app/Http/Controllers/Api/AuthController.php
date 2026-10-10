<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'telepon' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $user = User::create([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'username' => $request->username,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => Hash::make($request->password),
            'points' => 0,
            'role' => 'user',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ResponseHelper::success([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'User registered successfully', 201);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return ResponseHelper::error('Invalid credentials', 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return ResponseHelper::success([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ResponseHelper::success(null, 'Logout successful');
    }

    /**
     * Get authenticated user profile
     */
    public function profile(Request $request)
    {
        $user = $request->user()->load(['readingProgress', 'pointHistories', 'favoriteBooks']);
        
        return ResponseHelper::success($user, 'Profile retrieved successfully');
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'nama_depan' => 'sometimes|string|max:255',
            'nama_belakang' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->only(['nama_depan', 'nama_belakang', 'username', 'email', 'telepon']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return ResponseHelper::success($user, 'Profile updated successfully');
    }
}
