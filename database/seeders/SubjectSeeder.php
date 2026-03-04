<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Get classes first
        $class10A = SchoolClass::where('name', 'Class 10')->where('section', 'A')->first();
        $class9A = SchoolClass::where('name', 'Class 9')->where('section', 'A')->first();
        $class8A = SchoolClass::where('name', 'Class 8')->where('section', 'A')->first();
        
        $teacher = User::where('email', 'teacher@demo.com')->first();

        // Create subjects for Class 10-A
        if ($class10A) {
            $subjects10A = [
                ['name' => 'Mathematics', 'code' => 'MATH-10A'],
                ['name' => 'Physics', 'code' => 'PHY-10A'],
                ['name' => 'Chemistry', 'code' => 'CHEM-10A'],
                ['name' => 'English', 'code' => 'ENG-10A'],
                ['name' => 'Urdu', 'code' => 'URD-10A'],
            ];

            foreach ($subjects10A as $subject) {
                Subject::updateOrCreate(
                    ['school_class_id' => $class10A->id, 'code' => $subject['code']],
                    [
                        'name' => $subject['name'],
                        'code' => $subject['code'],
                        'school_class_id' => $class10A->id,
                        'teacher_id' => $teacher ? $teacher->id : null,
                    ]
                );
            }
        }

        // Create subjects for Class 9-A
        if ($class9A) {
            $subjects9A = [
                ['name' => 'Mathematics', 'code' => 'MATH-9A'],
                ['name' => 'Physics', 'code' => 'PHY-9A'],
                ['name' => 'Chemistry', 'code' => 'CHEM-9A'],
                ['name' => 'English', 'code' => 'ENG-9A'],
                ['name' => 'Urdu', 'code' => 'URD-9A'],
            ];

            foreach ($subjects9A as $subject) {
                Subject::updateOrCreate(
                    ['school_class_id' => $class9A->id, 'code' => $subject['code']],
                    [
                        'name' => $subject['name'],
                        'code' => $subject['code'],
                        'school_class_id' => $class9A->id,
                        'teacher_id' => $teacher ? $teacher->id : null,
                    ]
                );
            }
        }

        // Create subjects for Class 8-A
        if ($class8A) {
            $subjects8A = [
                ['name' => 'Mathematics', 'code' => 'MATH-8A'],
                ['name' => 'English', 'code' => 'ENG-8A'],
                ['name' => 'Urdu', 'code' => 'URD-8A'],
                ['name' => 'History', 'code' => 'HIST-8A'],
                ['name' => 'Geography', 'code' => 'GEOG-8A'],
            ];

            foreach ($subjects8A as $subject) {
                Subject::updateOrCreate(
                    ['school_class_id' => $class8A->id, 'code' => $subject['code']],
                    [
                        'name' => $subject['name'],
                        'code' => $subject['code'],
                        'school_class_id' => $class8A->id,
                        'teacher_id' => $teacher ? $teacher->id : null,
                    ]
                );
            }
        }
    }
}
