<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * TODO: phpdoc
 *
 * Class JwtAuthController
 * @package Agilo\Http\Controllers
 */
class JwtAuthController extends Controller
{
    const ATHLETE_LOCKED = 10;
    const TENANT_LOCKED = 11;

    public function login(Request $request, Response $response, Auth $auth)
    {
        $credentials = $request->only('email', 'password');
        $token = $auth->guard('jwt')->attempt($credentials);

        if (!$token) {
            return $response->json([], HttpResponse::HTTP_UNAUTHORIZED);
        }

        /** @var Athlete $athlete */
        $athlete = $auth->guard('jwt')->user();

        if (!$athlete->active) {
            $auth->guard('jwt')->logout();
            return $response->json(['code' => static::ATHLETE_LOCKED], HttpResponse::HTTP_UNAUTHORIZED);
        }

        if (!$athlete->office->active) {
            $auth->guard('jwt')->logout();
            return $response->json(['code' => static::TENANT_LOCKED], HttpResponse::HTTP_UNAUTHORIZED);
        }

        return $response->json(compact('token'));
    }

    public function logout(Request $request, Response $response, Auth $auth)
    {
        try {
            $auth->guard('jwt')->logout();
        } catch(JWTException $e) {
            return $response->json([], HttpResponse::HTTP_BAD_REQUEST);
        }

        return $response->json([], HttpResponse::HTTP_NO_CONTENT);
    }
}