<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordManagerEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'password_manager_entries';

    protected $fillable = [
        'name',
        'url',
        'folder',
        'login',
        'password',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime',
        ];
    }
}
