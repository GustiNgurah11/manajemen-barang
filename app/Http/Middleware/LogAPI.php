<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\LogModel;
use App\Helpers\ApiFormatter;
use Throwable;

class LogAPI
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = null;

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            $user = null;
        }

        // filter request agar data sensitif tidak tersimpan
        $filteredRequest = ApiFormatter::filterSensitiveData($request->all());

        // jalankan request dulu
        try {
            $response = $next($request);

            // simpan log response aman, batasi panjang response
            $log = LogModel::create([
                'user_id'      => $user?->id,
                'log_method'   => $request->method(),
                'log_url'      => $request->fullUrl(),
                'log_ip'       => $request->ip(),
                'log_request'  => json_encode($filteredRequest),
                'log_response' => Str::limit($response->getContent(), 1000), // batasi
            ]);

            return $response;

        } catch (Throwable $e) {

            $errorResponse = ApiFormatter::createJson(500, 'Internal Server Error', $e->getMessage());

            // simpan log error, batasi panjang
            LogModel::create([
                'user_id'      => $user?->id,
                'log_method'   => $request->method(),
                'log_url'      => $request->fullUrl(),
                'log_ip'       => $request->ip(),
                'log_request'  => json_encode($filteredRequest),
                'log_response' => Str::limit(json_encode($errorResponse), 1000), // batasi
            ]);

            return response()->json($errorResponse, 500);
        }
    }
}
