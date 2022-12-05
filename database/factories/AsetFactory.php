<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AsetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_ruangan' => mt_rand(1, 3),
            'kode_aset' => $this->faker->unique()->text($maxNbChars = 7),
            'id_sumber' => mt_rand(1, 3),
            'nama' => $this->faker->text($maxNbChars = 20),
            'jumlah' => $this->faker->randomDigit(1),
            'lokasi' => $this->faker->text($maxNbChars = 20),
            'kondisi' => mt_rand(1, 3),
            'tahun_pengadaan' => $this->faker->year(),
            'foto_aset' => 'foto-aset/default.png',
        ];
    }
}
