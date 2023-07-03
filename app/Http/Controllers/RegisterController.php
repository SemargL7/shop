<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Display register page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle account registration request
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $userRole = new UserRole();
        $user = $user->create($request->validated());
        $userRole->user_id = $user->id;
        $userRole->role_id = 1; //User
        $userRole->save();

        auth()->login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    }
}
