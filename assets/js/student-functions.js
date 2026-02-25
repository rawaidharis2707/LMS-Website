const STUDENT_DATA_KEY = 'lms_students';

// --- Initialization ---
function initStudentStorage() {
    if (!localStorage.getItem(STUDENT_DATA_KEY)) {
        // Sample Data - Including the demo user "John Doe"
        // Added 'passedAllSubjects' and 'percentage' for auto-promotion logic
        const initialData = [
            {
                id: '2024-10A-015',
                name: 'John Doe',
                rollNumber: '2024-10A-015',
                class: '10-A',
                section: 'A',
                email: 'student@demo.com',
                percentage: 95,
                passedAllSubjects: true, // Eligible for Merit
                profile: {
                    phone: '+1 234 567 8900',
                    dob: '2008-05-15',
                    gender: 'Male',
                    bloodGroup: 'B+',
                    address: '123 Education Street, Knowledge City',
                    guardianName: 'Robert Doe',
                    guardianPhone: '+1 234 567 8901',
                    admissionDate: '2020-03-01'
                }
            },
            { id: '2024-10A-016', name: 'Jane Smith', rollNumber: '2024-10A-016', class: '10-A', section: 'A', percentage: 92, passedAllSubjects: true, email: 'jane@test.com' },
            { id: '2024-10A-017', name: 'Mike Johnson', rollNumber: '2024-10A-017', class: '10-A', section: 'A', percentage: 78, passedAllSubjects: true, email: 'mike@test.com' },
            { id: '2024-10A-018', name: 'Fail Student', rollNumber: '2024-10A-018', class: '10-A', section: 'A', percentage: 45, passedAllSubjects: false, email: 'fail@test.com' },
            { id: '2024-09A-001', name: 'Emily Davis', rollNumber: '2024-09A-001', class: '9-A', section: 'A', percentage: 88, passedAllSubjects: true, email: 'emily@test.com' },
            { id: '2024-09A-002', name: 'David Brown', rollNumber: '2024-09A-002', class: '9-A', section: 'A', percentage: 55, passedAllSubjects: false, email: 'david@test.com' },
            // Bulk data for testing sections
            { id: '2024-09A-003', name: 'Student High 1', rollNumber: '2024-09A-003', class: '9-A', section: 'A', percentage: 98, passedAllSubjects: true, email: 's1@test.com' },
            { id: '2024-09A-004', name: 'Student High 2', rollNumber: '2024-09A-004', class: '9-A', section: 'A', percentage: 97, passedAllSubjects: true, email: 's2@test.com' },
            { id: '2024-09A-005', name: 'Student Mid 1', rollNumber: '2024-09A-005', class: '9-A', section: 'A', percentage: 80, passedAllSubjects: true, email: 's3@test.com' }
        ];
        localStorage.setItem(STUDENT_DATA_KEY, JSON.stringify(initialData));
    }
}

// --- CRUD & Queries ---
function getAllStudents() {
    const data = localStorage.getItem(STUDENT_DATA_KEY);
    let students = data ? JSON.parse(data) : [];

    // Auto-repair corrupted class names (e.g., "11-A-A")
    let modified = false;
    students = students.map(s => {
        if (s.class && /-[A-Z]-[A-Z]$/.test(s.class)) {
            // Check if suffix repeats (e.g. -A-A)
            const parts = s.class.split('-');
            if (parts.length >= 3 && parts[parts.length - 1] === parts[parts.length - 2]) {
                s.class = parts.slice(0, parts.length - 1).join('-');
                modified = true;
            }
        }
        return s;
    });

    if (modified) {
        saveStudents(students);
    }

    return students;
}

function saveStudents(students) {
    localStorage.setItem(STUDENT_DATA_KEY, JSON.stringify(students));
}

function getStudentsByClass(className) {
    // Expects "10-A" purely or "10" and "A"?
    // In our system we use "10-A" as the class name usually.
    // Check if className contains section or just number.
    const all = getAllStudents();

    // Exact match "10-A"
    return all.filter(s => s.class === className);
}

// For promotion wizard which splits Class and Section potentially?
// Or maybe the input provides "10-A".
// Looking at admin/student-promotion.html, it has separate selects?
// Use loose matching if needed, but strict is better.

function getStudentByRoll(rollNumber) {
    const all = getAllStudents();
    return all.find(s => s.rollNumber === rollNumber);
}

function promoteStudents(studentIds, newClass, newSection) {
    const all = getAllStudents();
    let count = 0;

    // Construct new class string if needed, e.g. "11-A"
    // Assuming newClass arg is "11-A" or "11"

    // If copy of section is passed, we check if it's already in the class name to avoid 11-A-A
    let targetClass = newClass;
    if (newSection && !newClass.includes(newSection) && !newClass.endsWith(`-${newSection}`)) {
        targetClass = `${newClass}-${newSection}`;
    }

    all.forEach(student => {
        if (studentIds.includes(student.id) || studentIds.includes(student.rollNumber)) {
            student.class = targetClass;
            // Also update split fields if they exist
            if (newSection) student.section = newSection;

            count++;

            // Log activity?
            // Handled by UI usually
        }
    });

    saveStudents(all);
    return count;
}
