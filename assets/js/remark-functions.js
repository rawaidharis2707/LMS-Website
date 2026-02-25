
const REMARKS_STORAGE_KEY = 'lms_remarks';

// Initialize
function initRemarkStorage() {
    if (!localStorage.getItem(REMARKS_STORAGE_KEY)) {
        const defaults = [
            {
                id: 170000001,
                studentId: 'ST001',
                studentName: 'John Doe',
                class: '10-A',
                type: 'Positive',
                text: 'Excellent performance in recent test.',
                teacher: 'Sarah Johnson',
                date: new Date(Date.now() - 86400000 * 2).toISOString() // 2 days ago
            }
        ];
        localStorage.setItem(REMARKS_STORAGE_KEY, JSON.stringify(defaults));
    }
}

// Get all remarks
function getAllRemarks() {
    initRemarkStorage();
    return JSON.parse(localStorage.getItem(REMARKS_STORAGE_KEY) || '[]');
}

// Get remarks for specific student
function getStudentRemarks(studentId) {
    const all = getAllRemarks();
    // Match by ID or Name (fuzzy for demo)
    return all.filter(r => r.studentId === studentId || r.studentName === studentId);
}

// Add Remark
function addRemark(data) {
    const list = getAllRemarks();
    const newRemark = {
        id: Date.now(),
        studentId: data.studentId, // data.studentId should be passed
        studentName: data.studentName,
        class: data.class || 'Unknown',
        type: data.type,
        text: data.text,
        teacher: data.teacher,
        date: new Date().toISOString()
    };
    list.unshift(newRemark);
    localStorage.setItem(REMARKS_STORAGE_KEY, JSON.stringify(list));
    return newRemark;
}
