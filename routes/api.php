<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'post_login']);
Route::post('/register', [AuthController::class, 'post_register']);

Route::get('/login', function (){ return abort(404);});
Route::get('/register', function (){ return abort(404);});

Route::group(['middleware' => ['api_auth']], function () {
    Route::get('/get-permissions', [RoleController::class, 'get_permissions']);
    Route::post('logout', [AuthController::class, 'post_logout']);
});
