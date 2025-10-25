<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function download(Request $request, Course $course)
    {
        $user = $request->user();

        // Ensure enrolled
        abort_unless($user->enrollments()->where('course_id', $course->id)->exists(), 403);

        // Calculate progress
        $totalLessons = $course->lessons()->count();
        $completed = $user->lessonCompletions()->whereIn('lesson_id', $course->lessons()->pluck('id'))->count();
        $percent = $totalLessons > 0 ? round(($completed / $totalLessons) * 100) : 0;
        abort_unless($percent === 100, 403, 'Progres belum 100%.');

        $certificate = Certificate::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'generated_at' => now(),
                'unique_code' => Str::upper(Str::random(10)),
            ]
        );

        $pdf = Pdf::loadView('pdf.certificate', [
            'user' => $user,
            'course' => $course,
            'certificate' => $certificate,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('sertifikat-'.$course->id.'-'.$user->id.'.pdf');
    }
}
