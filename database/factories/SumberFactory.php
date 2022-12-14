<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_sumber' => $this->faker->name(),
        ];
    }
}
