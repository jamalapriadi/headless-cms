<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $users = User::all();

        $titles = [
            'Getting Started with Laravel 12',
            'Mastering React for Beginners',
            'Introduction to DevOps and CI/CD',
            'Top 10 VSCode Extensions in 2025',
            'What’s New in PHP 8.3',
            'Docker for Local Development',
            'Secure Your Laravel App',
            'How to Use Git Effectively',
            'Best Practices for RESTful APIs',
            'Deploying to Vercel with Laravel',
            'Exploring Astro for Static Sites',
            'Build a Blog with TALL Stack',
            'Open Source Tools You Should Know',
            'Intro to TypeScript for JavaScript Devs',
            'Understanding OAuth2 and Laravel Passport',
            'Scaling Laravel Applications on AWS',
            'Laravel Livewire vs Inertia.js',
            'How AI Is Changing Programming',
            'Getting Started with Alpine.js',
            'Tips for Writing Clean Code in PHP',
        ];

        foreach ($titles as $title) {
            $slug = Str::slug($title);
            $content = 'This article discusses ' . strtolower($title) . ' in a concise and practical way.';

            $post = Post::firstOrCreate([
                'slug' => $slug,
            ], [
                'title' => $title,
                'slug' => $slug,
                'short_description' => $content,
                'content' => $content,
                'status' => 'published',
                'user_id' => $users->random()->id,
                'published_at' => now()
                    ->setTimestamp(rand(strtotime('2024-01-01'), strtotime(date('Y-m-d')))),
                'created_at' => now()
                    ->setTimestamp(rand(strtotime('2024-01-01'), strtotime(date('Y-m-d'))))
            ]);

            // Attach 1–2 random categories
            $randomCategoryIds = $categories->random(rand(1, 2))->pluck('id')->toArray();
            $post->categories()->sync($randomCategoryIds);
        }
    }
}
