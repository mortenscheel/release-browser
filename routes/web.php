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

Route::get('/', [\App\Http\Controllers\RepoController::class, 'index'])->name('repo.index');
Route::get('/{owner}', [\App\Http\Controllers\RepoController::class, 'owner'])->name('repo.owner');
Route::get('/{owner}/{repository}', [\App\Http\Controllers\ReleaseController::class, 'index'])->name('release.index');
