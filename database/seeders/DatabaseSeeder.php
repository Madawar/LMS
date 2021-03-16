<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Staff::factory(20)->create();

        $faker = Faker::create();
        \App\Models\Staff::factory()->create([
            'staff' => 'Dennis Wanyoike Kuria',
            'pno' => '695',
            'role'=>'staff',
            'department' => $faker->numberBetween(1, 4),
            'leave_days' => 30,
        ]);

        \App\Models\Staff::factory()->create([
            'staff' => 'Shadrack Nyumu',
            'pno' => '123',
            'department' => $faker->numberBetween(1, 4),
            'role' => 'hr',
            'leave_days' => 30,
        ]);


        DB::table('departments')->insert([
            'department' => 'Operations',
            'requires_reliever' => false,
            'number_of_relievers' => 2,
            'department_manager' => $faker->numberBetween(1, 50),
        ]);
        DB::table('departments')->insert([
            'department' => 'Passenger',
            'requires_reliever' => true,
            'number_of_relievers' => 2,
            'department_manager' => $faker->numberBetween(1, 50),
        ]);
        DB::table('departments')->insert([
            'department' => 'Security',
            'requires_reliever' => true,
            'number_of_relievers' => 2,
            'department_manager' => $faker->numberBetween(1, 50),
        ]);
        DB::table('departments')->insert([
            'department' => 'ICT',
            'requires_reliever' => true,
            'number_of_relievers' => 1,
            'department_manager' => $faker->numberBetween(1, 50),
        ]);
    }
}
