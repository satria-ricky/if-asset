<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        \App\Models\Aset::factory(5)->create();
        \App\Models\Ruangan::factory(3)->create();
        \App\Models\Sumber::factory(3)->create();
    }
}
