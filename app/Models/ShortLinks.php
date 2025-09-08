<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortLinks extends Model
{
    protected $table = 'shortlinks';
    protected $fillable = ['short_code', 'short_url', 'original_url', 'clicks', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
