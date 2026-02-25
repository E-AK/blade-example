<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_table_columns', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_table_id')->constrained('custom_tables')->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('string');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_table_columns');
    }
};
