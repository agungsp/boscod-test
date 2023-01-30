<?php

namespace App\Http\Middleware;

use App\Http\Resources\ApiResource;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class IlegalUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->route('user');
        if (!$user instanceof User) {
            $user = User::find($user);
            if (!$user) {
                return response(new ApiResource(
                    resource: [],
                    success: false,
                    message: "Not Found!"
                ), Response::HTTP_NOT_FOUND);
            }
        }

        if ($user->id != Auth::id()) {
            return response(
                new ApiResource(resource: [], success: false, message: "Forbidden!"),
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }
}
