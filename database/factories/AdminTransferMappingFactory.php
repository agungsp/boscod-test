<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminTransferMapping>
 */
class AdminTransferMappingFactory extends Factory
{
    static int $seq = 0;
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
            'admin_bank_id' => static::$seq,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
