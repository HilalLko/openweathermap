<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WeatherController;

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

Route::post('login', [AuthController::class, 'loginWithEmail']);
Route::post('register', [AuthController::class, 'createUser']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('city/add', [WeatherController::class, 'addNewCity'])->name('api.city.add');
});

Route::get('cities', [WeatherController::class, 'getAllAvailableCities'])->name('api.city.list');
Route::get('city/weather/current/{city}', [WeatherController::class, 'getCurrentWeatherByCity'])->name('api.city.current-weather');
Route::get('city/weather/history/{city}', [WeatherController::class, 'getPreviousWeatherByCity'])->name('api.city.current-weather');
Route::get('city/weather/future/{city}', [WeatherController::class, 'getFutureWeatherByCity'])->name('api.city.current-weather');
