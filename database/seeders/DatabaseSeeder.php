<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Assignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'student']);

        // Admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@belajarsiko.test',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');

        // Student user
        $student = User::firstOrCreate([
            'email' => 'student@belajarsiko.test',
        ], [
            'name' => 'Student Demo',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
        $student->assignRole('student');

        // Sample data: Course, Lessons, Assignment
        $course = Course::create([
            'title' => 'Pemrograman Dasar',
            'description' => 'Belajar dasar-dasar pemrograman.',
            'price' => 150000,
            'is_premium' => true,
        ]);

        $lesson1 = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Pengenalan',
            'lesson_type' => 'video',
            'content_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'position' => 1,
        ]);

        $lesson2 = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Modul E-book',
            'lesson_type' => 'ebook',
            'content_url' => 'https://drive.google.com/file/d/FILE_ID/preview',
            'position' => 2,
        ]);

        Assignment::create([
            'lesson_id' => $lesson1->id,
            'title' => 'Tugas 1',
            'description' => 'Kumpulkan link Google Drive tugas Anda.',
            'due_date' => now()->addWeek(),
        ]);
        $this->call(MentorSeeder::class);
    }
}

