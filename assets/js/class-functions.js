const CLASS_DATA_KEY = 'lms_classes';

// --- Initialization ---
function initClassStorage() {
    const hiddenData = localStorage.getItem(CLASS_DATA_KEY);
    if (!hiddenData || JSON.parse(hiddenData).length === 0) {
        const initialData = [
            { id: 1, name: '10-A', capacity: 40, section: 'A' },
            { id: 2, name: '10-B', capacity: 40, section: 'B' },
            { id: 3, name: '9-A', capacity: 35, section: 'A' }
        ];
        localStorage.setItem(CLASS_DATA_KEY, JSON.stringify(initialData));
    }
}

// --- CRUD ---
function getAllClasses() {
    const data = localStorage.getItem(CLASS_DATA_KEY);
    return data ? JSON.parse(data) : [];
}

function addClass(className, section, capacity, batch, level = 'General', group = 'Common') {
    const classes = getAllClasses();

    // Create compound name if not provided directly
    let finalName = className;
    if (section && !className.includes(section) && !className.includes('-')) {
        finalName = `${className}-${section}`;
    }

    if (classes.some(c => c.name === finalName)) {
        return { success: false, message: 'Class already exists' };
    }

    const newClass = {
        id: Date.now(),
        name: finalName,
        section: section,
        capacity: parseInt(capacity),
        batch: batch, // Store directly as string
        level: level,
        group: group
    };

    classes.push(newClass);
    localStorage.setItem(CLASS_DATA_KEY, JSON.stringify(classes));
    return { success: true, message: 'Class added successfully' };
}

function deleteClass(id) {
    let classes = getAllClasses();
    classes = classes.filter(c => c.id !== id);
    localStorage.setItem(CLASS_DATA_KEY, JSON.stringify(classes));
}

// --- Helper for Dropdowns ---
// Populates any select element with class names
function populateClassSelect(selectElement, defaultText = 'Choose class...') {
    if (!selectElement) return;

    const classes = getAllClasses();
    selectElement.innerHTML = `<option value="">${defaultText}</option>`;

    classes.forEach(cls => {
        const opt = document.createElement('option');
        opt.value = cls.name; // Use name as value (e.g. "10-A") to match existing logic
        opt.textContent = `Class ${cls.name}`;
        selectElement.appendChild(opt);
    });
}
