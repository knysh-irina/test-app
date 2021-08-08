<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class EnsureUserHasRole
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string  $role
     *
     * @return mixed
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        /** @var User|null $user */
        $user = $request->user();

        if ($user === null || ! $user->isRole($role)) {
            return response('Forbidden', Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }

}
