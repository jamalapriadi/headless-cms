<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Programming',
            'Web Development',
            'Mobile Development',
            'AI & Machine Learning',
            'Cybersecurity',
            'Cloud Computing',
            'Tech News',
            'Gadgets',
            'DevOps',
            'Open Source'
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate([
                'slug' => Str::slug($name),
            ], [
                'name' => $name
            ]);
        }
    }
}
