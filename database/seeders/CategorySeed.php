<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeed extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Technology',
            'Healthcare',
            'Finance',
            'Education',
            'Marketing',
            'Design',
            'Sales',
            'Customer Service',
            'Engineering',
            'Hospitality',
            'Retail',
            'Construction',
            'Transportation',
            'Media and Communication',
            'Science',
            'Research',
            'Human Resources',
            'Social Services',
            'Nonprofit',
            'Arts and Entertainment',
            'Food Services',
            'Real Estate',
            'Sports and Recreation',
            'Environmental',
            'Government',
            'Consulting',
            'Fashion',
            'Fitness',
            'Beauty and Wellness',
            'Event Planning',
            'Insurance',
            'Information Technology',
            'Telecommunications',
            'Pharmaceutical',
            'Automotive',
            'Aviation',
            'Agriculture',
            'E-commerce',
            'Cryptocurrency and Blockchain'
        ];

        foreach ($categories as $categorie) {
            Category::create(['name' => $categorie]);
        }
    }
}
