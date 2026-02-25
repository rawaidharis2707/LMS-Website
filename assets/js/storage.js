// LocalStorage Data Persistence System
class StorageManager {
    constructor() {
        this.prefix = 'lms_';
    }

    // Set item
    set(key, value) {
        try {
            const prefixedKey = this.prefix + key;
            localStorage.setItem(prefixedKey, JSON.stringify(value));
            return true;
        } catch (e) {
            console.error('Storage error:', e);
            return false;
        }
    }

    // Get item
    get(key, defaultValue = null) {
        try {
            const prefixedKey = this.prefix + key;
            const item = localStorage.getItem(prefixedKey);
            return item ? JSON.parse(item) : defaultValue;
        } catch (e) {
            console.error('Storage error:', e);
            return defaultValue;
        }
    }

    // Remove item
    remove(key) {
        const prefixedKey = this.prefix + key;
        localStorage.removeItem(prefixedKey);
    }

    // Clear all LMS data
    clear() {
        const keys = Object.keys(localStorage);
        keys.forEach(key => {
            if (key.startsWith(this.prefix)) {
                localStorage.removeItem(key);
            }
        });
    }

    // Auto-save form data
    saveFormDraft(formId, data) {
        this.set(`draft_${formId}`, {
            data: data,
            timestamp: new Date().toISOString()
        });
    }

    // Load form draft
    loadFormDraft(formId) {
        const draft = this.get(`draft_${formId}`);
        if (draft && draft.data) {
            return draft.data;
        }
        return null;
    }

    // Clear form draft
    clearFormDraft(formId) {
        this.remove(`draft_${formId}`);
    }

    // Save user preferences
    savePreference(key, value) {
        const prefs = this.get('preferences', {});
        prefs[key] = value;
        this.set('preferences', prefs);
    }

    // Get user preference
    getPreference(key, defaultValue = null) {
        const prefs = this.get('preferences', {});
        return prefs[key] !== undefined ? prefs[key] : defaultValue;
    }
}

// Form Auto-Save Utility
class FormAutoSave {
    constructor(formElement, formId) {
        this.form = formElement;
        this.formId = formId;
        this.storage = new StorageManager();
        this.debounceTimer = null;
        this.init();
    }

    init() {
        // Load existing draft
        this.loadDraft();

        // Setup auto-save on input change
        this.form.addEventListener('input', () => {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => this.saveDraft(), 1000);
        });

        // Clear draft on successful submit
        this.form.addEventListener('submit', () => {
            this.storage.clearFormDraft(this.formId);
        });
    }

    saveDraft() {
        const formData = new FormData(this.form);
        const data = {};

        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        this.storage.saveFormDraft(this.formId, data);
        this.showDraftSavedIndicator();
    }

    loadDraft() {
        const draft = this.storage.loadFormDraft(this.formId);
        if (draft) {
            // Populate form with draft data
            Object.keys(draft).forEach(key => {
                const input = this.form.querySelector(`[name="${key}"]`);
                if (input) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = draft[key] === input.value;
                    } else {
                        input.value = draft[key];
                    }
                }
            });
            this.showDraftLoadedNotification();
        }
    }

    showDraftSavedIndicator() {
        // Show subtle indicator that draft was saved
        const indicator = document.getElementById('draftIndicator');
        if (indicator) {
            indicator.textContent = '✓ Draft saved';
            indicator.classList.add('text-success');
            setTimeout(() => {
                indicator.textContent = '';
                indicator.classList.remove('text-success');
            }, 2000);
        }
    }

    showDraftLoadedNotification() {
        if (typeof showToast === 'function') {
            showToast('Draft loaded from previous session', 'info');
        }
    }

    clearDraft() {
        this.storage.clearFormDraft(this.formId);
        this.form.reset();
    }
}

// Initialize storage manager globally
const storage = new StorageManager();

// Cross-tab sync using storage events
// NOTE: Auto-reload disabled to allow multiple independent sessions across tabs
window.addEventListener('storage', function (e) {
    if (e.key && e.key.startsWith('lms_')) {
        // Reload data when changed in another tab
        // Commenting out auto-reload to prevent logout when logging in from another tab
        // if (e.key === 'lms_session') {
        //     location.reload();
        // }
    }
});
