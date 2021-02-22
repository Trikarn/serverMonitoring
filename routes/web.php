<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServersController;
use App\Http\Controllers\TelegramController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/support', function () {
    return view('support.supports');
});

Route::get('/servers',  [ServersController::class, 'index']);
Route::get('/favorite',  [ServersController::class, 'index']);
Route::get('/servers/{id}/edit',  [ServersController::class, 'edit']);
Route::get('/servers/create',  [ServersController::class, 'create']);
Route::post('/servers',  [ServersController::class, 'store']);
Route::delete('/servers/{id}/destroy',  [ServersController::class, 'destroy']);
Route::put('/servers/{id}',  [ServersController::class, 'update']);
Route::put('/servers/{id}/favorite',  [ServersController::class, 'favorite']);

Route::get('/ajax/servers',  [ServersController::class, 'servers']);

Route::get('/telegram',  [TelegramController::class, 'index']);
Route::get('/telegram/create',  [TelegramController::class, 'create']);
Route::post('/telegram',  [TelegramController::class, 'store']);

Route::get('/ajax/telegram',  [TelegramController::class, 'telegrams']);


