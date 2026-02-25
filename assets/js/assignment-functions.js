
const ASSIGNMENT_STORAGE_KEY = 'lms_assignments';
const SUBMISSION_STORAGE_KEY = 'lms_submissions';

// --- Initialization ---
function initAssignmentStorage() {
    if (!localStorage.getItem(ASSIGNMENT_STORAGE_KEY)) {
        const initialAssignments = [
            {
                id: 1702200000001,
                title: "Algebra Chapter 5 Problems",
                description: "Complete exercises 5.1 to 5.3",
                class: "10-A",
                subject: "Mathematics",
                dueDate: "2024-12-15",
                maxMarks: 20,
                teacher: "Sarah Johnson",
                file: null
            },
            {
                id: 1702200000002,
                title: "Physics Lab Report",
                description: "Submit report for the pendulum experiment",
                class: "10-A",
                subject: "Physics",
                dueDate: "2024-12-20",
                maxMarks: 15,
                teacher: "David Wilson",
                file: null
            }
        ];
        localStorage.setItem(ASSIGNMENT_STORAGE_KEY, JSON.stringify(initialAssignments));
    }
    if (!localStorage.getItem(SUBMISSION_STORAGE_KEY)) {
        localStorage.setItem(SUBMISSION_STORAGE_KEY, JSON.stringify([]));
    }
}

// --- Assignments CRUD ---
function getAllAssignments() {
    const data = localStorage.getItem(ASSIGNMENT_STORAGE_KEY);
    return data ? JSON.parse(data) : [];
}

function saveAssignment(data) {
    const list = getAllAssignments();
    const newAssignment = {
        id: Date.now(),
        title: data.title,
        description: data.description,
        class: data.class,
        subject: data.subject,
        dueDate: data.dueDate,
        maxMarks: parseInt(data.maxMarks) || 0,
        teacher: data.teacher || 'Unknown',
        file: data.file || null, // In a real app this would be a URL
        createdAt: new Date().toISOString()
    };
    list.unshift(newAssignment);
    localStorage.setItem(ASSIGNMENT_STORAGE_KEY, JSON.stringify(list));
    return newAssignment;
}

function deleteAssignment(id) {
    let list = getAllAssignments();
    list = list.filter(a => a.id != id);
    localStorage.setItem(ASSIGNMENT_STORAGE_KEY, JSON.stringify(list));
}

function getAssignmentsForClass(className) {
    const list = getAllAssignments();
    if (!className) return list;
    return list.filter(a => a.class === className);
}

// --- Submissions ---
function getAllSubmissions() {
    const data = localStorage.getItem(SUBMISSION_STORAGE_KEY);
    return data ? JSON.parse(data) : [];
}

function submitAssignment(assignmentId, student, file) {
    const list = getAllSubmissions();
    const sId = student.rollNumber || student.id;
    const existing = list.findIndex(s => s.assignmentId == assignmentId && s.studentId == sId);

    const submission = {
        assignmentId: parseInt(assignmentId),
        studentId: sId,
        studentName: student.name,
        submittedAt: new Date().toISOString(),
        file: file ? file.name : 'assignment.pdf', // Mock content
        status: 'submitted',
        marks: null
    };

    if (existing !== -1) {
        list[existing] = submission; // Update existing
    } else {
        list.push(submission);
    }

    localStorage.setItem(SUBMISSION_STORAGE_KEY, JSON.stringify(list));
    return submission;
}

function getSubmissionsForAssignment(assignmentId) {
    const list = getAllSubmissions();
    return list.filter(s => s.assignmentId == assignmentId);
}

function getSubmissionStatus(assignmentId, studentId) {
    const list = getAllSubmissions();
    const sub = list.find(s => s.assignmentId == assignmentId && s.studentId == studentId);
    if (!sub) return 'pending';
    return sub.status; // 'submitted' or 'graded'
}

function gradeSubmission(assignmentId, studentId, marks) {
    const list = getAllSubmissions();
    const index = list.findIndex(s => s.assignmentId == assignmentId && s.studentId == studentId);
    if (index !== -1) {
        list[index].status = 'graded';
        list[index].marks = marks;
        localStorage.setItem(SUBMISSION_STORAGE_KEY, JSON.stringify(list));
        return true;
    }
    return false;
}
