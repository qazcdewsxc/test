<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\test1ApiCont;

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

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logoutA', [test1ApiCont::class, 'logoutA']);
    Route::get('/table/{element}', [test1ApiCont::class, 'table']);
    Route::post('/table', [test1ApiCont::class, 'storeElem']);
    Route::delete('/table/{element}', [test1ApiCont::class, 'destroyElem']);
    Route::put('/table/{element}', [test1ApiCont::class, 'updateElem']);
    Route::get('/tableAll', [test1ApiCont::class, 'allElem']);
});
Route::post('/log', [test1ApiCont::class, 'logA']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
