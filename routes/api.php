<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\TicketCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/login', [AuthController::class, "login"]);
Route::post('/auth/register', [AuthController::class, "register"]);

Route::get('/category', [CategoryController::class, "index"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/cms/category', CategoryController::class)->except([
        'create', 'edit'
    ]);

    Route::resource('/cms/event', EventController::class)->except([
        'create', 'edit'
    ]);

    Route::resource('/cms/organizer', OrganizerController::class)->except([
        'create', 'edit'
    ]);

    Route::resource('/cms/ticket', TicketCategoryController::class)->except([
        'create', 'edit'
    ]);
    
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
