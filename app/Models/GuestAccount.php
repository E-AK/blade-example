<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'comment',
        'connections',
        'data_collection',
        'custom_tables',
        'services',
        'event_chains',
        'reports',
    ];

    protected function casts(): array
    {
        return [
            'connections' => 'boolean',
            'data_collection' => 'boolean',
            'custom_tables' => 'boolean',
            'services' => 'boolean',
            'event_chains' => 'boolean',
            'reports' => 'boolean',
        ];
    }
}
