<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomTableColumn extends Model
{
    use HasFactory;

    protected $table = 'custom_table_columns';

    protected $fillable = [
        'custom_table_id',
        'name',
        'type',
        'sort_order',
        'data_type',
        'example_data',
        'is_required',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_required' => 'boolean',
        ];
    }

    public function customTable(): BelongsTo
    {
        return $this->belongsTo(CustomTable::class, 'custom_table_id');
    }
}
