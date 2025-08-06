<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Seeder;

class FamiliesTableSeeder extends Seeder
{
    public function run()
    {
        Family::create(['name' => 'خانواده احمدی']);
        Family::create(['name' => 'خانواده رضایی']);
    }
}
