<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('import_tasks', static function (Blueprint $table) {
            $table->id();
            $table->string('command');
            $table->boolean('collect_from_date')->default(false);
            $table->date('period_start_date')->nullable();
            $table->date('period_end_date')->nullable();
            $table->unsignedInteger('records_count')->default(0);
            $table->string('webhook_mode', 20)->default('send'); // 'send' or 'delete'
            $table->string('status', 20)->default('success'); // success, error, attention, info, pause
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_tasks');
    }
};
