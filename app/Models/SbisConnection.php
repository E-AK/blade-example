<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SbisConnection extends Model
{
    use HasFactory;

    protected $table = 'sbis_connections';

    protected $fillable = [
        'protected_key',
        'service_key',
        'connection_type',
        'organization',
        'comment',
    ];
}
