<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function courses(Request $request)
    {
        $user = $request->user();

        $courses = Course::withCount(['lessons'])
            ->orderBy('title')
            ->get()
            ->map(function ($course) use ($user) {
                $course->is_enrolled = $user->enrollments()->where('course_id', $course->id)->exists();
                return $course;
            });

        return view('student.courses-index', compact('courses'));
    }

    public function assignments(Request $request)
    {
        $user = $request->user();
        $assignments = Assignment::with(['lesson.course', 'submissions' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])
            ->whereHas('lesson.course.enrollments', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderByRaw('CASE WHEN due_date IS NULL THEN 1 ELSE 0 END, due_date ASC')
            ->get();

        return view('student.assignments-index', compact('assignments'));
    }

    public function certificates(Request $request)
    {
        $user = $request->user();
        $certificates = Certificate::with('course')
            ->where('user_id', $user->id)
            ->latest('generated_at')
            ->get();

        return view('student.certificates-index', compact('certificates'));
    }
}
