<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        DB::table('tags')->insert([
            [
                'title' => 'suthatla',
                'link' => 'suthatla',
                'uses_count' => 100,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'title' => 'mackedoi',
                'link' => 'mackedoi',
                'uses_count' => 90,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'title' => 'sansangthaydoi',
                'link' => 'sansangthaydoi',
                'uses_count' => 60,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'title' => '7749hieuung',
                'link' => '7749hieuung',
                'uses_count' => 10,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'title' => 'genzlife',
                'link' => 'genzlife',
                'uses_count' => 18,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
        ]);
    }
}
