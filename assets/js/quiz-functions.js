
const QUIZ_STORAGE_KEY = 'lms_quizzes';
const QUIZ_RESULT_KEY = 'lms_quiz_results';

// --- Initialization ---
function initQuizStorage() {
    if (!localStorage.getItem(QUIZ_STORAGE_KEY)) {
        const initialQuizzes = [
            {
                id: 1702300000001,
                title: "Algebra Basics",
                class: "10-A",
                subject: "Mathematics",
                date: "2024-12-18",
                duration: 30,
                totalMarks: 2,
                teacher: "Sarah Johnson",
                questions: [
                    {
                        text: "What is 2x + 5 = 15?",
                        options: { A: "5", B: "10", C: "15", D: "20" },
                        correct: "A"
                    },
                    {
                        text: "Solve for y: y - 3 = 7",
                        options: { A: "4", B: "7", C: "10", D: "3" },
                        correct: "C"
                    }
                ]
            }
        ];
        localStorage.setItem(QUIZ_STORAGE_KEY, JSON.stringify(initialQuizzes));
    }
    if (!localStorage.getItem(QUIZ_RESULT_KEY)) {
        localStorage.setItem(QUIZ_RESULT_KEY, JSON.stringify([]));
    }
}

// --- CRUD ---
function getAllQuizzes() {
    const data = localStorage.getItem(QUIZ_STORAGE_KEY);
    return data ? JSON.parse(data) : [];
}

function saveQuiz(data) {
    const list = getAllQuizzes();
    const newQuiz = {
        id: Date.now(),
        ...data
    };
    list.unshift(newQuiz);
    localStorage.setItem(QUIZ_STORAGE_KEY, JSON.stringify(list));
    return newQuiz;
}

function deleteQuiz(id) {
    let list = getAllQuizzes();
    list = list.filter(q => q.id != id);
    localStorage.setItem(QUIZ_STORAGE_KEY, JSON.stringify(list));
}

// --- Results ---
function getAllQuizResults() {
    const data = localStorage.getItem(QUIZ_RESULT_KEY);
    return data ? JSON.parse(data) : [];
}

function submitQuizResult(quizId, student, score, total) {
    const list = getAllQuizResults();
    const result = {
        quizId: quizId,
        studentId: student.rollNumber || student.id,
        studentName: student.name,
        score: score,
        total: total,
        submittedAt: new Date().toISOString()
    };
    list.push(result);
    localStorage.setItem(QUIZ_RESULT_KEY, JSON.stringify(list));
    return result;
}

function getQuizResults(quizId) {
    const list = getAllQuizResults();
    return list.filter(r => r.quizId == quizId);
}

function getStudentQuizResult(quizId, studentId) {
    const list = getAllQuizResults();
    return list.find(r => r.quizId == quizId && r.studentId == studentId);
}
