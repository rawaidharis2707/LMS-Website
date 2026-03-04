<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $classes = [
            ['name' => 'Class 1', 'section' => 'A', 'capacity' => 30, 'batch' => '2024', 'level' => 'Primary', 'group' => 'General'],
            ['name' => 'Class 2', 'section' => 'A', 'capacity' => 30, 'batch' => '2024', 'level' => 'Primary', 'group' => 'General'],
            ['name' => 'Class 3', 'section' => 'A', 'capacity' => 30, 'batch' => '2024', 'level' => 'Primary', 'group' => 'General'],
            ['name' => 'Class 4', 'section' => 'A', 'capacity' => 30, 'batch' => '2024', 'level' => 'Primary', 'group' => 'General'],
            ['name' => 'Class 5', 'section' => 'A', 'capacity' => 30, 'batch' => '2024', 'level' => 'Primary', 'group' => 'General'],
            ['name' => 'Class 6', 'section' => 'A', 'capacity' => 35, 'batch' => '2024', 'level' => 'Middle', 'group' => 'General'],
            ['name' => 'Class 7', 'section' => 'A', 'capacity' => 35, 'batch' => '2024', 'level' => 'Middle', 'group' => 'General'],
            ['name' => 'Class 8', 'section' => 'A', 'capacity' => 35, 'batch' => '2024', 'level' => 'Middle', 'group' => 'General'],
            ['name' => 'Class 9', 'section' => 'A', 'capacity' => 40, 'batch' => '2024', 'level' => 'Secondary', 'group' => 'Science'],
            ['name' => 'Class 9', 'section' => 'B', 'capacity' => 40, 'batch' => '2024', 'level' => 'Secondary', 'group' => 'Arts'],
            ['name' => 'Class 10', 'section' => 'A', 'capacity' => 40, 'batch' => '2024', 'level' => 'Secondary', 'group' => 'Science'],
            ['name' => 'Class 10', 'section' => 'B', 'capacity' => 40, 'batch' => '2024', 'level' => 'Secondary', 'group' => 'Arts'],
        ];

        foreach ($classes as $class) {
            SchoolClass::updateOrCreate(
                ['name' => $class['name'], 'section' => $class['section']],
                $class
            );
        }
    }
}
