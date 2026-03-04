<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::where('email', 'admin@demo.com')->first();
        $superAdmin = User::where('email', 'superadmin@demo.com')->first();

        $announcements = [
            [
                'title' => 'Welcome to New Academic Year',
                'content' => 'We are excited to welcome all students to the new academic year 2024-2025. Classes will begin from Monday.',
                'target' => 'all',
                'target_value' => null,
                'priority' => 1,
                'author' => $superAdmin ? $superAdmin->id : 1,
            ],
            [
                'title' => 'Exam Schedule Announcement',
                'content' => 'Mid-term examinations will start from next month. Please prepare accordingly.',
                'target' => 'students',
                'target_value' => null,
                'priority' => 2,
                'author' => $admin ? $admin->id : 1,
            ],
            [
                'title' => 'Teachers Meeting',
                'content' => 'Monthly teachers meeting will be held on Friday at 3 PM in the conference room.',
                'target' => 'teachers',
                'target_value' => null,
                'priority' => 3,
                'author' => $admin ? $admin->id : 1,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::updateOrCreate(
                ['title' => $announcement['title']],
                $announcement
            );
        }
    }
}
