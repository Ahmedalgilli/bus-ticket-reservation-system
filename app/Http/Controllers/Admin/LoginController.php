<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Validation\ValidationException;
use App\Admin;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    public function login(Request $request){
        $this->attemptLogin([ 'email' => $request->emai, 'password' => $request->password ]);
        // if($this->guard()->user()){
        //     return redirect()->route('admin.home');
        // } else {
        //     return redirect()->route('admin.login');            
        // }
    }

    protected function validateLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->route('administrator-dashboard')->with('toast_success', 'Logged in');
    }

    public function showLoginForm()
    {
        return Inertia::render('Admin/Login');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/')->with('toast_success', 'Logged out');

    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

}
