<?php

use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = [];
        $faker = Faker\Factory::create();
        for ($i=0; $i < 100; $i++) { 
        	array_push($books, [
    			'name' => $faker->name,
    			'feature_image' => $faker->imageUrl(600, 400),
    			'cate_id' => rand(1, 6),
    			'price' => rand(1, 2000),
    			'description' => $faker->realText(200, 2),
    			'star' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 5)
        	]);
        }
        DB::table('books')->insert($books);
    }
}
