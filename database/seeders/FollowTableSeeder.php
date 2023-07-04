<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        DB::table('follows')->insert([
            [
                'user_id' => 1,
                'user_follower_id' => 2,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'user_id' => 1,
                'user_follower_id' => 5,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
        ]);
    }
}
