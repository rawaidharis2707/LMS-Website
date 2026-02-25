// Enhanced Search System
class GlobalSearch {
    constructor() {
        this.init();
    }

    init() {
        this.createSearchModal();
        this.setupKeyboardShortcut();
    }

    createSearchModal() {
        const modalHTML = `
            <div class="modal fade" id="globalSearchModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-0 pb-0">
                            <input type="text" class="form-control form-control-lg border-0" 
                                   id="globalSearchInput" placeholder="Search assignments, notes, lectures..." 
                                   autofocus>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="searchResults" style="max-height: 400px; overflow-y: auto;">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-search fa-3x mb-3"></i>
                                <p>Start typing to search...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        if (!document.getElementById('globalSearchModal')) {
            document.body.insertAdjacentHTML('beforeend', modalHTML);
            this.setupSearchListeners();
        }
    }

    setupKeyboardShortcut() {
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.openSearch();
            }
        });
    }

    openSearch() {
        const modal = new bootstrap.Modal(document.getElementById('globalSearchModal'));
        modal.show();
        setTimeout(() => {
            document.getElementById('globalSearchInput').focus();
        }, 300);
    }

    setupSearchListeners() {
        const input = document.getElementById('globalSearchInput');
        let debounceTimer;

        input.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                this.performSearch(e.target.value);
            }, 300);
        });
    }

    performSearch(query) {
        if (query.length < 2) {
            document.getElementById('searchResults').innerHTML = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-search fa-3x mb-3"></i>
                    <p>Type at least 2 characters...</p>
                </div>
            `;
            return;
        }

        const results = this.searchAllContent(query);
        this.displayResults(results);
    }

    searchAllContent(query) {
        const q = query.toLowerCase();
        const results = [];

        // Search assignments
        if (typeof studentData !== 'undefined' && studentData.assignments) {
            studentData.assignments.forEach(item => {
                if (item.title.toLowerCase().includes(q) ||
                    item.description.toLowerCase().includes(q)) {
                    results.push({
                        type: 'assignment',
                        title: item.title,
                        subtitle: item.subject,
                        link: 'assignments.html',
                        icon: 'fas fa-tasks',
                        color: 'primary'
                    });
                }
            });
        }

        // Search notes
        if (typeof notesData !== 'undefined') {
            notesData.forEach(item => {
                if (item.title.toLowerCase().includes(q)) {
                    results.push({
                        type: 'note',
                        title: item.title,
                        subtitle: item.subject,
                        link: 'notes.html',
                        icon: 'fas fa-file-pdf',
                        color: 'danger'
                    });
                }
            });
        }

        // Search lectures
        if (typeof lecturesData !== 'undefined') {
            lecturesData.forEach(item => {
                if (item.title.toLowerCase().includes(q)) {
                    results.push({
                        type: 'lecture',
                        title: item.title,
                        subtitle: item.subject,
                        link: 'lectures.html',
                        icon: 'fas fa-video',
                        color: 'success'
                    });
                }
            });
        }

        return results;
    }

    displayResults(results) {
        const container = document.getElementById('searchResults');

        if (results.length === 0) {
            container.innerHTML = `
                <div class="empty-state p-4 text-center">
                    <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No results found</p>
                </div>
            `;
            return;
        }

        container.innerHTML = results.map(r => `
            <a href="${r.link}" class="d-block text-decoration-none mb-2 p-3 rounded hover-bg">
                <div class="d-flex align-items-center">
                    <div class="icon-box-${r.color} me-3">
                        <i class="${r.icon}"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">${this.highlightMatch(r.title, document.getElementById('globalSearchInput').value)}</h6>
                        <small class="text-muted">${r.subtitle} · ${r.type}</small>
                    </div>
                </div>
            </a>
        `).join('');
    }

    highlightMatch(text, query) {
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }
}

// Initialize global search
document.addEventListener('DOMContentLoaded', () => {
    window.globalSearch = new GlobalSearch();
});
