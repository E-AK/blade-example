<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_showcases', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('section')->nullable();
            $table->string('table_name')->nullable();
            $table->string('period')->nullable();
            $table->string('status', 20)->default('info');
            $table->unsignedInteger('row_count')->default(0);
            $table->unsignedInteger('loaded_rows')->default(0);
            $table->unsignedTinyInteger('progress')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_showcases');
    }
};
