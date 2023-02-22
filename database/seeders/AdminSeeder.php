<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();

        DB::table('admins')->insert([
            'email' => 'caohung304@gmail.com',
            'name' => 'Admin',
            'password' => Hash::make('12345678'),
        ]);
    }
}
