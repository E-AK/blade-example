<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PasswordManagerEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasswordManagerEntryFactory extends Factory
{
    protected $model = PasswordManagerEntry::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'url' => fake()->optional(0.6)->url(),
            'folder' => fake()->optional(0.7)->randomElement(['Пароли от акаунтов', 'Сервисы', 'Банки', 'Соцсети']),
            'login' => fake()->userName(),
            'password' => fake()->password(12, 24),
            'comment' => fake()->optional(0.5)->sentence(),
        ];
    }
}
