<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guest_accounts', static function (Blueprint $table) {
            $table->boolean('connections')->default(false)->after('comment');
            $table->boolean('data_collection')->default(false)->after('connections');
            $table->boolean('custom_tables')->default(false)->after('data_collection');
            $table->boolean('services')->default(false)->after('custom_tables');
            $table->boolean('event_chains')->default(false)->after('services');
            $table->boolean('reports')->default(false)->after('event_chains');
        });
    }

    public function down(): void
    {
        Schema::table('guest_accounts', static function (Blueprint $table) {
            $table->dropColumn([
                'connections',
                'data_collection',
                'custom_tables',
                'services',
                'event_chains',
                'reports',
            ]);
        });
    }
};
