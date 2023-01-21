<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

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


    private IUser $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IUser $user)
    {
        $this->user = $user;
        $this->middleware('guest')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|min:4|max:30|exists:users',
            'password' => 'required|min:4|max:30'
        ]);
        $user = $this->user->findBy('email', $request->email);
        if ($user->blocked) {
            RateLimiter::cleanRateLimiterKey($request->email);
            return redirect()->back()->withInput()->with('error', 'your email is blocked !');
        }
        RateLimiter::hit($request->email, 30);

        if (RateLimiter::attempts($request->email) == 4) {
            $user->update([
                'blocked' => true,
                'login_tries_number' => 0

            ]);

            return redirect()->back()->withInput()->with('error', 'your email is blocked !');

        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,])) {
            $user->update([
                'login_tries_number' => 0
            ]);
            return redirect()->route('home');
        } else {


            $user->update([
                'login_tries_number' => (integer)$user->login_tries_number + 1
            ]);
            if ($user->login_tries_number == 3) {
                return redirect()->back()->withInput()->with('error', 'try again after 30 second');

            }
            return redirect()->back()->withInput()->with('error', 'wrong credential');
        }


    }

    public function logout()
    {
        Auth::guard()->logout();
        return redirect()->route('login');
    }

}
