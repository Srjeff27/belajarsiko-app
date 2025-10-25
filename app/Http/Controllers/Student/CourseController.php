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
        $course->load(['lessons.assignments.submissions']);
        return view('student.course-show', compact('course'));
    }
}

