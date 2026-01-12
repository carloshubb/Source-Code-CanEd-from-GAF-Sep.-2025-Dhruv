<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Canadian Edu',
            'email' => 'admin@email.com',
            'password' => bcrypt('Xelent123'),
        ]);
    }
}
