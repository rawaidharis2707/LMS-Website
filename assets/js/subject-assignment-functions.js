const SUBJECT_ASSIGNMENT_KEY = 'lms_subject_assignments';

// --- Initialization ---
function initSubjectAssignments() {
    if (!localStorage.getItem(SUBJECT_ASSIGNMENT_KEY)) {
        // Sample Data
        const initialData = [
            { id: 1, teacherId: 'T001', teacherName: 'Sarah Johnson', subject: 'Mathematics', class: '10-A' },
            { id: 2, teacherId: 'T001', teacherName: 'Sarah Johnson', subject: 'Mathematics', class: '10-B' },
            { id: 3, teacherId: 'T001', teacherName: 'Sarah Johnson', subject: 'Mathematics', class: '9-A' },
            { id: 4, teacherId: 'T002', teacherName: 'Michael Chen', subject: 'Physics', class: '10-A' },
            { id: 5, teacherId: 'T002', teacherName: 'Michael Chen', subject: 'Physics', class: '10-B' }
        ];
        localStorage.setItem(SUBJECT_ASSIGNMENT_KEY, JSON.stringify(initialData));
    }
}

// --- CRUD ---
function getAllAssignments() {
    const data = localStorage.getItem(SUBJECT_ASSIGNMENT_KEY);
    return data ? JSON.parse(data) : [];
}

function saveAssignments(records) {
    localStorage.setItem(SUBJECT_ASSIGNMENT_KEY, JSON.stringify(records));
}

function assignSubject(teacherId, teacherName, subject, className) {
    const all = getAllAssignments();

    // Check if duplicate assignment exists
    const exists = all.some(a =>
        a.teacherId === teacherId &&
        a.subject === subject &&
        a.class === className
    );

    if (exists) return { success: false, message: 'Assignment already exists' };

    const newRecord = {
        id: Date.now() + Math.random(),
        teacherId,
        teacherName,
        subject,
        class: className
    };

    all.push(newRecord);
    saveAssignments(all);
    return { success: true, message: 'Subject assigned successfully' };
}

function removeAssignment(id) {
    const all = getAllAssignments();
    const updated = all.filter(a => a.id !== id);
    saveAssignments(updated);
}

// --- Queries ---
function getTeacherAssignments(teacherId) {
    const all = getAllAssignments();
    // Assuming 'Sarah Johnson' might be mapped to 'T001' or user ID is used directly.
    // We filter by teacherId.
    return all.filter(a => a.teacherId === teacherId);
}

function getUniqueTeacherSubjects(teacherId) {
    const assignments = getTeacherAssignments(teacherId);
    const subjects = [...new Set(assignments.map(a => a.subject))];
    return subjects;
}

// Helper to populate a select element with assigned subjects only
// If lock is true, and only 1 subject, it locks it. 
// If multiple, allows selection.
// If none, showing "No Subject Assigned".
function populateRestrictedSubjectSelect(selectElement, teacherId, defaultSelectText = 'Choose subject...') {
    const subjects = getUniqueTeacherSubjects(teacherId);
    selectElement.innerHTML = '';

    if (subjects.length === 0) {
        const opt = document.createElement('option');
        opt.value = "";
        opt.textContent = "No Assigned Subjects";
        selectElement.appendChild(opt);
        selectElement.disabled = true;
        return;
    }

    if (subjects.length === 1) {
        const opt = document.createElement('option');
        opt.value = subjects[0];
        opt.textContent = subjects[0];
        opt.selected = true;
        selectElement.appendChild(opt);
        selectElement.disabled = true; // Strict lock
    } else {
        // Multiple subjects assigned
        const defaultOpt = document.createElement('option');
        defaultOpt.value = "";
        defaultOpt.textContent = defaultSelectText;
        selectElement.appendChild(defaultOpt);

        subjects.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub;
            opt.textContent = sub;
            selectElement.appendChild(opt);
        });
    }
}
