<?php

use App\Http\Controllers\Admin\PoliticianController;
use App\Http\Controllers\Client\PostController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::group(['middleware' => ['auth:sanctum', 'verified']],function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('/politician', PoliticianController::class);
    });
});
Route::group(['prefix' => '/politici'], function () {
    Route::get('/', [PostController::class, 'showAll'])->name('indexAll');
    Route::get('/{politician}', [PostController::class, 'showAllFrom'])->name('indexOne');
    Route::get('/{politician}/{post}/{plus}', [PostController::class, 'showOneFrom'])->name('oneHelper');
    Route::get('/{politician}/{post}', [PostController::class, 'show'])->name('showPost');
});

Route::get('/', function () {
//    return view('dashboard');
    return redirect()->route('indexAll');
})->name('dashboard');
//
//Route::get('/politicians', function () {
//    return view('politicians');
//})->name('politicians');

//Route::get('/politician', function () {
//    return view('politician');
//})->name('politician');
