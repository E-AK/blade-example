<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomTable extends Model
{
    use HasFactory;

    protected $table = 'custom_tables';

    protected $fillable = [
        'name',
        'row_count',
        'data_volume',
    ];

    protected function casts(): array
    {
        return [
            'row_count' => 'integer',
        ];
    }

    public function columns(): HasMany
    {
        return $this->hasMany(CustomTableColumn::class, 'custom_table_id')->orderBy('sort_order');
    }

    public function rows(): HasMany
    {
        return $this->hasMany(CustomTableRow::class, 'custom_table_id');
    }
}
