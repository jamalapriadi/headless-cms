<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'English',
                'locale' => 'EN',
                'is_default' => true,
            ],
            [
                'name' => 'Indonesian',
                'locale' => 'ID',
                'is_default' => false,
            ],
        ];

        foreach ($languages as $lang) {
            Language::firstOrCreate(
                ['locale' => $lang['locale']],
                $lang
            );
        }
    }
}
