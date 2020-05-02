<?php

use App\Part;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 30; $i++) {
            Part::create([
                'partnumber' => $faker->text(20),
                'model_id' => $faker->text(20),
                'machine_id' => $faker->text(20),
                'vendornumber' => $faker->text(25),
                'description' => $faker->sentence(2),
                'value' => $faker->text(25)               
            ]);
        }
    }
}
