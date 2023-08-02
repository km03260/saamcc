<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        session()->put('pr_url', str_replace('/login?prev_url=', '', str_replace(url('/'), '', URL::previous())));
        return view('auth.login')->with(['pr_url' => URL::previous()]);
    }

    public function logout(Request $request)
    {

        if (Auth::check()) {

            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();

            return redirect('/ssoerver/outSession?outSession=false');
        }
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function authUser()
    {
        return redirect()->to($_REQUEST['to']);
    }

    public function outAuth()
    {
        $broker = new MyBroker();
        $broker->logout();
    }
}
