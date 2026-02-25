// =====================================================
// Announcement Management System
// Shared across Admin, Student, Teacher, and Superadmin portals
// =====================================================

const ANNOUNCEMENT_STORAGE_KEY = 'lms_announcements';

// Initialize storage
function initAnnouncementStorage() {
    if (!localStorage.getItem(ANNOUNCEMENT_STORAGE_KEY)) {
        const defaultData = [
            {
                id: 1700000001,
                title: 'Welcome to New Semester',
                content: 'Welcome back students! The new semester begins on Monday.',
                target: 'all',
                priority: 'high',
                date: new Date().toISOString(),
                author: 'Admin'
            },
            {
                id: 1700000002,
                title: 'Staff Meeting',
                content: 'All teachers are requested to attend the staff meeting at 3 PM.',
                target: 'teachers',
                priority: 'medium',
                date: new Date().toISOString(),
                author: 'Principal'
            }
        ];
        localStorage.setItem(ANNOUNCEMENT_STORAGE_KEY, JSON.stringify(defaultData));
    }
}

// Get all announcements
function getAllAnnouncements() {
    initAnnouncementStorage();
    return JSON.parse(localStorage.getItem(ANNOUNCEMENT_STORAGE_KEY) || '[]');
}

// Add announcement
function addAnnouncement(data) {
    const list = getAllAnnouncements();
    const newItem = {
        id: Date.now(),
        title: data.title,
        content: data.content,
        target: data.target, // 'all', 'students', 'teachers', or 'class:10-A'
        targetValue: data.targetValue || '', // Specific class name if target is class
        priority: data.priority,
        date: new Date().toISOString(),
        author: data.author || 'Admin'
    };
    list.unshift(newItem); // Add to top
    localStorage.setItem(ANNOUNCEMENT_STORAGE_KEY, JSON.stringify(list));
    return newItem;
}

// Delete announcement
function deleteAnnouncement(id) {
    let list = getAllAnnouncements();
    list = list.filter(item => item.id != id);
    localStorage.setItem(ANNOUNCEMENT_STORAGE_KEY, JSON.stringify(list));
    return true;
}

// Update announcement
function updateAnnouncement(id, updatedData) {
    let list = getAllAnnouncements();
    const index = list.findIndex(item => item.id == id);
    if (index !== -1) {
        list[index] = {
            ...list[index],
            title: updatedData.title,
            content: updatedData.content,
            target: updatedData.target,
            targetValue: updatedData.targetValue,
            priority: updatedData.priority,
            author: updatedData.author || list[index].author
        };
        localStorage.setItem(ANNOUNCEMENT_STORAGE_KEY, JSON.stringify(list));
        return true;
    }
    return false;
}

// Get single announcement
function getAnnouncementById(id) {
    const list = getAllAnnouncements();
    return list.find(item => item.id == id);
}

// Get announcements relevant to a user role/context
function getAnnouncementsForUser(role, userData) {
    const list = getAllAnnouncements();

    return list.filter(item => {
        // 1. All Users
        if (item.target === 'all') return true;

        // 2. Role Specific
        if (role === 'student' && item.target === 'students') return true;
        if (role === 'teacher' && item.target === 'teachers') return true;

        // 3. Class Specific (for Students)
        if (role === 'student' && item.target === 'class') {
            // Check if user's class matches item.targetValue (e.g. "10-A")
            // Normalize class formats just in case
            const userClass = (userData.class || '').replace('Class ', '').trim();
            const targetClass = (item.targetValue || '').trim();
            return userClass === targetClass;
        }

        // 4. Single User Specific (by Name)
        if (item.target === 'user') {
            return userData.name === item.targetValue;
        }

        // 5. Superadmin sees ALL
        if (role === 'superadmin' || role === 'admin') return true;

        return false;
    });
}
