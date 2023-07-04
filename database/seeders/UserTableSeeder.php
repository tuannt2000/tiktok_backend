<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        // DB::table('users')->insert([
        //     [
        //         'email' => 'admin@gmail.com',
        //         'password' => Hash::make('12345678'),
        //         'role' => 'ADM',
        //         'social_provider' => 'ADM',
        //         'social_id' => 'ADM',
        //         'first_name' => 'Nguyễn Hữu',
        //         'last_name' => 'Tuấn',
        //         'nickname' => 'Tuấn Nguyễn',
        //         'phone' => '0337344408',
        //         'avatar' => null,
        //         'bio' => null,
        //         'birthday' => $now,
        //         'tick' => true,
        //         'created_at' => $now,
        //         'updated_at' =>  $now,
        //     ]
        // ]);

        $faker = \Faker\Factory::create();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $img = $faker->image(public_path('img\avatar'), 100, 100);
            $explode_img = explode('\\', $img);
            $img_path = '/img/avatar/' . $explode_img[array_key_last($explode_img)];

            DB::table('users')->insert([
                'email' => $faker->unique()->email,
                'password' => Hash::make('12345678'),
                'role' => 'USER',
                'social_provider' => 'normal',
                'social_id' => 0,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'nickname' => $firstName . ' ' . $lastName,
                'phone' => $faker->numerify('##########'),
                'avatar' => $img_path,
                'bio' => null,
                'birthday' => $now,
                'tick' => true,
                'created_at' => $now,
                'updated_at' =>  $now,
            ]);
        }
    }
}
