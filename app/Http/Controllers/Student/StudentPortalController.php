<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Certificate;
use App\Models\CertificateRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class StudentPortalController extends Controller
{
    // Hapus __construct(), middleware auth sudah ada di route group (biasanya)
    // public function __construct()
    // {
    //     $this->middleware(['auth']);
    // }

    public function courses(Request $request) // Request tidak perlu diinject jika pakai Auth::user()
    {
        $user = Auth::user(); // <-- Gunakan Auth facade lebih umum

        // Ambil ID kursus yang sudah di-enroll user (lebih efisien)
        $enrolledCourseIds = $user->enrollments()->pluck('course_id');

        // Siapkan daftar kategori untuk filter
        $categories = CourseCategory::query()
            ->orderBy('name')
            ->get(['id','name','slug']);

        // Tentukan kategori aktif dari query string (dukungan slug atau category_id)
        $activeCategory = null;
        if ($slug = $request->query('category')) {
            $activeCategory = $categories->firstWhere('slug', $slug);
        } elseif ($request->filled('category_id')) {
            $activeCategory = $categories->firstWhere('id', (int) $request->query('category_id'));
        }

        // Ambil courses + relasi, terapkan filter kategori jika ada
        $query = Course::with([
                'owner' => function ($query) { $query->select('id', 'name'); },
                'category:id,name,slug',
            ])
            ->withCount(['lessons'])
            ->orderBy('title');

        if ($activeCategory) {
            $query->where('course_category_id', $activeCategory->id);
        }

        $courses = $query->paginate(12)->withQueryString();

        // Kirimkan variabel ke view
        return view('student.courses-index', compact('courses', 'enrolledCourseIds', 'categories', 'activeCategory'));
    }

    public function assignments(Request $request)
    {
        $user = Auth::user();

        $assignments = Assignment::with(['lesson:id,title,course_id', 'lesson.course:id,title'])
            ->whereHas('lesson.course.enrollments', function ($q) use ($user) {
                // [FIX] Ganti 'user_id' string dengan $user->id variabel
                $q->where('user_id', $user->id); 
            })
            ->with(['submissions' => function ($q) use ($user) { // Perbaiki juga passing $user ke closure ini
                $q->where('user_id', $user->id)->select('id', 'assignment_id', 'user_id', 'grade', 'feedback_comment', 'google_drive_link');
            }])
            ->orderByRaw('CASE WHEN due_date IS NULL THEN 1 ELSE 0 END, due_date ASC')
            ->paginate(15);

        return view('student.assignments-index', compact('assignments'));
    }

    public function certificates(Request $request) // Request tidak perlu diinject jika pakai Auth::user()
    {
        $user = Auth::user(); // <-- Gunakan Auth facade
        
        $certificates = Certificate::with('course:id,title,thumbnail') // Load relasi course secukupnya
            ->where('user_id', $user->id)
            ->latest('generated_at')
            ->paginate(10); // <-- Gunakan pagination

        // Cari kursus yang selesai 100% tetapi belum ada certificate record
        $enrolledCourseIds = $user->enrollments()->pluck('course_id');
        $courses = Course::whereIn('id', $enrolledCourseIds)->with('lessons:id,course_id')->get(['id','title','thumbnail']);

        $completedCourseIds = collect();
        foreach ($courses as $course) {
            $total = $course->lessons->count();
            if ($total === 0) continue;
            $completed = $user->lessonCompletions()->whereIn('lesson_id', $course->lessons->pluck('id'))->count();
            if ($total > 0 && $completed === $total) {
                $completedCourseIds->push($course->id);
            }
        }

        $alreadyCertifiedIds = Certificate::where('user_id', $user->id)->pluck('course_id');
        $eligibleCourseIds = $completedCourseIds->diff($alreadyCertifiedIds)->values();
        $requestedCourseIds = CertificateRequest::where('user_id', $user->id)->pluck('course_id');
        $eligibleCourses = $courses->whereIn('id', $eligibleCourseIds);

        return view('student.certificates-index', compact('certificates', 'eligibleCourses', 'requestedCourseIds'));
    }
}
