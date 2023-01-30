<?php

namespace Database\Factories;

use App\Models\BankAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdminBankFactory extends Factory
{
    static int $seq = 0;
    protected $model = BankAdmin::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static::$seq += 1;
        return [
            'bank_id' => static::$seq,
            'account_number' => fake()->numerify(str_repeat("#", 10)),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
