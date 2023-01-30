<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'bank_id' => rand(1, 141),
            'account_number' => fake()->numerify(str_repeat('#', 10)),
            'name' => fake()->name(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
