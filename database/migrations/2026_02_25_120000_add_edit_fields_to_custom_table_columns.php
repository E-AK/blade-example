<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('custom_table_columns', static function (Blueprint $table) {
            $table->string('data_type')->nullable()->after('type');
            $table->string('example_data')->nullable()->after('data_type');
            $table->boolean('is_required')->default(false)->after('example_data');
            $table->text('comment')->nullable()->after('is_required');
        });
    }

    public function down(): void
    {
        Schema::table('custom_table_columns', static function (Blueprint $table) {
            $table->dropColumn(['data_type', 'example_data', 'is_required', 'comment']);
        });
    }
};
