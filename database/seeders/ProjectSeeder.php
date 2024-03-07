<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Project::create([
                'name' => $faker->sentence,
                'members' => json_encode([$faker->name, $faker->name, $faker->name]),
                'start_date' => $faker->date(),
                'end_date' => $faker->date(),
                'project_owner' => $faker->name,
            ]);
        }
    }
}
