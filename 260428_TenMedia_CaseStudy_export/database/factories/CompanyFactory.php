<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cmpny_name' => fake()->company(),
            'cmpny_description' => fake()->sentence(),
            // 'website' => fake()->url(),
            // Feste Weiterleitung für alle Test-URLs
            'website' => 'https://www.funfacts.de/',
            'cmpny_location' => fake()->city(),
        ];
    }
}
