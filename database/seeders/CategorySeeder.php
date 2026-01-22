<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');
        for ($i = 0; $i < 5; $i++) {
            Category::create([
                'nama_category'=> $faker->sentence(2),
                'slug'=> $faker->slug(),
                'description' => $faker->paragraph(3),
                ]);
            }
      }
}
