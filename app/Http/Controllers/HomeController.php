<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(IUser $userRepository)
    {
        $users = $userRepository->findAll(['name', 'last_name', 'email'], true, ['name', 'last_name'], 'ASC');
        return view('home', compact('users'));
    }
}
