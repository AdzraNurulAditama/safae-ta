<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), 
            'author' => $this->faker->name(), 
            'genre' => $this->faker->randomElement([
                'Pemrograman',
                'Novel',
                'Hobi',
                'Horror',
                'Romance',
                'Action'
            ]),
            'year' => $this->faker->numberBetween(1990, 2024),

          
            'description' => $this->faker->paragraphs(5, true),

            'image_path' => null, 
            'status' => $this->faker->randomElement([
                'pending',
                'approved',
                'rejected'
            ]),
        ];
    }
}
