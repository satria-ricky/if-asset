<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        \App\Models\Jurusan::factory(3)->create();
        \App\Models\Ruangan::factory(3)->create();
        DB::table('users')->insert([
            [
                'nama_user' => 'nama admin',
                'level' => 1,
                'username' => 'admin',
                'password' => Hash::make('123')
            ],
            [
                'nama_user' => 'nama prodi',
                'level' => 2,
                'username' => 'prodi',
                'password' => Hash::make('123')
            ],
            [
                'nama_user' => 'nama mhs',
                'level' => 3,
                'username' => 'mhs',
                'password' => Hash::make('123')
            ],
            [
                'nama_user' => 'nama dsn',
                'level' => 4,
                'username' => 'dsn',
                'password' => Hash::make('123')
            ]
        ]);


        DB::table('kondisis')->insert([
            [
                'nama_kondisi'    => 'Rusak Ringan',
                'icon_kondisi'    => 'warning',
                'warna_kondisi'    => '#f8ac59'
            ],
            [
                'nama_kondisi'    => 'Rusak Berat',
                'icon_kondisi'    => 'danger',
                'warna_kondisi'    => '#ED5565'
            ],
            [
                'nama_kondisi'    => 'Baik',
                'icon_kondisi'    => 'success',
                'warna_kondisi'    => '#1c84c6'
            ]
        ]);

        DB::table('jenis_asets')->insert([
            [
                'nama_jenis'    => 'ATK',
                'warna_jenis'    => '#5ea832'
            ],
            [
                'nama_jenis'    => 'Elektronik',
                'warna_jenis'    => '#7f99ba'
            ]
        ]);
        
    }
}
