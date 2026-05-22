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
        $images = [
            'images/heroes/hero-1.jpeg',
            'images/heroes/hero-2.jpeg',
            'images/heroes/hero-3.jpeg',
            'images/heroes/hero-4.jpeg',
            'images/heroes/hero-5.jpeg',
            'images/heroes/hero-6.jpeg',
            'images/heroes/hero-7.jpeg',
            'images/heroes/hero-8.jpeg',
            'images/heroes/hero-9.jpeg',
            'images/heroes/hero-10.jpeg',
            'images/heroes/hero-11.jpeg',
            'images/heroes/hero-12.jpeg',
            'images/heroes/hero-13.jpeg',
            'images/heroes/hero-14.jpeg',
            'images/heroes/hero-15.jpeg',
            'images/heroes/hero-16.jpeg',
            'images/heroes/hero-17.jpeg',
            'images/heroes/hero-18.jpeg',
        ];

        return $images[array_rand($images)];
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
