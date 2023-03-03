<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

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

Route::group(['middleware'=> ['location']], function() {

    Route::get('a', function (){
        return response()->json([
            'message' => 'ok'
        ], 404);
    });
    Route::group(['middleware'=> ['email.verified']], function() {

    });
});

Route::group(['prefix' => 'auth'], function (){
    route::post('signup', [AuthController::class, 'signUp']);
    route::post('login', [AuthController::class, 'login']);
    route::post('forgot-password', [AuthController::class, 'sendCodeResetPass']);
    route::post('resend-code', [AuthController::class, 'sendCodeResetPass']);
    route::post('verify-code', [AuthController::class, 'verifyCode']);
    route::post('reset-password', [AuthController::class, 'resetPassword']);
});

Route::group(['middleware' => ['auth:api, email.verified']], function (){
    route::get('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'category'], function (){
        route::post('create', [CategoryController::class, 'create']);
        route::get('getAll', [CategoryController::class, 'getCategoryList']);
        route::put('update/{id}', [CategoryController::class, 'updateCategory']);
        route::delete('delete/{id}', [CategoryController::class, 'deleteCategory']);
    });
    Route::group(['prefix' => 'product'], function () {
        route::post('create', [ProductController::class, 'createProduct']);
        route::get('getAll', [ProductController::class, 'getAll']);
        route::get('get/{id}', [ProductController::class, 'getDetail']);
        route::put('update/{id}', [ProductController::class, 'updateProduct']);
        route::delete('delete/{id}', [ProductController::class, 'delete']);
    });
});


