<?php

namespace Database\Seeders;

use App\Models\Book;
use Faker\Factory;
use Illuminate\Database\Seeder;


class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Factory::create();
        foreach(range(1,50) as $item){
            Book::create([
                'user_id'=>rand(1,50),
                'title'=>substr($faker->realText,0,30),
                'author'=>$faker->name,
                'publisher'=>$faker->name,
                'edition'=>$faker->date,
                'pages'=>rand(200,400),
                'country'=>$faker->country,
                'image'=>$faker->imageUrl,

            ]);
        }
    }
}
