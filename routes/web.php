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
use App\Http\Controllers\AdminMonthlyReportController;
use App\Models\User;

Route::get('/', [AuthController::class, 'home'])->name('home');

//-----------------------------------------[ auth  ]-----------------------------------------------

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

//-----------------------------------------[  ADMIN  ]-----------------------------------------------

Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'is_admin']
], function () {

//---------------/ ADMIN /--------------------------[  users  ]-----------------------------------------------

    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::resource('users', UserController::class);
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

//---------------/ ADMIN /--------------------------[  month  ]-----------------------------------------------

    Route::get('/months', [AdminMonthlyReportController::class, 'index'])->name('months.index');
    Route::get('/months/{month}', [AdminMonthlyReportController::class, 'show'])->name('months.show');

//---------------/ ADMIN /--------------------------[  inestments  ]-----------------------------------------------

    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');

//---------------/ ADMIN /--------------------------[  loans  ]-----------------------------------------------

    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');

//---------------/ ADMIN /--------------------------[  points  ]-----------------------------------------------

    Route::get('/points', [PointController::class, 'index'])->name('points.index');
    Route::get('/points/{id}/edit', [PointController::class, 'edit'])->name('points.edit');
    Route::put('/points/{id}', [PointController::class, 'update'])->name('points.update');

//---------------/ ADMIN /--------------------------[  loan payments  ]-----------------------------------------------

    Route::get('/loan-payments/create', [LoanPaymentController::class, 'create'])->name('loan-payments.create');
    Route::post('/loan-payments', [LoanPaymentController::class, 'store'])->name('loan-payments.store');

//---------------/ ADMIN /--------------------------[  family  ]-----------------------------------------------

    Route::post('family/create', [FamilyController::class, 'store'])->name('family.store');

//---------------/ ADMIN /--------------------------[  transactions  ]-----------------------------------------------

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

});

//---------------/ USER /--------------------------[  inestments  ]-----------------------------------------------

Route::get('/investments/create/{user}', [InvestmentController::class, 'create'])->name('investments.create');
Route::post('/investments', [InvestmentController::class, 'store'])->name('investments.store');
Route::get('/investments/show/{user}', [InvestmentController::class, 'show'])->name('investments.show');

//---------------/ USER /--------------------------[  loans  ]-----------------------------------------------

Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
Route::get('/my-loans', [LoanController::class, 'myLoans'])->name('loans.my');

//---------------/ USER /--------------------------[  loan payment  ]-----------------------------------------------

Route::get('/loan-payments', [LoanPaymentController::class, 'index'])->name('loan-payments.index');
Route::post('/loan-payments/{payment}/pay', [LoanPaymentController::class, 'pay'])->name('loan-payments.pay');

//---------------/ USER /--------------------------[  family  ]-----------------------------------------------

Route::get('family/{user}', [FamilyController::class, 'show'])->name('family.show');

//---------------/ USER /--------------------------[  transaction  ]-----------------------------------------------

Route::get('/transactions/show/{user}', [TransactionController::class, 'show'])->name('transactions.show');
