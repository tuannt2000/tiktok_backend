<?php

namespace Database\Seeders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        DB::table('languages')->insert([
            [
                'code' => 'vi',
                'title' => 'Tiếng Việt (Việt Nam)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'ar',
                'title' => 'العربية',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'bn-IN',
                'title' => 'বাঙ্গালি (ভারত)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'ceb-PH',
                'title' => 'Cebuano (Pilipinas)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'cs-CZ',
                'title' => 'Čeština (Česká republika)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'de-DE',
                'title' => 'Deutsch',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'el-GR',
                'title' => 'Ελληνικά (Ελλάδα)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'en',
                'title' => 'English',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'es',
                'title' => 'Español',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'fi-FI',
                'title' => 'Suomi (Suomi)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'fil-PH',
                'title' => 'Filipino (Pilipinas)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'fr',
                'title' => 'Français',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'he-IL',
                'title' => 'עברית (ישראל)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'hi-IN',
                'title' => 'हिंदी',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'hu-HU',
                'title' => 'Magyar (Magyarország)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'id-ID',
                'title' => 'Bahasa Indonesia (Indonesia)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'it-IT',
                'title' => 'Italiano (Italia)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'ja-JP',
                'title' => '日本語（日本）',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'jv-ID',
                'title' => 'Basa Jawa (Indonesia)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'km-KH',
                'title' => 'ខ្មែរ (កម្ពុជា)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'ko-KR',
                'title' => '한국어 (대한민국)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'ms-MY',
                'title' => 'Bahasa Melayu (Malaysia)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'my-MM',
                'title' => 'မြန်မာ (မြန်မာ)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'nl-NL',
                'title' => 'Nederlands (Nederland)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'pl-PL',
                'title' => 'Polski (Polska)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'pt-BR',
                'title' => 'Português (Brasil)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'ro-RO',
                'title' => 'Română (Romania)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'ru-RU',
                'title' => 'Русский (Россия)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'sv-SE',
                'title' => 'Svenska (Sverige)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'th-TH',
                'title' => 'ไทย (ไทย)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'tr-TR',
                'title' => 'Türkçe (Türkiye)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'uk-UA',
                'title' => 'Українська (Україна)',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
            [
                'code' => 'ur',
                'title' => 'اردو',
                'created_at' => $now,
                'updated_at' =>  $now,
            ],
        ]);
    }
}
