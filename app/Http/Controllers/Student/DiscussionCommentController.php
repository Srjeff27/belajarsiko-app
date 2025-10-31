<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\DiscussionComment;
use Illuminate\Http\Request;

class DiscussionCommentController extends Controller
{
    public function store(Request $request, Discussion $discussion)
    {
        $user = $request->user();

        // Only enrolled students or course owner may comment
        $lesson = $discussion->lesson;
        $enrolled = $user->enrollments()->where('course_id', $lesson->course_id)->exists();
        $isOwner = $lesson->course?->user_id === $user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;

        abort_unless($enrolled || $isOwner || $isAdmin, 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:3000'],
            'google_drive_link' => ['nullable', 'url', 'max:2048'],
        ]);

        DiscussionComment::create([
            'discussion_id' => $discussion->id,
            'user_id' => $user->id,
            'content' => $validated['content'],
            'google_drive_link' => $validated['google_drive_link'] ?? null,
        ]);

        return back()->with('flash', [
            'type' => 'success',
            'title' => 'Komentar Ditambahkan',
            'message' => 'Komentar berhasil diposting.',
        ]);
    }

    public function update(Request $request, DiscussionComment $comment)
    {
        $user = $request->user();
        $lesson = $comment->discussion->lesson;
        $enrolled = $user->enrollments()->where('course_id', $lesson->course_id)->exists();
        $isOwner = $lesson->course?->user_id === $user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;

        abort_unless($comment->user_id === $user->id || $isOwner || $isAdmin, 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:3000'],
            'google_drive_link' => ['nullable', 'url', 'max:2048'],
        ]);

        $comment->update($validated);

        return back()->with('flash', [
            'type' => 'success',
            'title' => 'Komentar Diperbarui',
            'message' => 'Perubahan komentar disimpan.',
        ]);
    }

    public function destroy(Request $request, DiscussionComment $comment)
    {
        $user = $request->user();
        $lesson = $comment->discussion->lesson;
        $isOwner = $lesson->course?->user_id === $user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;

        abort_unless($comment->user_id === $user->id || $isOwner || $isAdmin, 403);

        $comment->delete();

        return back()->with('flash', [
            'type' => 'success',
            'title' => 'Komentar Dihapus',
            'message' => 'Komentar berhasil dihapus.',
        ]);
    }

    public function toggleLike(Request $request, DiscussionComment $comment)
    {
        $user = $request->user();
        $lesson = $comment->discussion->lesson;
        $enrolled = $user->enrollments()->where('course_id', $lesson->course_id)->exists();
        $isOwner = $lesson->course?->user_id === $user->id;
        $isAdmin = method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;

        abort_unless($enrolled || $isOwner || $isAdmin, 403);

        $existing = $comment->likes()->where('user_id', $user->id)->first();
        if ($existing) {
            $existing->delete();
        } else {
            $comment->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }
}
