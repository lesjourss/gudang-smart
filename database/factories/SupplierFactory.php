<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_supplier' => 'SUP' . str_pad((string) fake()->unique()->numberBetween(1, 9999999), 7, '0', STR_PAD_LEFT),
            'nama_pt' => 'PT ' . fake()->company(),
            'email' => fake()->unique()->companyEmail(),
            'telepon' => fake()->phoneNumber(),
            'alamat' => fake()->address(),
        ];
    }
}

