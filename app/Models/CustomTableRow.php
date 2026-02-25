<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomTableRow extends Model
{
    use HasFactory;
    protected $table = 'custom_table_rows';

    protected $fillable = [
        'custom_table_id',
        'values',
    ];

    protected function casts(): array
    {
        return [
            'values' => 'array',
        ];
    }

    public function customTable(): BelongsTo
    {
        return $this->belongsTo(CustomTable::class, 'custom_table_id');
    }

    /**
     * Get the value for a given column id.
     */
    public function getValueForColumn(int $columnId): mixed
    {
        $values = $this->values ?? [];

        return $values[$columnId] ?? $values[(string) $columnId] ?? '';
    }
}
