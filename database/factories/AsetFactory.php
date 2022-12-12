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
            'kode_aset' => $this->faker->unique()->text($maxNbChars = 7),
            'kode_jurusan' => mt_rand(1, 5),
            'id_ruangan' => mt_rand(1, 3),
            'id_jenis' => mt_rand(1, 2),
            'nama_aset' => $this->faker->text($maxNbChars = 20),
            'tahun_pengadaan' => $this->faker->year(),
            'nup' => $this->faker->randomDigit(1),
            'merk_type' => $this->faker->text($maxNbChars = 10),
            'jumlah' => $this->faker->randomDigit(1),
            'nilai_barang' => $this->faker->randomDigit(1),
            'id_kondisi' => mt_rand(1, 3),
            'keterangan' => $this->faker->text($maxNbChars = 20),
            'foto_aset' => 'foto-aset/default.png',
        ];
    }
}
