<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'thumbnail', 'price', 'is_premium', 'status', 'user_id', 'course_category_id',
        'mentor_signature_name', 'mentor_signature',
        // Certificate defaults per-class
        'certificate_total_jp', 'certificate_competencies',
    ];

    protected $appends = [
        'thumbnail_url',
        'mentor_name',
    ];

    protected $casts = [
        'certificate_competencies' => 'array',
        'certificate_total_jp' => 'integer',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
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

    // Accessors
    public function getThumbnailUrlAttribute(): ?string
    {
        if (! $this->thumbnail) {
            return null;
        }

        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        return Storage::disk('public')->url($this->thumbnail);
    }

    public function getMentorNameAttribute(): ?string
    {
        return $this->owner?->name;
    }
}
