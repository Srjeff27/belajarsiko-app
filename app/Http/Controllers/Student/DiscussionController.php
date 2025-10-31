<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\Lesson;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function store(Request $request, Lesson $lesson)
    {
        $user = $request->user();

        // Only enrolled students or course owner may post
        $enrolled = $user->enrollments()->where('course_id', $lesson->course_id)->exists();
        $isOwner = $lesson->course?->user_id === $user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;

        abort_unless($enrolled || $isOwner || $isAdmin, 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:5000'],
            'google_drive_link' => ['nullable', 'url', 'max:2048'],
        ]);

        Discussion::create([
            'lesson_id' => $lesson->id,
            'user_id' => $user->id,
            'content' => $validated['content'],
            'google_drive_link' => $validated['google_drive_link'] ?? null,
        ]);

        return back()->with('flash', [
            'type' => 'success',
            'title' => 'Diskusi Dibuat',
            'message' => 'Topik diskusi berhasil dipublikasikan.',
        ]);
    }

    public function update(Request $request, Discussion $discussion)
    {
        $user = $request->user();
        $lesson = $discussion->lesson;
        $isOwner = $lesson->course?->user_id === $user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;

        abort_unless($discussion->user_id === $user->id || $isOwner || $isAdmin, 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:5000'],
            'google_drive_link' => ['nullable', 'url', 'max:2048'],
        ]);

        $discussion->update($validated);

        return back()->with('flash', [
            'type' => 'success',
            'title' => 'Diskusi Diperbarui',
            'message' => 'Topik diskusi berhasil diperbarui.',
        ]);
    }

    public function destroy(Request $request, Discussion $discussion)
    {
        $user = $request->user();
        $lesson = $discussion->lesson;
        $isOwner = $lesson->course?->user_id === $user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;

        abort_unless($discussion->user_id === $user->id || $isOwner || $isAdmin, 403);

        $discussion->delete();

        return back()->with('flash', [
            'type' => 'success',
            'title' => 'Diskusi Dihapus',
            'message' => 'Topik diskusi telah dihapus.',
        ]);
    }
}
