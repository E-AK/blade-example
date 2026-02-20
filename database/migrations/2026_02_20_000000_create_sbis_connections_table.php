<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sbis_connections', static function (Blueprint $table) {
            $table->id();
            $table->string('protected_key');
            $table->string('service_key');
            $table->string('connection_type');
            $table->string('organization');
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sbis_connections');
    }
};
