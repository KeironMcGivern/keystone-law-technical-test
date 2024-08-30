<?php

namespace Database\Factories;

use App\Domain\PinnedLink\Enums\Tags;
use App\Models\PinnedLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class PinnedLinkFactory extends Factory
{
    protected $model = PinnedLink::class;

    public function definition(): array
    {
        return [
            'url' => fake()->url(),
            'title' => fake()->word(),
            'comments' => fake()->sentences(2, true),
            'tags' => [
                Tags::collect()->random(),
                Tags::collect()->random()
            ],
        ];
    }
}
