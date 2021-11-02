<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "Test Client",
            'email' => "test.client@vitalcareprod.com",
            'password' => Hash::make("azerty123"),
            'phone_number' => "0770458632",
            'function' => "Opérateur Machine",
        ]);

        $user->Client()->create([

        ]);

        $user->assignRole('Client');
    }
}
