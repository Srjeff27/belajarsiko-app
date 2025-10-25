<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $enrollments = Enrollment::with(['course.lessons', 'course'])
            ->where('user_id', $user->id)
            ->get();

        $progress = [];
        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $totalLessons = $course->lessons()->count();
            $completed = $user->lessonCompletions()
                ->whereIn('lesson_id', $course->lessons()->pluck('id'))
                ->count();
            $percent = $totalLessons > 0 ? round(($completed / $totalLessons) * 100) : 0;
            $progress[$course->id] = $percent;
        }

        return view('dashboard', [
            'enrollments' => $enrollments,
            'progress' => $progress,
        ]);
    }
}
