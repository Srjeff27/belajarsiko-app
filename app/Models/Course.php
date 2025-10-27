<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'thumbnail', 'price', 'is_premium', 'status', 'user_id',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
