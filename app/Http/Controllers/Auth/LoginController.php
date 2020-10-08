<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Auth\AuthenticatesUsers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function guard($name = '')
    {
        return Auth::guard($name);
    }

    public function username()
    {
        return 'username';
    }

    public function showAdminLoginForm()
    {
        $admin_login = route('admin.login');
        return Inertia::render('Auth/Login', compact('admin_login'));
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $input = $request->all();
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $data = array($fieldType => $input['username'], 'password' => $input['password']);
        $remember = !empty($input['remember']) ? true : false;
        // dd($data);
        if ($this->guard()->attempt($data, $remember)) {
            Auth::logoutOtherDevices($input['password']);
            return redirect()->route('login');
            // return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
        // return back()->withInput($request->only('username', 'remember'))->with('error','Email-Address And Password Are Wrong.');

    }

    public function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->route('login');
    }
}