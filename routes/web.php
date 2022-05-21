<?php

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
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/', [\App\Http\Controllers\RepoController::class, 'index'])->name('repo.index');
Route::get('/{owner}', [\App\Http\Controllers\RepoController::class, 'owner'])->name('repo.owner');
Route::get('/{owner}/{name}', [\App\Http\Controllers\ReleaseController::class, 'index'])->name('release.index');
