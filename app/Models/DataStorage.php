<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataStorage extends Model
{
    use HasFactory;

    protected $table = 'data_storages';

    protected $fillable = [
        'server_address',
        'database_name',
        'user',
        'password',
        'ip_access',
        'comment',
    ];
}
