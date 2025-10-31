<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\LessonCompletionController;
use App\Http\Controllers\Student\AssignmentSubmissionController;
use App\Http\Controllers\Student\CheckoutController;
use App\Http\Controllers\Student\DiscussionController;
use App\Http\Controllers\Student\DiscussionCommentController;
use App\Http\Controllers\Admin\TransactionProofController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Student\StudentPortalController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\PurchaseController;
use App\Http\Controllers\Student\CertificateRequestController;
use App\Http\Controllers\Auth\GoogleLoginController;

Route::view('/', 'welcome');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:student'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

// Student-facing routes
    Route::middleware(['auth', 'role:student'])->group(function () {
    // Sidebar pages powered by controllers
    Route::get('/courses', [StudentPortalController::class, 'courses'])->name('student.courses');
    Route::get('/assignments', [StudentPortalController::class, 'assignments'])->name('student.assignments');
    Route::get('/certificates', [StudentPortalController::class, 'certificates'])->name('student.certificates');

    // Course enroll only (show route moved to multi-role group below)
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');

    // Lesson completion & assignment submission
    Route::post('/lessons/{lesson}/complete', [LessonCompletionController::class, 'store'])->name('lessons.complete');
    Route::post('/assignments/{assignment}/submit', [AssignmentSubmissionController::class, 'store'])->name('assignments.submit');

    // Discussions (student only form access is allowed in UI)

        // Checkout flow (manual QRIS)
        Route::get('/checkout/course/{course}', [CheckoutController::class, 'show'])->name('checkout.course');
        Route::post('/checkout/course/{course}/confirm', [CheckoutController::class, 'confirm'])->name('checkout.course.confirm');
        Route::get('/payment/waiting', [CheckoutController::class, 'waiting'])->name('student.payment.waiting');

        // Purchase history for students
        Route::get('/purchases', [PurchaseController::class, 'index'])->name('student.purchases');

    // Certificates
    Route::get('/certificate/{course}', [CertificateController::class, 'download'])->name('certificate.download');
    Route::post('/certificate/{course}/request', [CertificateRequestController::class, 'store'])->name('certificate.request');
});

// Admin-only - view private payment proof
Route::get('/admin/transactions/{transaction}/proof', [TransactionProofController::class, 'show'])
    ->middleware(['auth'])
    ->name('admin.transactions.proof');

// Allow course read and discussion posting for students, mentors (owner), and admins
Route::middleware(['auth', 'role:student|mentor|admin'])->group(function () {
    // Course detail (used for discussion UI)
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

    Route::post('/lessons/{lesson}/discussions', [DiscussionController::class, 'store'])->name('lessons.discussions.store');
    Route::patch('/discussions/{discussion}', [DiscussionController::class, 'update'])->name('discussions.update');
    Route::delete('/discussions/{discussion}', [DiscussionController::class, 'destroy'])->name('discussions.destroy');

    Route::post('/discussions/{discussion}/comments', [DiscussionCommentController::class, 'store'])->name('discussions.comments.store');
    Route::patch('/comments/{comment}', [DiscussionCommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [DiscussionCommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/like', [DiscussionCommentController::class, 'toggleLike'])->name('comments.like');
});
