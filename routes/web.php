<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrController;
use App\Http\Controllers\Web\CardTransfersController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ExpensesController;
use App\Http\Controllers\Web\IncomeController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\TransitionController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::post('/signup', [RegistrController::class, 'signup'])->name('signup.post');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/data', [DashboardController::class, 'data'])->name('data');
    Route::get('/profile-edit/{id}', [LoginController::class, 'show'])->name('profile.show');
    Route::post('/profile-update', [LoginController::class, 'update'])->name('profile.update');

    Route::group(['prefix' => 'expenses'], function () {
        Route::get('/', [ExpensesController::class, 'index'])->name('expenses.index');
        Route::get('/data', [ExpensesController::class, 'data'])->name('expenses.data');
        Route::post('/all-delete', [ExpensesController::class, 'all_delete'])->name('expenses.all.delete');
        Route::post('/add', [ExpensesController::class, 'add'])->name('expenses.insert');
        Route::get('/show/{id}', [ExpensesController::class, 'show'])->name('expenses.show');
        Route::post('/update', [ExpensesController::class, 'update'])->name('expenses.update');
        Route::post('/delete', [ExpensesController::class, 'delete'])->name('expenses.delete');
    });

    Route::group(['prefix' => 'transitions'], function () {
        Route::get('/', [TransitionController::class, 'index'])->name('transitions.index');
        Route::get('/data', [TransitionController::class, 'data'])->name('transitions.data');
        Route::post('/all-delete', [TransitionController::class, 'all_delete'])->name('transitions.all.delete');
        Route::post('/add', [TransitionController::class, 'add'])->name('transitions.insert');
        Route::get('/show/{id}', [TransitionController::class, 'show'])->name('transitions.show');
        Route::post('/update', [TransitionController::class, 'update'])->name('transitions.update');
        Route::post('/delete', [TransitionController::class, 'delete'])->name('transitions.delete');
    });

    Route::group(['prefix' => 'card_transfers'], function () {
        Route::get('/', [CardTransfersController::class, 'index'])->name('transfers.index');
        Route::get('/data', [CardTransfersController::class, 'data'])->name('transfers.data');
        Route::post('/all-delete', [CardTransfersController::class, 'all_delete'])->name('transfers.all.delete');
        Route::post('/add', [CardTransfersController::class, 'add'])->name('transfers.insert');
        Route::get('/show/{id}', [CardTransfersController::class, 'show'])->name('transfers.show');
        Route::post('/update', [CardTransfersController::class, 'update'])->name('transfers.update');
        Route::post('/delete', [CardTransfersController::class, 'delete'])->name('transfers.delete');
    });

    Route::group(['prefix' => 'payments'], function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/data', [PaymentController::class, 'data'])->name('payments.data');
        Route::post('/all-delete', [PaymentController::class, 'all_delete'])->name('payments.all.delete');
        Route::post('/add', [PaymentController::class, 'add'])->name('payments.insert');
        Route::get('/show/{id}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/update', [PaymentController::class, 'update'])->name('payments.update');
        Route::post('/delete', [PaymentController::class, 'delete'])->name('payments.delete');
    });

    Route::group(['prefix' => 'incomes'], function () {
        Route::get('/', [IncomeController::class, 'index'])->name('incomes.index');
        Route::get('/data', [IncomeController::class, 'data'])->name('incomes.data');
        Route::post('/all-delete', [IncomeController::class, 'all_delete'])->name('incomes.all.delete');
        Route::post('/add', [IncomeController::class, 'add'])->name('incomes.insert');
        Route::get('/show/{id}', [IncomeController::class, 'show'])->name('incomes.show');
        Route::post('/update', [IncomeController::class, 'update'])->name('incomes.update');
        Route::post('/delete', [IncomeController::class, 'delete'])->name('incomes.delete');
    });
});
