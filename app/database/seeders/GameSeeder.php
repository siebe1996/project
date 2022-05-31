<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            'title' => 'ict',
            'active' => true,
            'start_date' => new Carbon('2016-01-23 11:53:20'),
            'end_date' => new Carbon('2023-01-23 11:53:20'),
            'weapon_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('games')->insert([
            'title' => 'elo',
            'active' => false,
            'start_date' => new Carbon('2023-01-23 11:53:20'),
            'end_date' => new Carbon('2024-01-23 11:53:20'),
            'weapon_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('games')->insert([
            'title' => 'chemie',
            'active' => false,
            'start_date' => new Carbon('2016-01-23 11:53:20'),
            'end_date' => new Carbon('2023-01-23 11:53:20'),
            'weapon_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('games')->insert([
            'title' => 'LTT',
            'active' => false,
            'start_date' => new Carbon('2016-01-23 11:53:20'),
            'end_date' => new Carbon('2020-01-23 11:53:20'),
            'weapon_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('games')->insert([
            'title' => 'youtube',
            'active' => false,
            'start_date' => Carbon::now(),
            'weapon_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        /*
        $faker = FakerFactory::create();
        $faker->seed(222);
        for ($i = 0; $i < 6; $i++) {
            DB::table('users')->insert([
                'active' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }*/
    }
}
