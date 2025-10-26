<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\LessonCompletionController;
use App\Http\Controllers\Student\AssignmentSubmissionController;
use App\Http\Controllers\Student\CheckoutController;
use App\Http\Controllers\Admin\TransactionProofController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Student\StudentPortalController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Auth\GoogleLoginController;

Route::view('/', 'welcome');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

// Student-facing routes
Route::middleware(['auth'])->group(function () {
    // Sidebar pages powered by controllers
    Route::get('/courses', [StudentPortalController::class, 'courses'])->name('student.courses');
    Route::get('/assignments', [StudentPortalController::class, 'assignments'])->name('student.assignments');
    Route::get('/certificates', [StudentPortalController::class, 'certificates'])->name('student.certificates');

    // Course show and enroll
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');

    // Lesson completion & assignment submission
    Route::post('/lessons/{lesson}/complete', [LessonCompletionController::class, 'store'])->name('lessons.complete');
    Route::post('/assignments/{assignment}/submit', [AssignmentSubmissionController::class, 'store'])->name('assignments.submit');

    // Checkout flow (manual QRIS)
    Route::get('/checkout/course/{course}', [CheckoutController::class, 'show'])->name('checkout.course');
    Route::post('/checkout/course/{course}/confirm', [CheckoutController::class, 'confirm'])->name('checkout.course.confirm');
    Route::get('/payment/waiting', [CheckoutController::class, 'waiting'])->name('student.payment.waiting');

    // Certificates
    Route::get('/certificate/{course}', [CertificateController::class, 'download'])->name('certificate.download');
});

// Admin-only - view private payment proof
Route::get('/admin/transactions/{transaction}/proof', [TransactionProofController::class, 'show'])
    ->middleware(['auth'])
    ->name('admin.transactions.proof');

