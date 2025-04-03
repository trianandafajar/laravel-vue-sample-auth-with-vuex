<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Login API
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // 🔹 Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        // 🔹 Cek kredensial user
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->sendError('Unauthorized.', ['error' => 'Email atau password salah'], 401);
        }

        // 🔹 Jika login berhasil, buat token
        $user = Auth::user();
        $token = $user->createToken('MyApp')->accessToken;

        return $this->sendResponse([
            'token' => $token,
            'name' => $user->name,
        ], 'User login successfully.');
    }

    /**
     * Logout API
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            // 🔹 Revoke semua token user
            $request->user()->tokens->each(function ($token) {
                $token->revoke();
            });

            return $this->sendResponse([], 'User logged out successfully.');
        }

        return $this->sendError('Unauthorized.', ['error' => 'User tidak terautentikasi'], 401);
    }
}
