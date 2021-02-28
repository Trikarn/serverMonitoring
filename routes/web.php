<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SupportCommentController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TelegramController;
use App\Models\TechSupportComments;
use App\Models\Telegram;
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


Auth::routes();

//SERVERS
Route::get('/servers',  [ServersController::class, 'index']);
Route::get('/favorite',  [ServersController::class, 'index']);
Route::get('/servers/{id}/edit',  [ServersController::class, 'edit']);
Route::get('/servers/create',  [ServersController::class, 'create']);
Route::get('/ajax/servers',  [ServersController::class, 'servers']);

Route::post('/servers',  [ServersController::class, 'store']);

Route::delete('/servers/{id}/destroy',  [ServersController::class, 'destroy']);

Route::put('/servers/{id}',  [ServersController::class, 'update']);
Route::put('/servers/{id}/favorite',  [ServersController::class, 'favorite']);

//TELEGRAM
Route::get('/telegram',  [TelegramController::class, 'index']);
Route::get('/telegram/create',  [TelegramController::class, 'create']);
Route::get('/telegram/{id}/edit',  [TelegramController::class, 'edit']);
Route::get('/ajax/telegram',  [TelegramController::class, 'telegrams']);

Route::post('/telegram',  [TelegramController::class, 'store']);

Route::put('/telegram/{id}', [TelegramController::class, 'update']);

Route::delete('/telegram/{id}/destroy',  [TelegramController::class, 'destroy']);

//SUPPORTS
Route::get('/supports',  [SupportController::class, 'index']);
Route::get('/supports/{id}/show',  [SupportController::class, 'show']);

Route::get('/ajax/supports',  [SupportController::class, 'supports']);

Route::post('/supports',  [SupportController::class, 'store']);
Route::post('/ajax/supports/{id}/change-status', [SupportController::class, 'changeStatus']);


//COMMENTS
Route::post('/supports/{id}',  [SupportCommentController::class, 'store']);

Route::get('/ajax/supports/{id}/comments',  [SupportCommentController::class, 'comments']);

//SETTINGS

Route::get('/settings',  [SettingsController::class, 'index']);





