<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('index');
    Route::post('/addcart', [HomeController::class, 'addcart'])->name('addcart');
    Route::get('/clearcart', [HomeController::class, 'clearCart'])->name('clearCart');
    Route::post('/checkout', [HomeController::class, 'checkout'])->name('checkout');
});



