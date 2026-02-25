const TEACHER_ATTENDANCE_KEY = 'lms_teacher_attendance';

// --- Initialization ---
function initTeacherAttendance() {
    if (!localStorage.getItem(TEACHER_ATTENDANCE_KEY)) {
        // Sample Data
        const initialData = [
            { id: 1, teacherId: 'teacher@demo.com', name: 'Sarah Johnson', date: '2024-12-01', status: 'Present', checkIn: '07:45', checkOut: '14:30' },
            { id: 2, teacherId: 'teacher@demo.com', name: 'Sarah Johnson', date: '2024-12-02', status: 'Present', checkIn: '07:50', checkOut: '14:35' },
            { id: 3, teacherId: 'michael.chen@demo.com', name: 'Michael Chen', date: '2024-12-01', status: 'Absent', checkIn: '-', checkOut: '-' },
        ];
        localStorage.setItem(TEACHER_ATTENDANCE_KEY, JSON.stringify(initialData));
    }
}

// --- CRUD ---
function getAllTeacherAttendance() {
    const data = localStorage.getItem(TEACHER_ATTENDANCE_KEY);
    return data ? JSON.parse(data) : [];
}

function saveTeacherAttendance(records) {
    localStorage.setItem(TEACHER_ATTENDANCE_KEY, JSON.stringify(records));
}

function addTeacherAttendanceRecord(record) {
    const all = getAllTeacherAttendance();
    // Check for duplicate (same teacher, same date)
    const index = all.findIndex(a => a.teacherId === record.teacherId && a.date === record.date);

    const newRecord = {
        ...record,
        id: index >= 0 ? all[index].id : Date.now() + Math.random()
    };

    if (index >= 0) {
        all[index] = newRecord;
    } else {
        all.push(newRecord);
    }

    saveTeacherAttendance(all);
    return newRecord;
}

// --- Queries ---
function getTeacherMyAttendance(teacherId) {
    const all = getAllTeacherAttendance();
    // Assuming 'Sarah Johnson' uses ID 'T001' effectively or similar
    // We should match by Name or ID. Let's assume Name for demo if ID is hard to find.
    // Ideally user object has ID.
    return all.filter(a => a.teacherId === teacherId);
}

function getAttendanceByDate(date) {
    const all = getAllTeacherAttendance();
    return all.filter(a => a.date === date);
}

// --- Teacher List (Dynamic) ---
function getTeacherList() {
    const users = JSON.parse(localStorage.getItem('lms_users') || '[]');
    // Filter for teachers
    const teachers = users.filter(u => u.role === 'teacher').map(t => ({
        id: t.email, // Using email as ID for consistency
        name: t.name,
        subject: t.subject || 'General' // Default subject if not set
    }));
    return teachers;
}
function exportAttendanceToExcel() {
    const all = getAllTeacherAttendance();
    if (all.length === 0) return alert("No attendance records found to export.");

    let csv = "Date,Teacher ID,Name,Status,Check In,Check Out\n";
    all.forEach(a => {
        csv += `${a.date},${a.teacherId},"${a.name}",${a.status},${a.checkIn},${a.checkOut}\n`;
    });

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    link.setAttribute("download", `teacher_attendance_${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Global Export
window.getAllTeacherAttendance = getAllTeacherAttendance;
window.getAttendanceByDate = getAttendanceByDate;
window.exportAttendanceToExcel = exportAttendanceToExcel;
