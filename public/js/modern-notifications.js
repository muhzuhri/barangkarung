// Modern Notification System
class ModernNotifications {
    constructor() {
        this.container = null;
        this.init();
    }

    init() {
        // Create notification container if it doesn't exist
        if (!document.querySelector('.notification-container')) {
            this.container = document.createElement('div');
            this.container.className = 'notification-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.querySelector('.notification-container');
        }
    }

    show(message, type = 'info', options = {}) {
        const {
            title = this.getDefaultTitle(type),
            duration = 5000,
            showProgress = true,
            closable = true,
            sound = true,
            vibration = true
        } = options;

        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        
        const icon = this.getIcon(type);
        
        notification.innerHTML = `
            <div class="notification-content">
                <div class="notification-icon">${icon}</div>
                <div class="notification-text">
                    <div class="notification-title">${title}</div>
                    <div class="notification-message">${message}</div>
                </div>
            </div>
            ${closable ? '<button class="notification-close">&times;</button>' : ''}
            ${showProgress ? '<div class="notification-progress"></div>' : ''}
        `;

        // Add close functionality
        if (closable) {
            const closeBtn = notification.querySelector('.notification-close');
            closeBtn.addEventListener('click', () => {
                this.hide(notification);
            });
        }

        // Add to container
        this.container.appendChild(notification);

        // Trigger show animation
        setTimeout(() => {
            notification.classList.add('show');
            if (showProgress) {
                notification.classList.add('progressing');
            }
        }, 100);

        // Auto hide after duration
        if (duration > 0) {
            setTimeout(() => {
                this.hide(notification);
            }, duration);
        }

        return notification;
    }

    hide(notification) {
        notification.classList.remove('show');
        notification.classList.add('hide');
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 100);
    }

    getDefaultTitle(type) {
        const titles = {
            success: 'Berhasil!',
            error: 'Error!',
            warning: 'Peringatan!',
            info: 'Informasi'
        };
        return titles[type] || 'Notifikasi';
    }

    getIcon(type) {
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };
        return icons[type] || 'ℹ';
    }

    // Convenience methods
    success(message, options = {}) {
        return this.show(message, 'success', options);
    }

    error(message, options = {}) {
        return this.show(message, 'error', options);
    }

    warning(message, options = {}) {
        return this.show(message, 'warning', options);
    }

    info(message, options = {}) {
        return this.show(message, 'info', options);
    }
}

// Modern Confirmation Modal
class ModernConfirmation {
    constructor() {
        this.modal = null;
        this.init();
    }

    init() {
        // Create modal if it doesn't exist
        if (!document.querySelector('.confirmation-modal')) {
            this.modal = document.createElement('div');
            this.modal.className = 'confirmation-modal';
            document.body.appendChild(this.modal);
        } else {
            this.modal = document.querySelector('.confirmation-modal');
        }
    }

    show(message, options = {}) {
        const {
            title = 'Konfirmasi',
            confirmText = 'Ya',
            cancelText = 'Batal',
            type = 'warning'
        } = options;

        return new Promise((resolve) => {
            this.modal.innerHTML = `
                <div class="confirmation-content">
                    <div class="confirmation-icon">${this.getIcon(type)}</div>
                    <div class="confirmation-title">${title}</div>
                    <div class="confirmation-message">${message}</div>
                    <div class="confirmation-buttons">
                        <button class="confirmation-btn cancel">${cancelText}</button>
                        <button class="confirmation-btn confirm">${confirmText}</button>
                    </div>
                </div>
            `;

            // Add event listeners
            const cancelBtn = this.modal.querySelector('.confirmation-btn.cancel');
            const confirmBtn = this.modal.querySelector('.confirmation-btn.confirm');

            const cleanup = () => {
                this.hide();
                cancelBtn.removeEventListener('click', onCancel);
                confirmBtn.removeEventListener('click', onConfirm);
            };

            const onCancel = () => {
                cleanup();
                resolve(false);
            };

            const onConfirm = () => {
                cleanup();
                resolve(true);
            };

            cancelBtn.addEventListener('click', onCancel);
            confirmBtn.addEventListener('click', onConfirm);

            // Show modal
            this.modal.classList.add('show');
        });
    }

    hide() {
        this.modal.classList.remove('show');
    }

    getIcon(type) {
        const icons = {
            warning: '⚠',
            danger: '⚠',
            info: 'ℹ',
            success: '✓'
        };
        return icons[type] || '⚠';
    }
}

// Initialize global instances
window.notifications = new ModernNotifications();
window.confirmation = new ModernConfirmation();

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ModernNotifications, ModernConfirmation };
}
