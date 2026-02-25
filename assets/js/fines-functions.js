const FINES_STORAGE_KEY = 'lms_fines';

// --- Initialization ---
function initFinesStorage() {
    if (!localStorage.getItem(FINES_STORAGE_KEY)) {
        const initialData = [
            { id: 1, studentId: '2024-10A-015', amount: 50, reason: 'Late Fee Payment', category: 'Fee Related', date: '2024-12-05', status: 'Pending' },
            { id: 2, studentId: '2024-10A-015', amount: 25, reason: 'Library Book Damage', category: 'Library', date: '2024-11-20', status: 'Paid' }
        ];
        localStorage.setItem(FINES_STORAGE_KEY, JSON.stringify(initialData));
    }
}

// --- CRUD ---
function getAllFines() {
    const data = localStorage.getItem(FINES_STORAGE_KEY);
    let fines = data ? JSON.parse(data) : [];

    // Auto-migration for demo data (Fixing ID mismatch)
    let needsSave = false;
    fines = fines.map(f => {
        if (f.studentId === 'S101') {
            f.studentId = '2024-10A-015'; // Migrate to Roll format
            needsSave = true;
        }
        return f;
    });

    if (needsSave) {
        saveFines(fines);
    }

    return fines;
}

function saveFines(fines) {
    localStorage.setItem(FINES_STORAGE_KEY, JSON.stringify(fines));
}

function addFine(studentId, amount, reason, category, date) {
    const fines = getAllFines();
    const newFine = {
        id: Date.now(),
        studentId,
        amount: parseFloat(amount),
        reason,
        category,
        date: date || new Date().toISOString().split('T')[0],
        status: 'Pending'
    };
    fines.push(newFine);
    saveFines(fines);
    return newFine;
}

function getStudentFines(studentId) {
    const all = getAllFines();
    // Use loose comparison to handle potential whitespace or type issues
    return all.filter(f => String(f.studentId).trim().toLowerCase() === String(studentId).trim().toLowerCase());
}

function getPendingFines(studentId) {
    return getStudentFines(studentId).filter(f => f.status === 'Pending');
}

// Check for pending fines and calculate total
function getPendingFineAmount(studentId) {
    const pending = getPendingFines(studentId);
    return pending.reduce((sum, fine) => sum + fine.amount, 0);
}

// Mark fines as paid (e.g., after voucher payment)
function markFinesAsPaid(fineIds) {
    const all = getAllFines();
    const updated = all.map(f => {
        if (fineIds.includes(f.id)) {
            return { ...f, status: 'Paid' };
        }
        return f;
    });
    saveFines(updated);
}

function toggleFineStatus(fineId) {
    const all = getAllFines();
    const updated = all.map(f => {
        if (f.id === fineId) {
            // Toggle status
            return { ...f, status: f.status === 'Paid' ? 'Pending' : 'Paid' };
        }
        return f;
    });
    saveFines(updated);
    return updated.find(f => f.id === fineId);
}

function deleteFine(fineId) {
    const all = getAllFines();
    const updated = all.filter(f => f.id !== fineId);
    saveFines(updated);
    return true;
}
