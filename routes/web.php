<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\LessonCompletionController;
use App\Http\Controllers\Student\AssignmentSubmissionController;
use App\Http\Controllers\Student\CheckoutController;
use App\Http\Controllers\Admin\TransactionProofController;
use App\Http\Controllers\CertificateController;

Route::view('/', 'welcome');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// Student-facing routes
Route::middleware(['auth'])->group(function () {
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/lessons/{lesson}/complete', [LessonCompletionController::class, 'store'])->name('lessons.complete');
    Route::post('/assignments/{assignment}/submit', [AssignmentSubmissionController::class, 'store'])->name('assignments.submit');

    Route::get('/checkout/course/{course}', [CheckoutController::class, 'show'])->name('checkout.course');
    Route::post('/checkout/course/{course}/confirm', [CheckoutController::class, 'confirm'])->name('checkout.course.confirm');
    Route::get('/payment/waiting', [CheckoutController::class, 'waiting'])->name('student.payment.waiting');

    Route::get('/certificate/{course}', [CertificateController::class, 'download'])->name('certificate.download');
});

// Admin-only - view private payment proof
Route::get('/admin/transactions/{transaction}/proof', [TransactionProofController::class, 'show'])
    ->middleware(['auth'])
    ->name('admin.transactions.proof');

