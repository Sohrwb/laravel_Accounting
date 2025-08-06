<?php


namespace Database\Seeders;

use App\Models\PointTransfer;
use Illuminate\Database\Seeder;

class PointTransfersTableSeeder extends Seeder
{
    public function run()
    {
        PointTransfer::create([
            'from_user_id' => 1,
            'to_user_id' => 2,
            'amount' => 300000
        ]);
    }
}
