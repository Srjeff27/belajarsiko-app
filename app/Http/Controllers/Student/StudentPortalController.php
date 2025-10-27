<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Certificate;
use App\Models\Course;
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

        // [UBAH] Ambil ID kursus yang sudah di-enroll user (lebih efisien)
        $enrolledCourseIds = $user->enrollments()->pluck('course_id');

        // [UBAH] Ambil courses, tambahkan relasi mentor jika 'owner' adalah mentor, tambahkan pagination
        $courses = Course::with(['owner' => function($query){ // Asumsi 'owner' adalah relasi ke mentor/guru
                              $query->select('id', 'name'); // Hanya ambil ID dan nama mentor
                           }])
                           ->withCount(['lessons'])
                           ->orderBy('title')
                           ->paginate(12); // <-- Gunakan pagination

        // [UBAH] Kirimkan $enrolledCourseIds juga ke view
        return view('student.courses-index', compact('courses', 'enrolledCourseIds'));
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
        
        $certificates = Certificate::with('course:id,title') // Load relasi course secukupnya
            ->where('user_id', $user->id)
            ->latest('generated_at')
            ->paginate(10); // <-- Gunakan pagination

        return view('student.certificates-index', compact('certificates'));
    }
}