<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CertificateRequest;
use App\Models\Course;
use Illuminate\Http\Request;

class CertificateRequestController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = $request->user();

        // Must be enrolled
        abort_unless($user->enrollments()->where('course_id', $course->id)->exists(), 403);

        // Must be completed 100%
        $total = $course->lessons()->count();
        $completed = $user->lessonCompletions()->whereIn('lesson_id', $course->lessons()->pluck('id'))->count();
        abort_unless($total > 0 && $completed === $total, 403);

        // If certificate already exists, just redirect to download
        $exists = Certificate::where('user_id', $user->id)->where('course_id', $course->id)->exists();
        if ($exists) {
            return redirect()->route('certificate.download', $course);
        }

        // Create request if not exists
        CertificateRequest::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ], [
            'status' => 'pending',
        ]);

        return back()->with('flash', [
            'type' => 'success',
            'title' => 'Permintaan Dikirim',
            'message' => 'Permintaan sertifikat Anda telah dikirim ke mentor/admin.',
        ]);
    }
}

