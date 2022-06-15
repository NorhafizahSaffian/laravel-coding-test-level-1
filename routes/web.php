<?php
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\API\PassportAuthController;
use App\Http\Controllers\API\ProductController;


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

// Route::post('register', [PassportAuthController::class, 'register']);
// Route::post('login', [PassportAuthController::class, 'login']);
  
// Route::middleware('auth:api')->group(function () {
//     Route::get('get-user', [PassportAuthController::class, 'userInfo']);
 
//  Route::resource('products', [ProductController::class]);
 
// });


Route::namespace('Auth')->group(function () {
  Route::get('/login','LoginController@show_login_form')->name('login');
  Route::post('/login','LoginController@process_login')->name('login');
  Route::get('/register','LoginController@show_signup_form')->name('register');
  Route::post('/register','LoginController@process_signup');
  Route::post('/logout','LoginController@logout')->name('logout');
});


Route::get('/', function () {
    return view('event/view');
});

Route::get('/events/create', function () {
    return view('event/create');
})->name('event.create.page');

Route::get('/events', function () {
    return View::make("event/view");
})->name('event.view');;

//Event
Route::controller(EventController::class)->group(function(){

    Route::get('api/v1/events', 'index')->name('events.index');

    Route::get('api/v1/events/active-events', 'activeEvent')->name('events.active');

    Route::get('api/v1/events/{id}', 'show')->name('events.show');

    Route::post('api/v1/events', 'store')->name('events.store');

    Route::put('api/v1/events/{id}', 'update')->name('events.update');

    Route::patch('api/v1/events/{id}', 'update')->name('events.patch');

    Route::delete('api/v1/events/{id}', 'delete')->name('events.delete');

    Route::get('events/{id}/edit', 'editDisplay')->name('events.edit.display');

    Route::get('events/{id}', 'showDetail')->name('events.show.display');    
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
