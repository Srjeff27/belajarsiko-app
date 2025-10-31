<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function show(Course $course)
    {
        $user = auth()->user();

        $course->load([
            'lessons' => function ($q) {
                $q->orderBy('position');
            },
            'lessons.assignments.submissions',
            'lessons.discussions.user:id,name',
            'lessons.discussions.comments' => function ($q) {
                $q->with('user:id,name')->withCount('likes');
            },
            'category:id,name'
        ]);

        $isEnrolled = $user->enrollments()->where('course_id', $course->id)->exists();

        $completedLessons = $user->lessonCompletions()
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->pluck('lesson_id');

        return view('student.course-show', compact('course', 'isEnrolled', 'completedLessons'));
    }
}
