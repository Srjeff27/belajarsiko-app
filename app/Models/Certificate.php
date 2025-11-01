<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    /** @use HasFactory<\Database\Factories\CertificateFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 'generated_at', 'unique_code', 'google_drive_link',
        // Extended certificate metadata
        'type', 'formal_number', 'course_subtitle', 'total_jp', 'assessed_at',
        'competencies',
        // Optional mentor overrides
        'mentor_signature_name', 'mentor_signature',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'assessed_at' => 'datetime',
        'competencies' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
