<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FamilyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanPaymentController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\PointTransferController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;




//-----------------------------------------[ auth  ]-----------------------------------------------
Route::get('/', [AuthController::class, 'home'])->name('home');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//-----------------------------------------[ forget password  ]-----------------------------------------------

Route::get('/forget', [AuthController::class, 'forget'])->name('forget');
Route::post('/forget', [AuthController::class, 'forgetpost'])->name('forgetpost');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name('resetPassword.post');

Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::get('/test', [UserController::class, 'test'])->name('test');


//-----------------------------------------[  ADMIN  ]-----------------------------------------------

Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'is_admin']
], function () {
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::resource('users', UserController::class);
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');



});
Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
Route::get('/investments/create/{user}', [InvestmentController::class, 'create'])->name('investments.create');
Route::post('/investments', [InvestmentController::class, 'store'])->name('investments.store');

Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');

Route::get('/points', [PointController::class, 'index'])->name('points.index');
Route::get('/points/{id}/edit', [PointController::class, 'edit'])->name('points.edit');
Route::put('/points/{id}', [PointController::class, 'update'])->name('points.update');

Route::get('/loan-payments', [LoanPaymentController::class, 'index'])->name('loan-payments.index');
Route::get('/loan-payments/create', [LoanPaymentController::class, 'create'])->name('loan-payments.create');
Route::post('/loan-payments', [LoanPaymentController::class, 'store'])->name('loan-payments.store');

Route::get('/point-transfers', [PointTransferController::class, 'index'])->name('point-transfers.index');


Route::post('/loan-payments/{payment}/pay', [LoanPaymentController::class, 'pay'])->name('loan-payments.pay');


Route::post('family/create',[FamilyController::class,'store'])->name('family.store');

Route::get('/point-transfers/create', [PointTransferController::class, 'create'])->name('point-transfers.create');
Route::post('/point-transfers', [PointTransferController::class, 'store'])->name('point-transfers.store');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/user/{user_id}', [TransactionController::class, 'userTransactions'])->name('transactions.user');
