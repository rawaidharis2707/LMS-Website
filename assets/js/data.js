// =====================================================
// Mock Data for EduPro LMS
// =====================================================

// Shared Function: Toggle Sidebar
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
    document.querySelector('.main-content').classList.toggle('active');
}

// Student Mock Data
const studentData = {
    profile: {
        name: 'John Doe',
        rollNumber: '2024-10A-015',
        class: 'Class 10',
        section: 'A',
        email: 'john.doe@example.com',
        phone: '+1 234 567 8900',
        dob: '2008-05-15',
        gender: 'Male',
        bloodGroup: 'B+',
        address: '123 Education Street, Knowledge City, State 12345',
        guardianName: 'Robert Doe',
        guardianPhone: '+1 234 567 8901',
        admissionDate: '2020-03-01'
    },
    subjects: [
        { code: 'MTH101', name: 'Mathematics', teacher: 'Mr. Smith', attendance: 95, grade: 'A' },
        { code: 'PHY101', name: 'Physics', teacher: 'Mrs. Johnson', attendance: 88, grade: 'B+' },
        { code: 'CHM101', name: 'Chemistry', teacher: 'Mr. Brown', attendance: 92, grade: 'A-' },
        { code: 'ENG101', name: 'English', teacher: 'Ms. Davis', attendance: 98, grade: 'A' },
        { code: 'CSC101', name: 'Computer Science', teacher: 'Mr. Wilson', attendance: 90, grade: 'A' }
    ],
    attendance: {
        total: 150,
        present: 138,
        absent: 8,
        late: 4,
        history: [
            { date: '2024-12-01', status: 'Present', time: '07:55 AM' },
            { date: '2024-12-02', status: 'Present', time: '08:00 AM' },
            { date: '2024-12-03', status: 'Late', time: '08:15 AM' },
            { date: '2024-12-04', status: 'Present', time: '07:50 AM' },
            { date: '2024-12-05', status: 'Absent', time: '-' }
        ]
    },
    results: [
        { exam: 'Mid Term 2024', date: '2024-10-15', totalMarks: 500, obtainedMarks: 425, percentage: 85, grade: 'A' },
        { exam: 'Final Term 2023', date: '2023-12-20', totalMarks: 500, obtainedMarks: 410, percentage: 82, grade: 'A-' }
    ],
    timetable: {
        monday: [
            { time: '08:00 - 09:00', subject: 'Mathematics', room: 'Room 101' },
            { time: '09:00 - 10:00', subject: 'Physics', room: 'Lab 1' }
        ],
        tuesday: [
            { time: '08:00 - 09:00', subject: 'English', room: 'Room 102' },
            { time: '09:00 - 10:00', subject: 'Chemistry', room: 'Lab 2' }
        ],
        // ... more days
    },
    fees: {
        totalFees: 5000, // Year to date
        paidAmount: 4500,
        pendingAmount: 500,
        fine: 0,
        vouchers: [
            // Legacy static vouchers if needed, but we now use dynamic ones
        ]
    }
};


// Teacher Mock Data
const teacherData = {
    profile: {
        id: 'TCH-001',
        name: 'Mr. Sarah Smith',
        subject: 'Mathematics',
        email: 'sarah.smith@edupro.com',
        phone: '+1 987 654 3210',
        qualification: 'M.Sc. Mathematics, B.Ed',
        experience: '8 Years',
        joiningDate: '2016-08-01'
    },
    classes: [
        { name: 'Class 10-A', subject: 'Mathematics', students: 35, time: '08:00 AM' },
        { name: 'Class 9-B', subject: 'Mathematics', students: 32, time: '10:00 AM' },
        { name: 'Class 11-A', subject: 'Applied Math', students: 28, time: '12:00 PM' }
    ],
    schedule: [
        { day: 'Monday', time: '08:00 AM', class: '10-A', room: '101' },
        { day: 'Monday', time: '10:00 AM', class: '9-B', room: '102' },
        // ...
    ]
};

// Toggle sidebar event listener
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }
});
