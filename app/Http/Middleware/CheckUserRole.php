<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $role): Response
    {
        if ($request->user() && $request->user()->role->name == $role) {
            return $next($request);
        }

        $isAdminLink = Str::contains($request->getRequestUri(), 'admin/');
        // if user is customer and want to see admin redirect to home page (/)
        if($isAdminLink && $request->user()->role->name=='customer'){
            return redirect('/');
        }

        // if user is admin and want to see customer links redirect to /admin/post
        if(!$isAdminLink && $request->user()->role->name=='admin'){
            return redirect('/admin/dashboard');
        }

        // if user does not logged in redirect to home page
        return redirect('/'); // Redirect to home if the user doesn't have the required role.

        // return $next($request);
    }
}
