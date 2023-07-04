<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MusicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        DB::table('musics')->insert([
            [
                'title' => 'Yêu Đơn Phương Là Gì (MEE Remix) - Mee Media & h0n',
                'link' => 'Yêu-Đơn-Phương-Là-Gì-MEE-Remix',
                'uses_count' => 150,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'title' => 'Về Nghe Mẹ Ru - NSND Bach Tuyet & Hứa Kim Tuyền & 14 Casper & Hoàng Dũng',
                'link' => 'Về-Nghe-Mẹ-Ru',
                'uses_count' => 45,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'title' => 'Thiên Thần Tình Yêu - RICKY STAR',
                'link' => 'Thiên-Thần-Tình-Yêu',
                'uses_count' => 70,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'title' => 'Tình Đã Đầy Một Tim - Huyền Tâm Môn',
                'link' => 'Tình-Đã-Đầy-Một-Tim',
                'uses_count' => 68,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'title' => 'Thằng Hầu (Thái Hoàng Remix) [Short Version] - Dunghoangpham',
                'link' => 'Thằng-Hầu-Thái-Hoàng-Remix',
                'uses_count' => 138,
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
        ]);
    }
}
