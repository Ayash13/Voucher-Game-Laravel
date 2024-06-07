<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::create([
            'username' => 'Ayash',
            'email' => 'm.ayashal.f@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
