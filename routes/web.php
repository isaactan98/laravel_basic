<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Models\User;
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
    return view('home');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

//Category
Route::get('/category/all', [CategoryController::class, 'allcat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'addcat'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
Route::post('/category/update/{id}', [CategoryController::class, 'update']);
Route::get('/softdel/category/{id}', [CategoryController::class, 'softdelete']);
Route::get('/category/restore/{id}', [CategoryController::class, 'restoredel']);
Route::get('/category/delete/{id}', [CategoryController::class, 'delete']);

//Brand
Route::get('/brand/all', [BrandController::class, 'index'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'addbrand'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'edit']);
Route::post('/brand/update/{id}', [BrandController::class, 'update']);
Route::get('/brand/delete/{id}', [BrandController::class, 'delete']);

//Multiple IMG 
Route::get('/multi/img', [BrandController::class, 'multiIMG'])->name('multi.img');
Route::post('/multi/add', [BrandController::class, 'multiADD'])->name('store.multiIMG');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::all();
    // return view('dashboard', compact('users'));
    return view('admin.index');
})->name('dashboard');

Route::get('/user/logout', [BrandController::class, 'logout'])->name('user.logout');
