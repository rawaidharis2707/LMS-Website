const MARKS_STORAGE_KEY = 'lms_marks';

// --- Initialization ---
function initMarksStorage() {
    if (!localStorage.getItem(MARKS_STORAGE_KEY)) {
        // Sample Data for Demo
        const initialData = [
            {
                id: 1,
                studentId: '2024-10A-015',
                studentName: 'John Doe',
                class: '10-A',
                subject: 'Mathematics',
                examType: 'Mid-Term',
                marksObtained: 85,
                totalMarks: 100,
                grade: 'A',
                date: '2024-10-15'
            },
            {
                id: 2,
                studentId: '2024-10A-015',
                studentName: 'John Doe',
                class: '10-A',
                subject: 'Physics',
                examType: 'Mid-Term',
                marksObtained: 78,
                totalMarks: 100,
                grade: 'B+',
                date: '2024-10-18'
            }
        ];
        localStorage.setItem(MARKS_STORAGE_KEY, JSON.stringify(initialData));
    }
}

// --- CRUD ---
function getAllMarks() {
    const data = localStorage.getItem(MARKS_STORAGE_KEY);
    return data ? JSON.parse(data) : [];
}

function saveMarks(marks) {
    localStorage.setItem(MARKS_STORAGE_KEY, JSON.stringify(marks));
}

function addMark(markData) {
    const marks = getAllMarks();
    // Check if mark already exists for this exam/student/subject
    const existingIndex = marks.findIndex(m =>
        m.studentId === markData.studentId &&
        m.examType === markData.examType &&
        m.subject === markData.subject
    );

    const newMark = {
        ...markData,
        id: existingIndex >= 0 ? marks[existingIndex].id : Date.now() + Math.random(),
        grade: calculateGrade(markData.marksObtained, markData.totalMarks),
        date: new Date().toISOString().split('T')[0]
    };

    if (existingIndex >= 0) {
        marks[existingIndex] = newMark;
    } else {
        marks.push(newMark);
    }

    saveMarks(marks);
    return newMark;
}

// Batch save from teacher input
function saveBulkMarks(marksArray) {
    const allMarks = getAllMarks();
    let count = 0;

    marksArray.forEach(newItem => {
        const existingIndex = allMarks.findIndex(m =>
            m.studentId === newItem.studentId &&
            m.examType === newItem.examType &&
            m.subject === newItem.subject
        );

        const processedItem = {
            ...newItem,
            id: existingIndex >= 0 ? allMarks[existingIndex].id : Date.now() + Math.random(),
            grade: calculateGrade(newItem.marksObtained, newItem.totalMarks),
            date: new Date().toISOString().split('T')[0]
        };

        if (existingIndex >= 0) {
            allMarks[existingIndex] = processedItem;
        } else {
            allMarks.push(processedItem);
            count++;
        }
    });

    saveMarks(allMarks);
    return count;
}

// --- Queries ---
function getStudentMarks(studentId) {
    const all = getAllMarks();
    return all.filter(m => String(m.studentId).trim().toLowerCase() === String(studentId).trim().toLowerCase());
}

// Group marks by Exam Type for Student View
function getStudentResultsGrouped(studentId) {
    const marks = getStudentMarks(studentId);
    const groups = {};

    marks.forEach(mark => {
        if (!groups[mark.examType]) {
            groups[mark.examType] = {
                exam: mark.examType,
                date: mark.date,
                subjects: [],
                totalObtained: 0,
                totalMax: 0
            };
        }
        groups[mark.examType].subjects.push({
            name: mark.subject,
            marks: mark.marksObtained,
            maxMarks: mark.totalMarks,
            grade: mark.grade
        });
        groups[mark.examType].totalObtained += parseFloat(mark.marksObtained);
        groups[mark.examType].totalMax += parseFloat(mark.totalMarks);
    });

    // Convert object to array and calculate overall stats
    return Object.values(groups).map(g => {
        return {
            ...g,
            percentage: g.totalMax > 0 ? (g.totalObtained / g.totalMax) * 100 : 0,
            grade: calculateGrade(g.totalObtained, g.totalMax),
            rank: 'N/A' // Rank calculation is complex without all students data, skip for now
        };
    });
}

// --- Helpers ---
function calculateGrade(obtained, total) {
    if (total === 0) return 'N/A';
    const pct = (obtained / total) * 100;

    if (pct >= 90) return 'A+';
    if (pct >= 85) return 'A';
    if (pct >= 80) return 'A-';
    if (pct >= 75) return 'B+';
    if (pct >= 70) return 'B';
    if (pct >= 65) return 'B-';
    if (pct >= 60) return 'C+';
    if (pct >= 50) return 'C';
    if (pct >= 40) return 'D';
    return 'F';
}
