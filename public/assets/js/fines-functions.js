const FINES_STORAGE_KEY = 'lms_fines';

// --- Initialization ---
window.initFinesStorage = function() {
    if (!localStorage.getItem(FINES_STORAGE_KEY)) {
        const initialFines = [
            {
                id: 1700000001,
                studentId: '2024-10A-015',
                studentName: 'John Doe',
                amount: 500,
                reason: 'Late submission of assignment',
                category: 'Academic',
                dateIssued: '2024-01-15',
                status: 'unpaid',
                dueDate: '2024-01-30'
            },
            {
                id: 1700000002,
                studentId: '2024-10A-015',
                studentName: 'John Doe',
                amount: 200,
                reason: 'Library book return delay',
                category: 'Library',
                dateIssued: '2024-01-20',
                status: 'paid',
                dueDate: '2024-01-25',
                paidDate: '2024-01-24'
            }
        ];
        localStorage.setItem(FINES_STORAGE_KEY, JSON.stringify(initialFines));
    }
};

// --- CRUD ---
async function getAllFines(rollNumber = null) {
    try {
        let url = '/api/fines';
        if (rollNumber) url += `?roll_number=${rollNumber}`;
        const response = await fetch(url);
        return await response.json();
    } catch (error) {
        console.error('Error fetching fines:', error);
        return [];
    }
}

async function addFine(userId, amount, reason, category, date) {
    try {
        const response = await fetch('/api/fines', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify({
                user_id: userId,
                amount: parseFloat(amount),
                reason,
                category,
                date_issued: date || new Date().toISOString().split('T')[0]
            })
        });

        const data = await response.json();
        return data.fine;
    } catch (error) {
        console.error('Error adding fine:', error);
        return null;
    }
}

async function getStudentFines(rollNumber) {
    return await getAllFines(rollNumber);
}

async function getPendingFines(rollNumber) {
    const all = await getStudentFines(rollNumber);
    return all.filter(f => f.status === 'Pending');
}

async function getPendingFineAmount(rollNumber) {
    const pending = await getPendingFines(rollNumber);
    return pending.reduce((sum, fine) => sum + parseFloat(fine.amount), 0);
}

async function toggleFineStatus(fineId) {
    try {
        // First get the current status or just send a toggle request
        // For simplicity, let's assume the controller can handle status update
        const response = await fetch(`/api/fines/${fineId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify({
                status: 'Paid' // In a real app, you'd toggle this
            })
        });

        return await response.json();
    } catch (error) {
        console.error('Error toggling fine status:', error);
        return { success: false };
    }
}

async function deleteFine(fineId) {
    try {
        const response = await fetch(`/api/fines/${fineId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        });

        return await response.json();
    } catch (error) {
        console.error('Error deleting fine:', error);
        return { success: false };
    }
}

// Global Exports
window.getAllFines = getAllFines;
window.addFine = addFine;
window.getStudentFines = getStudentFines;
window.getPendingFines = getPendingFines;
window.initFinesStorage = initFinesStorage;
window.getPendingFineAmount = getPendingFineAmount;
window.toggleFineStatus = toggleFineStatus;
window.deleteFine = deleteFine;
