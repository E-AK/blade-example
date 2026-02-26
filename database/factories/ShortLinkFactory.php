<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ShortLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortLinkFactory extends Factory
{
    protected $model = ShortLink::class;

    public function definition(): array
    {
        $slug = fake()->regexify('[A-Za-z0-9]{6}-[a-z]+');

        return [
            'original_url' => fake()->url().'/?utm_referrer='.urlencode(fake()->url()),
            'short_url' => 'https://taviat.ru/r/'.$slug,
            'clicks' => fake()->numberBetween(0, 100),
            'comment' => fake()->optional(0.5)->sentence(),
        ];
    }
}
