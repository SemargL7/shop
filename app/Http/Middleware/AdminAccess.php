<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    private function accessType($user_id){
        $userRole = UserRole::where("user_id", $user_id)->first();
        if ($userRole) {
            $role = Role::where("id", $userRole->role_id)->first();
            if ($role) {
                return $role->role;
            }
        }
        return null; // or you can return a default value or handle the case when the role is not found
    }

    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() != null && $this->accessType(Auth::user()->id) == 'Admin'){
            return $next($request);
        }
        return redirect()->route('home');
    }
}
