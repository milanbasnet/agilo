<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Auth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RefreshToken extends BaseMiddleware
{
   
    /**
     * The JWT Authenticator.
     *
     * @var \Tymon\JWTAuth\JWTGuard
     */
    protected $guard;

    /**
     * Create a new BaseMiddleware instance.
     *
     * @param  \Tymon\JWTAuth\JWTAuth  $auth
     *
     * @return void
     */
    public function __construct(JWTAuth $auth)
    {
        parent::__construct($auth);
        $this->guard = Auth::guard('jwt');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next) {
        try {
            $this->checkForToken($request);
        } catch (UnauthorizedHttpException $e) {
            Log::debug('no token passed with request. aborting');
            return response()->json([], HttpResponse::HTTP_UNAUTHORIZED);
        }

        try {
            try {
                $sub = $this->guard->getPayload()->get('sub');

                if (!$this->guard->byId($sub)) {
                    Log::debug('user corresponding to the token not found. aborting');
                    return response()->json([], HttpResponse::HTTP_UNAUTHORIZED);
                }

                return $next($request);
            } catch (TokenExpiredException $e) {
                $payload = $this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray();
                $key = 'block_refresh_token_for_user_' . $payload['sub'];
                $cachedBefore = (int) Cache::has($key);

                // Check if a token already was refreshed in the last JWT_BLACKLIST_GRACE_PERIOD seconds
                // If so, do login and continue
                if ($cachedBefore) {
                    \Auth::onceUsingId($payload['sub']);
                    return $next($request);
                }

                // Refresh token and store token in cache
                $refreshedToken = $this->guard->refresh();
                $gracePeriod = $this->auth->manager()->getBlacklist()->getGracePeriod();
                $expiresAt = Carbon::now()->addSeconds($gracePeriod);
                Cache::put($key, $refreshedToken, $expiresAt);
            }
        } catch (JWTException $e) {
            Log::debug("jwt exception ". $e->getMessage() . " " .$e->getTraceAsString());
            return response()->json([], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $response = $next($request);

        return $this->setAuthenticationHeader($response, $refreshedToken);
    }
}
