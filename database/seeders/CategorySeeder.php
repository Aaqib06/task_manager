<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $cat1 = Category::create(['name' => 'Work']);
        $cat2 = Category::create(['name' => 'Personal']);

        $cat1->subCategories()->createMany([
            ['name' => 'Meeting'],
            ['name' => 'Development'],
            ['name' => 'Design'],
        ]);

        $cat2->subCategories()->createMany([
            ['name' => 'Shopping'],
            ['name' => 'Health'],
            ['name' => 'Travel'],
        ]);
    }
    }

