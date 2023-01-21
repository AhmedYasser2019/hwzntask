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
    public function index(IUser $user)
    {
        $users = $user->findAll(['*'], true, 'name', 'DESC');
        return view('home', compact('users'));
    }
}
