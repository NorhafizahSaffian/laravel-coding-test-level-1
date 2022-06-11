<?php
use App\Http\Controllers\Api\EventController;


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

//Event
Route::controller(EventController::class)->group(function(){

    Route::get('api/v1/events', 'index')->name('events.index');

    Route::get('api/v1/events/active-events', 'activeEvent')->name('events.active');

    Route::get('api/v1/events/{id}', 'show')->name('events.show');

    Route::post('api/v1/events', 'store')->name('events.store');

    Route::put('api/v1/events/{id}', 'update')->name('events.update');

    Route::patch('api/v1/events/{id}', 'update')->name('events.patch');

    Route::delete('api/v1/events/{id}', 'delete')->name('events.delete');
});
