const ATTENDANCE_STORAGE_KEY = 'lms_attendance';

// --- Initialization ---
function initAttendanceStorage() {
    if (!localStorage.getItem(ATTENDANCE_STORAGE_KEY)) {
        // Sample Data
        const initialData = [
            { id: 1, date: '2024-12-01', class: '10-A', subject: 'Mathematics', studentId: '2024-10A-015', studentName: 'John Doe', status: 'Present' },
            { id: 2, date: '2024-12-01', class: '10-A', subject: 'Physics', studentId: '2024-10A-015', studentName: 'John Doe', status: 'Absent' },
            { id: 3, date: '2024-12-02', class: '10-A', subject: 'Mathematics', studentId: '2024-10A-015', studentName: 'John Doe', status: 'Present' },
            { id: 4, date: '2024-12-01', class: '10-A', subject: 'Mathematics', studentId: '2024-10A-016', studentName: 'Jane Smith', status: 'Absent' },
        ];
        localStorage.setItem(ATTENDANCE_STORAGE_KEY, JSON.stringify(initialData));
    }
}

// --- Mock Students ---
function getStudentsByClass(className) {
    // In a real app, this comes from a database.
    const students = {
        '10-A': [
            { id: '2024-10A-015', name: 'John Doe', roll: '2024-10A-015' },
            { id: '2024-10A-016', name: 'Jane Smith', roll: '2024-10A-016' },
            { id: '2024-10A-017', name: 'Mike Ross', roll: '2024-10A-017' },
            { id: '2024-10A-018', name: 'Rachel Zane', roll: '2024-10A-018' },
            { id: '2024-10A-019', name: 'Harvey Specter', roll: '2024-10A-019' }
        ],
        '10-B': [
            { id: '2024-10B-001', name: 'Louis Litt', roll: '2024-10B-001' },
            { id: '2024-10B-002', name: 'Donna Paulsen', roll: '2024-10B-002' }
        ],
        '9-A': [
            { id: '2024-09A-001', name: 'Jessica Pearson', roll: '2024-09A-001' }
        ]
    };
    return students[className] || [];
}

// --- CRUD ---
function getAllAttendance() {
    const data = localStorage.getItem(ATTENDANCE_STORAGE_KEY);
    return data ? JSON.parse(data) : [];
}

function saveAttendanceBatch(records) {
    const list = getAllAttendance();
    // Remove existing records for same Class+Subject+Date to avoid duplicates if re-submitting
    // Actually, filtering them out is safer
    const newRecords = records.map(r => ({
        ...r,
        id: Date.now() + Math.random()
    }));

    // Simple append for now
    const updatedList = list.concat(newRecords);
    localStorage.setItem(ATTENDANCE_STORAGE_KEY, JSON.stringify(updatedList));
}

function getStudentAttendance(studentId) {
    const list = getAllAttendance();
    // Default to 'John Doe' (S101) if no ID provided (simulating current user)
    // In a real app, we check the logged-in user.
    // For this frontend demo, we'll assume the student viewing is S101 if not specified.
    const targetId = studentId || 'S101';
    return list.filter(r => r.studentId === targetId);
}
