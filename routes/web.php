<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MatchPercentage;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('match-percentage')->group(function() {
    Route::name('match-percentage.')->group(function() {
        Route::get('/', [MatchPercentage::class, 'index'])->name('index');
        Route::post('/calculate', [MatchPercentage::class, 'calculate'])->name('calculate');
    });
});

Route::prefix('expenses')->group(function() {
    Route::name('expenses.')->group(function() {
        Route::prefix('categories')->group(function() {
            Route::name('categories.')->group(function() {
                Route::get('/', [ExpenseController::class, 'categoriesIndex'])->name('index');
                Route::post('/', [ExpenseController::class, 'categoriesStore'])->name('store');
                Route::get('/{id}', [ExpenseController::class, 'categoriesDetail'])->name('detail');
                Route::post('/update', [ExpenseController::class, 'categoriesUpdate'])->name('update');
                Route::get('/{id}/delete', [ExpenseController::class, 'categoriesDelete'])->name('delete');
            });
        });
        Route::get('/', [ExpenseController::class, 'index'])->name('index');
        Route::post('/', [ExpenseController::class, 'store'])->name('store');
        Route::get('/{id}', [ExpenseController::class, 'detail'])->name('detail');
        Route::post('/update', [ExpenseController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [ExpenseController::class, 'delete'])->name('delete');
    });
});

