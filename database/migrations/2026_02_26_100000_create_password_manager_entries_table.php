<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_manager_entries', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('folder')->nullable();
            $table->string('login')->nullable();
            $table->string('password');
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_manager_entries');
    }
};
