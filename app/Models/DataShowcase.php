<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataShowcase extends Model
{
    use HasFactory;

    protected $table = 'data_showcases';

    protected $fillable = [
        'name',
        'section',
        'table_name',
        'period',
        'status',
        'row_count',
        'loaded_rows',
        'progress',
    ];

    protected function casts(): array
    {
        return [
            'row_count' => 'integer',
            'loaded_rows' => 'integer',
            'progress' => 'integer',
        ];
    }
}
