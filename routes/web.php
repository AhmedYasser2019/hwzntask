<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

class Order
{
    public int $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}



Route::get('/update', function () {
    \App\Events\OrderStatusUpdatedEvent::dispatch(new Order(1));

});

//Auth::routes();

Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

//Route::group(['middleware' => 'throttle:3,.5'], function () {
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
//});
Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {

        return view('welcome');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
