<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class BookFactory extends Factory
{
    public function definition(): array
    {
        $total = $this->faker->numberBetween(1, 10);
        $available = $this->faker->numberBetween(0, $total);
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'isbn' => $this->faker->isbn13(),
            'total_copies' => $total,
            'available_copies' => $available,
            'status' => $available > 0,
        ];
    }
}
