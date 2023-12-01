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
        if ($request->user() && $this->getRequestUserRoleName($request) == $role) {
            return $next($request);
        }

        $isAdminLink = Str::contains($request->getRequestUri(), 'admin/');

        // if user is customer and want to see admin redirect to home page (/)
        if($isAdminLink &&  $this->getRequestUserRoleName($request)=='customer'){
            return redirect('/');
        }

        // if user is admin and want to see customer links redirect to /admin/post
        if((!$isAdminLink) &&  $this->getRequestUserRoleName($request)=='admin'){
            return redirect('/admin/dashboard');
        }

        // if l ink is admin  and if user does not logged in redirect to home page
        if($isAdminLink && $this->getRequestUserRoleName($request)==''){
            return redirect('/');
        }

        return $next($request);
    }



    private function getRequestUserRoleName($request):string{
        try {
            return $request->user()->role->name;
        } catch (\Throwable $th) {
            //throw $th;
            return '';
        }
    }
}
