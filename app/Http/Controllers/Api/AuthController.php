<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiFormatter;

use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(ApiFormatter::createJson(400, 'Bad Request', $validator->errors()->all()), 400);
            }

            // cek user
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(ApiFormatter::createJson(404, 'Account not found'), 404);
            }

            // cek password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json(ApiFormatter::createJson(401, 'Password does not match'), 401);
            }

            // generate token
            $token = JWTAuth::fromUser($user);

            $expiration = Carbon::now()->addMinutes(config('jwt.ttl'));

            $info = [
                'type'    => 'Bearer',
                'token'   => $token,
                'expires' => $expiration->format('Y-m-d H:i:s'),
            ];

            return response()->json(ApiFormatter::createJson(200, 'Login successful', $info), 200);

        } catch (\Exception $e) {
            return response()->json(ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage()), 500);
        }
    }

    public function me()
    {
        $user    = JWTAuth::parseToken()->authenticate();
        $payload = JWTAuth::parseToken()->getPayload();

        $data = [
            'name'  => $user->name,
            'email' => $user->email,
            'exp'   => $payload->get('exp'),
        ];

        return response()->json(ApiFormatter::createJson(200, 'Logged in user', $data), 200);
    }

    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();

            $expiration = Carbon::now()->addMinutes(config('jwt.ttl'));

            $info = [
                'type'    => 'Bearer',
                'token'   => $newToken,
                'expires' => $expiration->format('Y-m-d H:i:s'),
            ];

            return response()->json(ApiFormatter::createJson(200, 'Successfully refreshed', $info), 200);

        } catch (\Exception $e) {
            return response()->json(ApiFormatter::createJson(500, 'Failed to refresh token', $e->getMessage()), 500);
        }
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(ApiFormatter::createJson(200, 'Successfully logged out'), 200);
    }
}
