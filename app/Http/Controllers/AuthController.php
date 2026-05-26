<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Utils\DateUtil;
use App\Services\MensageService;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Get the token array structure.
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user = null, $status = true)
    {
        $groupInfoTokenToken = [
            'expiresInTime' => DateUtil::addMinutesToDate(env('JWT_TTL', 60)),
            'expiresIn'     => env('JWT_TTL', 60),
            'tokenType'     => 'bearer',
            'accessToken'   => $token
        ];

        return response()->json(['status' => $status, 'accessToken' => $token, 'token' =>  $groupInfoTokenToken, 'user' => $user]);
    }

    public function login(AuthLoginRequest $request)
    {
        $item = (object) $request->validated();

        $credentials = ["email" => $item->email, "password" => $item->password];
        try {
            $token = auth('api')->attempt($credentials);
            if (!$token) {
                return response()->json(['message' => 'Credenciais inválidas'], 400);
            }

            $user = auth('api')->user();

            return $this->respondWithToken($token, $user);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Unauthorized', 'error' => $e], 500);
        }
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Logout foi realizado com sucesso']);
    }

    public function refresh()
    {
        $token = auth()->refresh();

        if (!$token) {
            return MensageService::error("Unauthorized",401);
        }

        $user = (object) auth('api')->user();
        //$user->menu = MenuService::createMenuUser($user->id);

        return $this->respondWithToken($token, $user);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}
