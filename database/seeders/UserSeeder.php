<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Faizur Rahman',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make(12345678),
        ]);

        $faker=Factory::create();
        foreach(range(1,50) as $item){
            User::create([
                'name'=>$faker->name,
                'email'=>$faker->unique->email,
                'password'=>Hash::make(12345678),
            ]);
        }
    }
}
