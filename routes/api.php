<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DayController;
use App\Http\Controllers\Api\FieldController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource("categories", CategoryController::class)->middleware('auth:sanctum');
Route::apiResource("rooms", RoomController::class)->middleware('auth:sanctum');
Route::apiResource("fields", FieldController::class)->middleware('auth:sanctum');
Route::get("/fields/{field:slug}", [FieldController::class, "show"])->middleware("auth:sanctum"); // Berikut Cara Binding dengan Bawaan Laravel
// Route::get("rooms/{slug}/fields", [RoomController::class, "findRoom"])->middleware('auth:sanctum');
Route::get("/field/search/{field:name}", [FieldController::class, "searchField"])->middleware("auth:sanctum");

Route::apiResource("carts", CartController::class)->middleware('auth:sanctum');
Route::apiResource("orders", OrderController::class);//->middleware("auth:sanctum");

Route::apiResource("schedules", ScheduleController::class)->middleware('auth:sanctum');
Route::apiResource("days", DayController::class)->middleware('auth:sanctum');

Route::post("/auth/login", [LoginController::class, "authenticated"]);
Route::post("/auth/register", [RegisterController::class, "store"]);

Route::get('/client-key', function () {
    return response()->json([
        'CLIENT_KEY' => env('CLIENT_KEY')
    ]);
})->middleware('auth:sanctum');

Route::post("/checkout", [TransactionController::class, "checkout"])->middleware("auth:sanctum");
Route::apiResource("galleries", GalleryController::class);

Route::post("/midtrans/notification", [MidtransController::class, 'handleNotification']);