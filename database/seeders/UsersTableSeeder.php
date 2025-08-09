<?php


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {

        User::factory()->count(10)->create();
        User::create([
            'name' => 'علی احمدی',
            'email' => 'ali@example.com',
            'password' => Hash::make('123456'),
            'family_id' => 1
        ]);

        User::create([
            'name' => 'مینا احمدی',
            'email' => 'mina@example.com',
            'password' => Hash::make('123456'),
            'family_id' => 1
        ]);
    }
}
