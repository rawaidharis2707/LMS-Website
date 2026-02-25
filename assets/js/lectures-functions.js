const LECTURES_STORAGE_KEY = 'lms_lectures';

// --- Initialization ---
function initLecturesStorage() {
    if (!localStorage.getItem(LECTURES_STORAGE_KEY)) {
        const initialLectures = [
            {
                id: 1702500000001,
                title: "Calculus: Limits and Continuity",
                class: "10-A",
                subject: "Mathematics",
                url: "https://www.youtube.com/embed/wuCPpM767DM", // Example math video
                teacher: "Sarah Johnson",
                uploadDate: "2024-12-10",
                duration: "45 mins"
            },
            {
                id: 1702500000002,
                title: "Introduction to Thermodynamics",
                class: "10-B",
                subject: "Physics",
                url: "https://www.youtube.com/embed/8N1BxHg9ow8", // Example physics video
                teacher: "Mark Smith",
                uploadDate: "2024-12-12",
                duration: "30 mins"
            }
        ];
        localStorage.setItem(LECTURES_STORAGE_KEY, JSON.stringify(initialLectures));
    }
}

// --- CRUD ---
function getAllLectures() {
    const data = localStorage.getItem(LECTURES_STORAGE_KEY);
    return data ? JSON.parse(data) : [];
}

function saveLecture(data) {
    const list = getAllLectures();
    const newLecture = {
        id: Date.now(),
        ...data
    };
    list.unshift(newLecture);
    localStorage.setItem(LECTURES_STORAGE_KEY, JSON.stringify(list));
    return newLecture;
}

function deleteLecture(id) {
    let list = getAllLectures();
    list = list.filter(l => l.id != id);
    localStorage.setItem(LECTURES_STORAGE_KEY, JSON.stringify(list));
}
