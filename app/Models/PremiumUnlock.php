<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumUnlock extends Model
{
    /** @use HasFactory<\Database\Factories\PremiumUnlockFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'unlockable_type', 'unlockable_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

