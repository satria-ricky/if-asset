<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_jurusan' => mt_rand(1, 3),
            'nama_ruangan' => $this->faker->name(),
            'foto_ruangan' => 'foto-ruangan/default.jpg'
        ];
    }
}
