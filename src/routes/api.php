<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('', function () {
    return response()->json(['message' => 'Fullstack Challenge 20201026'], Response::HTTP_OK);
});

Route::group(['prefix' => 'products'], function () {
   Route::get('{code}', [ProductController::class, 'show']);
   Route::get('', [ProductController::class, 'index']);

});
