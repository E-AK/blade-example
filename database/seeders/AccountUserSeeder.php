<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class AccountUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userPool = User::factory(100)->create();

        $accounts = Account::factory()
            ->count(50)
            ->create();

        $assigned = collect();
        $accounts->each(function (Account $account) use ($userPool, &$assigned) {
            $count = rand(1, 10);
            $ids = $userPool->random($count)->pluck('id')->toArray();
            $account->users()->attach($ids);
            $assigned = $assigned->merge($ids)->unique();
        });

        $unassigned = $userPool->pluck('id')->diff($assigned);
        foreach ($unassigned as $userId) {
            $accounts->random()->users()->attach($userId);
        }
    }
}
