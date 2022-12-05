<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(4)->create();
        \App\Models\Aset::factory(5)->create();
        // \App\Models\Ruangan::factory(3)->create();
        \App\Models\Sumber::factory(3)->create();
        // \App\Models\Kondisi::factory(3)->create();
        DB::table('kondisis')->insert([
            [
                'nama_kondisi'    => 'Rusak'
            ],
            [
                'nama_kondisi'    => 'Baik'
            ]
        ]);

        DB::table('ruangans')->insert([
            [
                'nama_ruangan'    => 'Lab 1'
            ],
            [
                'nama_ruangan'    => 'Lab 2'
            ],
            [
                'nama_ruangan'    => 'Lab 3'
            ],
            [
                'nama_ruangan'    => 'Lab 4'
            ],
            [
                'nama_ruangan'    => 'Ruang D3-03'
            ],
            [
                'nama_ruangan'    => 'Ruang D4-03'
            ]
        ]);

        
    }
}
