<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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


    private IUser $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IUser $userRepository)
    {
        $this->userRepository = $userRepository;
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

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->findBy('email', $request->email);

        if ($user->blocked) {

            return redirect()->back()->withInput()->with('error', 'your email is blocked !');
        }

        RateLimiter::hit($request->email, 30);

        if (RateLimiter::attempts($request->email) == 4) {

            $user->update([
                'blocked' => true,
            ]);

            return redirect()->back()->withInput()->with('error', 'your email is blocked !');

        }
        if (RateLimiter::attempts($request->email) == 3) {

            return redirect()->back()->withInput()->with('error', 'try again after 30 second');

        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,])) {

            return redirect()->route('home');
        } else {

            return redirect()->back()->withInput()->with('error', 'wrong credential');
        }


    }

    public function logout()
    {
        Auth::guard()->logout();
        return redirect()->route('login');
    }

}
