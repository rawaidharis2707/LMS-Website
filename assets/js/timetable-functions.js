// =====================================================
// Timetable Management System
// Shared across Admin, Student, and Teacher portals
// =====================================================

const TIMETABLE_STORAGE_KEY = 'lms_timetables';
const TIMETABLE_SETTINGS_KEY = 'lms_timetable_settings';

// Initialize settings with default values
function initTimetableSettings() {
    if (!localStorage.getItem(TIMETABLE_SETTINGS_KEY)) {
        const defaultSettings = {
            periods: [
                { id: 1, label: 'Period 1', start: '08:00', end: '08:50' },
                { id: 2, label: 'Period 2', start: '09:00', end: '09:50' },
                { id: 3, label: 'Period 3', start: '10:00', end: '10:50' },
                { id: 4, label: 'Period 4', start: '11:00', end: '11:50' },
                { id: 5, label: 'Period 5', start: '12:00', end: '12:50' },
                { id: 6, label: 'Period 6', start: '13:00', end: '13:50' }
            ],
            breakTime: { label: 'Break', start: '10:50', end: '11:00', afterPeriod: 3 }
        };
        localStorage.setItem(TIMETABLE_SETTINGS_KEY, JSON.stringify(defaultSettings));
    }
}

// Get Settings
function getTimetableSettings() {
    initTimetableSettings();
    return JSON.parse(localStorage.getItem(TIMETABLE_SETTINGS_KEY));
}

// Save Settings
function saveTimetableSettings(settings) {
    localStorage.setItem(TIMETABLE_SETTINGS_KEY, JSON.stringify(settings));
}

// Initialize storage with some default data if empty
function initTimetableStorage() {
    if (!localStorage.getItem(TIMETABLE_STORAGE_KEY)) {
        const defaultData = [
            // Sample for Class 10-A
            { id: 1700000001, className: '10-A', day: 'Monday', period: 1, subject: 'Mathematics', teacher: 'Sarah Johnson', room: '101' },
            { id: 1700000002, className: '10-A', day: 'Monday', period: 2, subject: 'Physics', teacher: 'John Smith', room: '102' },
            { id: 1700000003, className: '10-A', day: 'Monday', period: 3, subject: 'Chemistry', teacher: 'Emily Davis', room: 'Lab 1' },
            { id: 1700000004, className: '10-A', day: 'Wednesday', period: 1, subject: 'English', teacher: 'Robert Wilson', room: '103' }
        ];
        localStorage.setItem(TIMETABLE_STORAGE_KEY, JSON.stringify(defaultData));
    }
}

// Get all entries
function getAllTimetableEntries() {
    initTimetableStorage();
    return JSON.parse(localStorage.getItem(TIMETABLE_STORAGE_KEY) || '[]');
}

// Add new entry
function addTimetableEntry(entry) {
    const entries = getAllTimetableEntries();
    const newEntry = {
        id: Date.now(),
        className: entry.className,
        day: entry.day,
        period: entry.period || 0, // Fallback if still used somehow
        startTime: entry.startTime, // New
        endTime: entry.endTime,     // New
        subject: entry.subject,
        teacher: entry.teacher,
        room: entry.room
    };
    entries.push(newEntry);
    localStorage.setItem(TIMETABLE_STORAGE_KEY, JSON.stringify(entries));
    return newEntry;
}

// Delete entry
function deleteTimetableEntry(id) {
    let entries = getAllTimetableEntries();
    entries = entries.filter(e => e.id != id);
    localStorage.setItem(TIMETABLE_STORAGE_KEY, JSON.stringify(entries));
    return true;
}

// Update entry
function updateTimetableEntry(id, updatedData) {
    let entries = getAllTimetableEntries();
    const index = entries.findIndex(e => e.id == id);
    if (index !== -1) {
        entries[index] = {
            ...entries[index],
            className: updatedData.className,
            day: updatedData.day,
            startTime: updatedData.startTime, // New
            endTime: updatedData.endTime,     // New
            period: updatedData.period || entries[index].period,
            subject: updatedData.subject,
            teacher: updatedData.teacher,
            room: updatedData.room
        };
        localStorage.setItem(TIMETABLE_STORAGE_KEY, JSON.stringify(entries));
        return true;
    }
    return false;
}

// Get single entry
function getTimetableEntryById(id) {
    const entries = getAllTimetableEntries();
    return entries.find(e => e.id == id);
}

// Get specific class timetable (organized by Day -> Period)
// Returns: { Monday: { 1: {entry}, 2: {entry} }, Tuesday: ... }
function getClassTimetableMatrix(className) {
    const entries = getAllTimetableEntries().filter(e => e.className === className);
    const matrix = {
        'Monday': {}, 'Tuesday': {}, 'Wednesday': {}, 'Thursday': {}, 'Friday': {}, 'Saturday': {}
    };

    entries.forEach(e => {
        if (matrix[e.day]) {
            matrix[e.day][e.period] = e;
        }
    });

    return matrix;
}

// Get specific teacher timetable
function getTeacherTimetableMatrix(teacherNamePartial) {
    // We match if teacher name contains the string (e.g. "Sarah")
    const entries = getAllTimetableEntries().filter(e =>
        e.teacher.toLowerCase().includes(teacherNamePartial.toLowerCase())
    );

    const matrix = {
        'Monday': {}, 'Tuesday': {}, 'Wednesday': {}, 'Thursday': {}, 'Friday': {}, 'Saturday': {}
    };

    entries.forEach(e => {
        if (matrix[e.day]) {
            matrix[e.day][e.period] = e;
        }
    });

    return matrix;
}

// Helper: Get Time Label for Period
function getPeriodTime(period) {
    const settings = getTimetableSettings();
    const p = settings.periods.find(p => p.id == period);
    if (p) {
        // Convert 24h to 12h format friendly
        return `${formatTime(p.start)} - ${formatTime(p.end)}`;
    }
    return `Period ${period}`;
}

function formatTime(timeStr) {
    if (!timeStr) return '';
    const [h, m] = timeStr.split(':');
    const d = new Date();
    d.setHours(h);
    d.setMinutes(m);
    return d.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
}

// Get specific day's timetable for a class, sorted by start time
function getTimetableForClass(className, day) {
    const entries = getAllTimetableEntries();
    return entries
        .filter(e => e.className === className && e.day === day)
        .sort((a, b) => {
            // Sort by time string "HH:MM"
            if (a.startTime < b.startTime) return -1;
            if (a.startTime > b.startTime) return 1;
            return 0;
        })
        .map(e => ({
            ...e,
            time: `${formatTime(e.startTime)} - ${formatTime(e.endTime)}` // Helper
        }));
}
