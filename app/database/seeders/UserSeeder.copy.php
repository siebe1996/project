<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Bart',
            'last_name' => 'Delrue',
            'kills' => 0,
            'alive' => true,
            'weapon_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'first_name' => 'Joris',
            'last_name' => 'Maervoet',
            'kills' => 0,
            'alive' => true,
            'weapon_id' => 2,
            'target_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'first_name' => 'Pieter',
            'last_name' => 'Van Peteghem',
            'kills' => 0,
            'alive' => true,
            'weapon_id' => 2,
            'target_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'first_name' => 'Davy',
            'last_name' => 'De Winne',
            'kills' => 0,
            'alive' => true,
            'weapon_id' => 1,
            'target_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        /*$userIds = DB::table('users')->pluck('id')->all();
        DB::table('user_has_target')->insert([
            ['user_id' => $userIds[0], 'target_id' => $userIds[1]],
            ['user_id' => $userIds[1], 'target_id' => $userIds[2]],
            ['user_id' => $userIds[2], 'target_id' => $userIds[3]],
            ['user_id' => $userIds[3], 'target_id' => $userIds[0]],
            //['user_id' => $userIds[4], 'target_id' => $userIds[0]]
        ]);*/

        $faker = FakerFactory::create();
        $faker->seed(222);
        for ($i = 4; $i < 10; $i++) {
            DB::table('users')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'kills' => 0, //$faker->numberBetween(1, 5),
                'alive' => true, //$faker->boolean
                'weapon_id' => $faker->numberBetween(1, 10),
                'target_id' => $i,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        $firstUser = DB::table('users')->where('id', 1);
        $firstUser->update(['target_id' => 10]);

        $userIds = DB::table('users')->pluck('id')->all();
        for ($i = 0; $i < count($userIds); $i++){
            DB::table('game_user')->insert([
                ['game_id' => 1 , 'user_id' => $userIds[$i]],
            ]);
        }
        /*$userIds = DB::table('users')->pluck('id')->all();
        for ($i = 0; $i < count($userIds); $i++){
            if ($i < (count($userIds) - 1)){
                DB::table('user_has_target')->insert([
                    ['user_id' => $userIds[$i], 'target_id' => $userIds[$i+1]],
                ]);
            }
            else {
                DB::table('user_has_target')->insert([
                    ['user_id' => $userIds[$i], 'target_id' => $userIds[0]],
                ]);
            }
        }*/
    }
}
