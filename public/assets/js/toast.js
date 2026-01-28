/**
 * Toast Notification System
 * Reusable across all pages
 */

const Toast = {
    /**
     * Initialize toast (call this once in your layout)
     */
    init() {
        // Check if toast container already exists
        if (document.getElementById('globalToastContainer')) {
            return;
        }

        // Create toast HTML
        const toastHTML = `
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;" id="globalToastContainer">
                <div id="globalToast" class="toast align-items-center text-white border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body" id="globalToastMessage"></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        `;

        // Insert into body
        document.body.insertAdjacentHTML('beforeend', toastHTML);

        // Add CSS if not exists
        if (!document.getElementById('toast-styles')) {
            const style = document.createElement('style');
            style.id = 'toast-styles';
            style.textContent = `
                .toast.bg-success { background-color: #28a745 !important; }
                .toast.bg-danger { background-color: #dc3545 !important; }
                .toast.bg-warning { background-color: #ffc107 !important; }
                .toast.bg-info { background-color: #17a2b8 !important; }
            `;
            document.head.appendChild(style);
        }
    },

    /**
     * Show toast notification
     * @param {string} message - Message to display
     * @param {string} type - success, error, warning, info
     * @param {number} duration - Auto-hide delay in milliseconds (default: 3000)
     */
    show(message, type = 'success', duration = 3000) {
        // Ensure toast is initialized
        this.init();

        const toastEl = document.getElementById('globalToast');
        const toastMessage = document.getElementById('globalToastMessage');

        if (!toastEl || !toastMessage) {
            console.error('Toast elements not found');
            return;
        }

        // Map type to Bootstrap class
        const typeMap = {
            'success': 'bg-success',
            'error': 'bg-danger',
            'danger': 'bg-danger',
            'warning': 'bg-warning',
            'info': 'bg-info'
        };

        // Remove all type classes
        toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-info');
        
        // Add new type class
        toastEl.classList.add(typeMap[type] || 'bg-success');
        
        // Set message
        toastMessage.textContent = message;

        // Show toast
        const bsToast = new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: duration
        });
        bsToast.show();
    },

    /**
     * Shorthand methods
     */
    success(message, duration) {
        this.show(message, 'success', duration);
    },

    error(message, duration) {
        this.show(message, 'error', duration);
    },

    warning(message, duration) {
        this.show(message, 'warning', duration);
    },

    info(message, duration) {
        this.show(message, 'info', duration);
    }
};

// Auto-initialize on DOM load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => Toast.init());
} else {
    Toast.init();
}

// Make available globally
window.Toast = Toast;