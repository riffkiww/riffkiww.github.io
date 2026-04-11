<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'medical_record_number' => 'RM-' . fake()->unique()->numerify('######'),
            'full_name' => fake()->name(),
            'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'age' => fake()->numberBetween(5, 90),
            'phone' => fake()->numerify('08##########'),
            'address' => fake()->address(),
            'complaint' => fake()->sentence(8),
            'notes' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(['Aktif', 'Selesai', 'Rujuk']),
        ];
    }
}