<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_storages', static function (Blueprint $table) {
            $table->id();
            $table->string('server_address');
            $table->string('database_name');
            $table->string('user');
            $table->string('password');
            $table->string('ip_access')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_storages');
    }
};
