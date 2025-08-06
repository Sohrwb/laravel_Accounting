<?php


namespace Database\Seeders;

use App\Models\Point;
use Illuminate\Database\Seeder;

class PointsTableSeeder extends Seeder
{
    public function run()
    {
        Point::create([
            'user_id' => 1,
            'points' => 1250000 // 2.5 برابر سرمایه بالا
        ]);
    }
}
