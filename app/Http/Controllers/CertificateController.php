<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CertificateSetting;

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

        // If certificate already exists (could be created by admin/mentor), allow download without progress check
        $certificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (! $certificate) {
            // Calculate progress only when auto-generating new certificate
            $totalLessons = $course->lessons()->count();
            $completed = $user->lessonCompletions()->whereIn('lesson_id', $course->lessons()->pluck('id'))->count();
            $percent = $totalLessons > 0 ? round(($completed / $totalLessons) * 100) : 0;
            abort_unless($percent === 100, 403, 'Progres belum 100%.');

            $certificate = Certificate::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'generated_at' => now(),
                'unique_code' => Str::upper(Str::random(10)),
            ]);
        }

        $setting = CertificateSetting::first();

        // Resolve signature image paths for PDF (local filesystem paths)
        $directorSignaturePath = $setting && $setting->director_signature ? storage_path('app/public/'.$setting->director_signature) : null;
        // Prefer certificate-level override, fallback to course configuration, then mentor profile
        $mentorSignaturePath = null;
        if (!empty($certificate->mentor_signature)) {
            $mentorSignaturePath = storage_path('app/public/'.$certificate->mentor_signature);
        } elseif (!empty($course->mentor_signature)) {
            $mentorSignaturePath = storage_path('app/public/'.$course->mentor_signature);
        } elseif (!empty($course->owner?->certificate_signature)) {
            $mentorSignaturePath = storage_path('app/public/'.$course->owner->certificate_signature);
        }


        // Build presentational helpers for the certificate view
        $generatedAt = $certificate->generated_at ?? now();
        $romanMonths = [1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $romanMonth = $romanMonths[(int) $generatedAt->format('n')] ?? '';
        // Prefer a stored formal number if available; otherwise create a readable default pattern
        $formalNumber = $certificate->formal_number
            ?? str_pad((string) ($certificate->id ?? 0), 3, '0', STR_PAD_LEFT)
                .'/SK/BelajarSiko/'. $romanMonth .'/'. $generatedAt->format('Y');

        // Allow overriding type via stored field or request, default to KELULUSAN
        $certificateType = strtoupper($certificate->type ?? $request->get('type', 'KELULUSAN'));

        // Optional extras if the course/certificate provides them
        $courseSubtitle = $certificate->course_subtitle ?? ($course->subtitle ?? null);
        $totalJP = $certificate->total_jp ?? ($course->total_jp ?? null);

        $pdf = Pdf::loadView('pdf.certificate', [
            'user' => $user,
            'course' => $course,
            'certificate' => $certificate,
            'directorName' => $setting->director_name ?? 'Director of BelajarSiko',
            'directorSignaturePath' => $directorSignaturePath,
            'mentorName' => $certificate->mentor_signature_name
                ?: ($course->mentor_signature_name
                    ?: ($course->owner?->certificate_signature_name
                        ?: ($course->owner?->name ?? 'Mentor'))),
            'mentorSignaturePath' => $mentorSignaturePath,
            // New presentational data
            'formalNumber' => $formalNumber,
            'certificateType' => $certificateType,
            'courseSubtitle' => $courseSubtitle,
            'totalJP' => $totalJP,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('sertifikat-'.$course->id.'-'.$user->id.'.pdf');
    }
}
