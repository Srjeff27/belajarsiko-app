<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Request $request, Course $course)
    {
        // Only allow free courses to enroll directly
        if ($course->is_premium) {
            return redirect()->route('checkout.course', $course);
        }

        Enrollment::firstOrCreate([
            'user_id' => $request->user()->id,
            'course_id' => $course->id,
        ]);

        return redirect()->route('courses.show', $course)
            ->with('status', 'Anda berhasil mendaftar ke kelas.');
    }
}
