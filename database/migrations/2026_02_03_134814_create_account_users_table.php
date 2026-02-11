<?php

declare(strict_types=1);

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_user', static function (Blueprint $table) {
            $table->foreignIdFor(Account::class);
            $table->foreignIdFor(User::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_user');
    }
};
