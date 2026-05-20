<?php

namespace App\Services;

use App\Models\FightLog;
use Faker\Factory as Faker;

class FightService
{
    private array $spells = [
        'Strong Strike',
        'Ice Projectile',
        'Shield',
        'Aura',
        'Critical Hit',
        'Voice of Nature',
        'Rage',
        'Reincarnation',
    ];

    public function createPlayer(): array
    {
        $faker = Faker::create();

        return [
            'name' => $faker->firstName(),
            'hp' => rand(50, 100),
            'strength' => rand(15, 25),
            'defense' => rand(1, 5),
            'spell' => $this->spells[array_rand($this->spells)],
            'image' => $this->randomHeroImage(),
            'aura_active' => false,
        ];
    }

    private function randomHeroImage(): string
    {
        $images = glob(public_path('images/heroes/*.{jpg,jpeg,png,webp}'), GLOB_BRACE);

        if (empty($images)) {
            return 'images/heroes/hero-1.jpg';
        }

        return 'images/heroes/' . basename($images[array_rand($images)]);
    }

    public function saveFightLog(int $turn, string $description): void
    {
        FightLog::create([
            'fight_id' => session('fight_id'),
            'turn_number' => $turn,
            'description' => $description,
        ]);
    }
}
