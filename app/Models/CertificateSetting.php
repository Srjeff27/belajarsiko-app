<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'director_name', 'director_signature',
        // Global defaults for certificate info
        'default_certificate_type', 'default_number_prefix', 'default_course_subtitle',
        'default_total_jp', 'default_assessed_at',
    ];

    protected $casts = [
        'default_assessed_at' => 'datetime',
        'default_total_jp' => 'integer',
    ];
}
