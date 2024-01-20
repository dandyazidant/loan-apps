<?php

use App\Http\Controllers\CustomerControllers;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/', [CustomerControllers::class, 'index'])->name('index');
        Route::get('/create', [CustomerControllers::class, 'create'])->name('create');
        Route::get('/{id}/edit', [CustomerControllers::class, 'edit'])->name('edit');
        Route::delete('/{id}/delete', [CustomerControllers::class, 'delete'])->name('delete');
    });

    Route::resource('loan', LoanController::class);
    Route::patch('loan-approval/{id}', [LoanController::class,'approval'])->name('loan.approval');
});

require __DIR__.'/auth.php';
