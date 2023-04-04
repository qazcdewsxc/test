<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\test1ApiCont;

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

Route::middleware('auth:sanctum')->get('/object', [test1ApiCont::class, 'index']);
Route::middleware('auth:sanctum')->get('/object/{id}', [test1ApiCont::class, 'show']);
Route::middleware('auth:sanctum')->post('/object', [test1ApiCont::class, 'store']);
Route::middleware('auth:sanctum')->delete('/object/{id}', [test1ApiCont::class, 'destroy']);
Route::middleware('auth:sanctum')->put('/object/{id}', [test1ApiCont::class, 'update']);
Route::post('/log', [test1ApiCont::class, 'logA']);
Route::middleware('auth:sanctum')->post('/logoutA', [test1ApiCont::class, 'logoutA']);
Route::middleware('auth:sanctum')->get('/table/{element}', [test1ApiCont::class, 'table']);
Route::middleware('auth:sanctum')->post('/table', [test1ApiCont::class, 'storeElem']);
Route::middleware('auth:sanctum')->delete('/table/{element}', [test1ApiCont::class, 'destroyElem']);
Route::middleware('auth:sanctum')->put('/table/{element}', [test1ApiCont::class, 'updateElem']);
Route::middleware('auth:sanctum')->get('/tableAll', [test1ApiCont::class, 'allElem']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
