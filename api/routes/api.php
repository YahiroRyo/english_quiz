<?php

use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/quiz')->group(function () {
    Route::prefix('/categoryList')->group(function () {
        Route::get('/', [QuizController::class, 'categoryList']);
        Route::get('/{quizCategoryId}', [QuizController::class, 'category']);
    });
});

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::prefix('/quiz')->group(function () {
        Route::get('/', [QuizController::class, 'getQuizList']);
        Route::post('/', [QuizController::class, 'createQuiz']);

        Route::prefix('/{quizId}')->group(function () {
            Route::get('/', [QuizController::class, 'getQuiz']);
            Route::post('/add', [QuizController::class, 'addMessage']);
        });
    });
});
