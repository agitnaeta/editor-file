<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DocumentController;

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
    return redirect()->route('document.index');
});

Route::group(['prefix'=>'document'],function()
{
    Route::get('index', [DocumentController::class,'index'])->name('document.index');
    Route::get('create', [DocumentController::class,'create'])->name('document.create');
    Route::get('create-multiple', [DocumentController::class,'createMultiple'])->name('document.createMultiple');
    Route::post('store', [DocumentController::class,'store'])->name('document.store');
    Route::post('store-multiple', [DocumentController::class,'storeMultiple'])->name('document.storeMultiple');
    Route::get('show/{id}', [DocumentController::class,'show'])->name('document.show');
    Route::get('get/{id}', [DocumentController::class,'get'])->name('document.get');
    Route::get('edit/{id}', [DocumentController::class,'edit'])->name('document.edit');
    Route::post('update/{id}', [DocumentController::class,'update'])->name('document.update');
    Route::get('destroy/{id}', [DocumentController::class,'destroy'])->name('document.destroy');
});

Route::post('upload', [UploadController::class,'upload'])->name('upload');
