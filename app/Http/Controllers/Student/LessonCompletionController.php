<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use Illuminate\Http\Request;

class LessonCompletionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Request $request, Lesson $lesson)
    {
        $request->user()->lessonCompletions()->firstOrCreate([
            'lesson_id' => $lesson->id,
        ], [
            'completed_at' => now(),
        ]);

        return back()->with('status', 'Materi ditandai selesai.');
    }
}
