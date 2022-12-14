<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KondisiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_kondisi' => $this->faker->name(),
            'icon_kondisi' => $this->faker->name()
        ];
    }
}
