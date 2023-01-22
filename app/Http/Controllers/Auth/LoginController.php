<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\Contracts\IUser;
use App\Services\UserService;
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
    private UserService $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IUser $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
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

        if ($this->userService->checkIfUserBlocked($user)) {
            return redirect()->back()->withInput()->with('error', 'your email is blocked !');
        }

        $this->userService->allowedTimeForEmail($request->email);

        if ($this->userService->blockUserAfterExceededMaximumTries($request->email)) {
            $this->userService->blockUser($user);
            return redirect()->back()->withInput()->with('error', 'your email is blocked !');

        }
        if ($this->userService->alertUserAfterExceededMaximumTries($request->email)) {
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
