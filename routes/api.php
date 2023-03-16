<?php

use App\Http\Controllers\Material;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('test')->group(function(){

// });

Route::prefix('materials')->controller(Material::class)->group(function(){
    Route::get('/{category_id}/all','materials_by_category');
});

