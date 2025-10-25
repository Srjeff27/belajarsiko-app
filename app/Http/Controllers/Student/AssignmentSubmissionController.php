<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;

class AssignmentSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'google_drive_link' => ['required', 'url']
        ]);

        AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'user_id' => $request->user()->id,
            ],
            [
                'google_drive_link' => $validated['google_drive_link'],
                'submitted_at' => now(),
            ]
        );

        return back()->with('status', 'Tugas dikirim. Menunggu penilaian.');
    }
}
