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
        // Prefer a stored formal number if available; otherwise create default: 004/SK/BelajarSiko/[Nama Kelas]/YYYY
        $seq = str_pad((string) ($certificate->id ?? 0), 3, '0', STR_PAD_LEFT);
        $courseSegment = Str::of($course->title ?? 'Kelas')
            ->replace(['/', '\\'], '-')
            ->trim();
        $formalNumber = $certificate->formal_number
            ?? (function () use ($course, $setting, $seq, $courseSegment, $generatedAt) {
                $prefix = $course->certificate_number_prefix
                    ?? ($setting->default_number_prefix ?? 'SK/BelajarSiko/[Nama Kelas]');
                $prefix = str_replace(['[Nama Kelas]', '{course}', '{COURSE}'], [$courseSegment, $courseSegment, $courseSegment], $prefix);
                return $seq . '/' . $prefix . '/' . $generatedAt->format('Y');
            })();

        // Allow overriding type via stored field or request, fallback to course default, default to KELULUSAN
        $certificateType = strtoupper($certificate->type ?? $request->get('type', $course->certificate_type ?? ($setting->default_certificate_type ?? 'KELULUSAN')));

        // Optional extras if the course/certificate provides them
        $courseSubtitle = $certificate->course_subtitle ?? ($course->certificate_course_subtitle ?? ($setting->default_course_subtitle ?? null));
        // totalJP: prefer explicit field, fallback to sum of competencies JP, then course default
        $totalJP = $certificate->total_jp;
        if (empty($totalJP) && is_array($certificate->competencies)) {
            $sum = 0; $hasAny = false;
            foreach ($certificate->competencies as $row) {
                if (isset($row['jp']) && $row['jp'] !== '') { $sum += (int) $row['jp']; $hasAny = true; }
            }
            if ($hasAny) { $totalJP = $sum; }
        }
        if (empty($totalJP) && is_array($course->certificate_competencies ?? null)) {
            $sum = 0; $hasAny = false;
            foreach ($course->certificate_competencies as $row) {
                if (isset($row['jp']) && $row['jp'] !== '') { $sum += (int) $row['jp']; $hasAny = true; }
            }
            if ($hasAny) { $totalJP = $sum; }
        }
        if (empty($totalJP) && isset($course->certificate_total_jp)) {
            $totalJP = $course->certificate_total_jp;
        }
        if (empty($totalJP) && isset($setting->default_total_jp)) {
            $totalJP = $setting->default_total_jp;
        }

        $assessedAt = $certificate->assessed_at ?? $course->certificate_assessed_at ?? $setting->default_assessed_at ?? $certificate->generated_at;

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
            'assessedAt' => $assessedAt,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('sertifikat-'.$course->id.'-'.$user->id.'.pdf');
    }
}
