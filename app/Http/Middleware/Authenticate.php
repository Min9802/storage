<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Request as RequestFacade;
use Laravel\Passport\Token;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (!$request->expectsJson()) {
    //         return '/login';
    //     }
    // }
    public function handle($request, Closure $next, ...$guards)
    {
        if ($request->bearerToken()) {
            $bearerToken = $request !== null ? $request->bearerToken() : RequestFacade::bearerToken();
            $parser = new Parser(new JoseEncoder());
            $JwtParser = $parser->parse($bearerToken);
            $tokenID = $JwtParser->claims()->get('jti');
            $user = Token::find($tokenID)->user;
            $this->authenticate($user, $guards);
            return $next($request);
        } else {
            abort(401, "Unauthenticated");
        }
    }
}
