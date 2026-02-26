<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_url',
        'short_url',
        'clicks',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'clicks' => 'integer',
        ];
    }
}
