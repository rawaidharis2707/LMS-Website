<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SchoolClassSeeder::class,
            SubjectSeeder::class,
            AnnouncementSeeder::class,
            AdmissionRequestSeeder::class,
        ]);

        // Student
        $student = User::updateOrCreate(['email' => 'student@demo.com'], [
            'name' => 'John Doe',
            'password' => Hash::make('password'),
            'role' => 'student',
            'enrolled_class' => 'Class 10-A',
            'roll_number' => '2024-10A-015',
        ]);

        // Assign student to class
        $class10A = \App\Models\SchoolClass::where('name', 'Class 10')->where('section', 'A')->first();
        if ($class10A) {
            $student->update(['school_class_id' => $class10A->id]);
        }

        // Teacher
        User::updateOrCreate(['email' => 'teacher@demo.com'], [
            'name' => 'Sarah Johnson',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Admin
        User::updateOrCreate(['email' => 'admin@demo.com'], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Super Admin
        User::updateOrCreate(['email' => 'superadmin@demo.com'], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);
    }
}
