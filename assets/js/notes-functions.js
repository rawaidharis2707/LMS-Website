const NOTES_STORAGE_KEY = 'lms_notes';

// --- Initialization ---
function initNotesStorage() {
    if (!localStorage.getItem(NOTES_STORAGE_KEY)) {
        const initialNotes = [
            {
                id: 1702400000001,
                title: "Algebra Chapter 5 Notes",
                class: "10-A",
                subject: "Mathematics",
                fileType: "PDF",
                uploadDate: "2024-12-05",
                uploadedBy: "Sarah Johnson",
                fileName: "algebra_ch5.pdf"
            },
            {
                id: 1702400000002,
                title: "Geometry Formulas",
                class: "10-B",
                subject: "Mathematics",
                fileType: "PDF",
                uploadDate: "2024-12-03",
                uploadedBy: "Sarah Johnson",
                fileName: "geometry_formulas.pdf"
            }
        ];
        localStorage.setItem(NOTES_STORAGE_KEY, JSON.stringify(initialNotes));
    }
}

// --- CRUD ---
function getAllNotes() {
    const data = localStorage.getItem(NOTES_STORAGE_KEY);
    return data ? JSON.parse(data) : [];
}

function saveNote(data) {
    const list = getAllNotes();
    const newNote = {
        id: Date.now(),
        ...data
    };
    list.unshift(newNote);
    localStorage.setItem(NOTES_STORAGE_KEY, JSON.stringify(list));
    return newNote;
}

function deleteNote(id) {
    let list = getAllNotes();
    list = list.filter(n => n.id != id);
    localStorage.setItem(NOTES_STORAGE_KEY, JSON.stringify(list));
}
