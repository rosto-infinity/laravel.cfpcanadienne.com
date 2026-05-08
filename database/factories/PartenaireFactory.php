<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\Partenaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartenaireFactory extends Factory
{
    protected $model = Partenaire::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nom' => fake()->company(),
            'logo' => null,
            'siteweb' => fake()->url(),
            'statut' => 'en_attente',
            'description' => fake()->paragraph(),
        ];
    }

    public function approuve(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'approuve',
        ]);
    }

    public function rejete(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'rejete',
        ]);
    }
}
