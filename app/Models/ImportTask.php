<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportTask extends Model
{
    use HasFactory;

    protected $table = 'import_tasks';

    protected $fillable = [
        'command',
        'collect_from_date',
        'period_start_date',
        'period_end_date',
        'records_count',
        'webhook_mode',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'collect_from_date' => 'boolean',
            'period_start_date' => 'date',
            'period_end_date' => 'date',
            'records_count' => 'integer',
        ];
    }
}
