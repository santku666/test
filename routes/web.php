<?php

use App\Http\Controllers\Category;
use App\Http\Controllers\Home;
use App\Http\Controllers\Material;
use App\Http\Controllers\QuantityManager;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[Home::class,'index']);
Route::resource('categories',Category::class);
Route::resource('materials',Material::class);
Route::prefix('qty-manager')->controller(QuantityManager::class)->group(function(){
    Route::get('/','index');
    Route::get('/create','create');
    Route::post('/','store');
});
