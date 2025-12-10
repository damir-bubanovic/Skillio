<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Student\ExamController as StudentExamController;
use App\Http\Controllers\Student\ResultController as StudentResultController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Student / general area
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student exams
    Route::get('/exams', [StudentExamController::class, 'index'])->name('student.exams.index');
    Route::get('/exams/{exam}', [StudentExamController::class, 'show'])->name('student.exams.show');
    Route::post('/exams/{exam}/start', [StudentExamController::class, 'start'])->name('student.exams.start');
    Route::get('/exams/{exam}/attempts/{attempt}', [StudentExamController::class, 'take'])->name('student.exams.take');
    Route::post('/exams/{exam}/attempts/{attempt}', [StudentExamController::class, 'submit'])->name('student.exams.submit');
    Route::get('/exams/{exam}/attempts/{attempt}/result', [StudentExamController::class, 'result'])->name('student.exams.result');

    // Student results
    Route::get('/results', [StudentResultController::class, 'index'])->name('student.results.index');
    Route::get('/results/topics', [StudentResultController::class, 'topics'])->name('student.results.topics');
});

// Admin section
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('questions', QuestionController::class)->except(['show']);
        Route::resource('exams', ExamController::class)->except(['show']);

        Route::get('/stats/questions', [StatsController::class, 'questions'])
            ->name('stats.questions');
    });

require __DIR__.'/auth.php';
