<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form via Inertia.
     */
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    public function redirectTo(): string
    {
        $role = Auth::user()->role;
        return ($role === 'master') ? '/masters' : '/home';
    }

    public function username(): string
    {
        $login = request()->input('email');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
        request()->merge([$field => $login]);
        return $field;
    }

    public function credentials(Request $request): array
    {
        return array_merge(
            $request->only($this->username(), 'password'),
            ['active' => '1'],
        );
    }
}
