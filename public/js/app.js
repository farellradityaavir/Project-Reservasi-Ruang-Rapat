// Meeting Reservation System - Enhanced JavaScript
class MeetingReservationApp {
    constructor() {
        this.init();
    }

    init() {
        this.initializeComponents();
        this.bindEvents();
        this.setupInterceptors();
    }

    initializeComponents() {
        // Initialize date pickers
        this.initDatePickers();
        
        // Initialize form validations
        this.initFormValidations();
        
        // Initialize filters
        this.initFilters();
        
        // Initialize real-time updates
        this.initRealTimeUpdates();
        
        // Initialize mobile menu
        this.initMobileMenu();
    }

    bindEvents() {
        // Global error handler
        window.addEventListener('error', this.handleGlobalError.bind(this));
        
        // Network status handler
        window.addEventListener('online', this.handleOnlineStatus.bind(this));
        window.addEventListener('offline', this.handleOfflineStatus.bind(this));
    }

    setupInterceptors() {
        // AJAX interceptor for loading states
        this.interceptAjaxRequests();
    }

    // Date Pickers
    initDatePickers() {
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            // Set min date to today
            const today = new Date().toISOString().split('T')[0];
            input.min = today;
            
            // Add custom styling
            input.addEventListener('focus', () => {
                input.classList.add('focused');
            });
            
            input.addEventListener('blur', () => {
                input.classList.remove('focused');
            });
        });

        // Time input enhancements
        const timeInputs = document.querySelectorAll('input[type="time"]');
        timeInputs.forEach(input => {
            input.addEventListener('change', this.validateTimeRange.bind(this));
        });
    }

    // Form Validations
    initFormValidations() {
        const forms = document.querySelectorAll('form[data-validate]');
        forms.forEach(form => {
            form.addEventListener('submit', this.validateForm.bind(this));
        });

        // Real-time validation
        const realTimeInputs = document.querySelectorAll('input[data-validate-real-time]');
        realTimeInputs.forEach(input => {
            input.addEventListener('blur', this.validateField.bind(this));
        });
    }

    validateForm(e) {
        const form = e.target;
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!this.validateField({ target: input })) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            this.showAlert('Harap periksa kembali form yang diisi.', 'error');
        }

        return isValid;
    }

    validateField(e) {
        const input = e.target;
        const value = input.value.trim();
        const fieldName = input.getAttribute('data-field-name') || input.name;
        
        // Clear previous errors
        this.clearFieldError(input);

        // Required validation
        if (input.required && !value) {
            this.showFieldError(input, `${fieldName} harus diisi`);
            return false;
        }

        // Email validation
        if (input.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                this.showFieldError(input, 'Format email tidak valid');
                return false;
            }
        }

        // Time validation
        if (input.type === 'time' && value) {
            if (!this.validateTimeFormat(value)) {
                this.showFieldError(input, 'Format waktu tidak valid');
                return false;
            }
        }

        // Custom validations based on data attributes
        if (input.hasAttribute('data-min-length')) {
            const minLength = parseInt(input.getAttribute('data-min-length'));
            if (value.length < minLength) {
                this.showFieldError(input, `Minimal ${minLength} karakter`);
                return false;
            }
        }

        if (input.hasAttribute('data-max-length')) {
            const maxLength = parseInt(input.getAttribute('data-max-length'));
            if (value.length > maxLength) {
                this.showFieldError(input, `Maksimal ${maxLength} karakter`);
                return false;
            }
        }

        return true;
    }

    validateTimeRange() {
        const startTime = document.querySelector('input[name="start_time"]');
        const endTime = document.querySelector('input[name="end_time"]');
        
        if (startTime && endTime && startTime.value && endTime.value) {
            if (startTime.value >= endTime.value) {
                this.showFieldError(endTime, 'Waktu selesai harus setelah waktu mulai');
                return false;
            }
            
            // Business hours validation (08:00 - 17:00)
            if (startTime.value < '08:00' || endTime.value > '17:00') {
                this.showFieldError(startTime, 'Reservasi hanya dapat dilakukan antara jam 08:00 - 17:00');
                return false;
            }
        }
        
        return true;
    }

    validateTimeFormat(time) {
        const timeRegex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/;
        return timeRegex.test(time);
    }

    showFieldError(input, message) {
        // Remove existing error
        this.clearFieldError(input);
        
        // Add error class
        input.classList.add('error');
        
        // Create error message
        const errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        errorElement.textContent = message;
        errorElement.style.cssText = `
            color: var(--error);
            font-size: var(--font-size-xs);
            margin-top: var(--spacing-1);
        `;
        
        input.parentNode.appendChild(errorElement);
    }

    clearFieldError(input) {
        input.classList.remove('error');
        const existingError = input.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
    }

    // Filters
    initFilters() {
        const roomFilter = document.getElementById('room-filter');
        if (roomFilter) {
            roomFilter.addEventListener('input', this.debounce(this.filterRooms.bind(this), 300));
        }

        const reservationFilter = document.getElementById('reservation-filter');
        if (reservationFilter) {
            reservationFilter.addEventListener('input', this.debounce(this.filterReservations.bind(this), 300));
        }
    }

    filterRooms(e) {
        const filter = e.target.value.toLowerCase();
        const roomCards = document.querySelectorAll('.room-card');
        
        roomCards.forEach(card => {
            const roomName = card.querySelector('.room-title').textContent.toLowerCase();
            const roomLocation = card.querySelector('.room-location').textContent.toLowerCase();
            const roomDescription = card.querySelector('.room-description')?.textContent.toLowerCase() || '';
            
            const matches = roomName.includes(filter) || 
                          roomLocation.includes(filter) || 
                          roomDescription.includes(filter);
            
            card.style.display = matches ? 'block' : 'none';
        });
    }

    filterReservations(e) {
        const filter = e.target.value.toLowerCase();
        const reservationCards = document.querySelectorAll('.reservation-card');
        
        reservationCards.forEach(card => {
            const roomName = card.querySelector('.reservation-room-name').textContent.toLowerCase();
            const purpose = card.querySelector('.reservation-purpose')?.textContent.toLowerCase() || '';
            
            const matches = roomName.includes(filter) || purpose.includes(filter);
            card.style.display = matches ? 'block' : 'none';
        });
    }

    // Real-time Updates
    initRealTimeUpdates() {
        // Update room schedules every 30 seconds
        setInterval(() => {
            this.updateRoomSchedules();
        }, 30000);
    }

    updateRoomSchedules() {
        const scheduleContainers = document.querySelectorAll('[data-room-schedule]');
        
        scheduleContainers.forEach(container => {
            const roomId = container.getAttribute('data-room-id');
            const date = container.getAttribute('data-date') || new Date().toISOString().split('T')[0];
            
            this.fetchRoomSchedule(roomId, date)
                .then(schedule => {
                    this.updateScheduleView(container, schedule);
                })
                .catch(error => {
                    console.error('Error updating schedule:', error);
                });
        });
    }

    async fetchRoomSchedule(roomId, date) {
        const response = await fetch(`/api/rooms/${roomId}/schedule?date=${date}`);
        if (!response.ok) {
            throw new Error('Failed to fetch schedule');
        }
        return await response.json();
    }

    updateScheduleView(container, schedule) {
        if (schedule.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">📅</div>
                    <p>Tidak ada reservasi untuk hari ini</p>
                </div>
            `;
            return;
        }
        
        let html = '<div class="schedule-timeline">';
        schedule.forEach(item => {
            html += `
                <div class="schedule-item">
                    <div class="schedule-time">${item.start_time} - ${item.end_time}</div>
                    <div class="schedule-user">${item.user_name}</div>
                    ${item.purpose ? `<div class="schedule-purpose">${item.purpose}</div>` : ''}
                </div>
            `;
        });
        html += '</div>';
        
        container.innerHTML = html;
    }

    // Mobile Menu
    initMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const adminSidebar = document.querySelector('.admin-sidebar');
        
        if (mobileToggle && adminSidebar) {
            mobileToggle.addEventListener('click', () => {
                adminSidebar.classList.toggle('open');
            });
        }
    }

    // Alert System
    showAlert(message, type = 'info', duration = 5000) {
        // Remove existing alerts
        this.removeExistingAlerts();
        
        // Create alert element
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} global-alert`;
        alert.innerHTML = `
            <div class="flex items-center justify-between">
                <span>${message}</span>
                <button type="button" class="alert-close" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        // Style the alert
        alert.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
            max-width: 500px;
            animation: slideInRight 0.3s ease;
        `;
        
        // Add to page
        document.body.appendChild(alert);
        
        // Add close functionality
        const closeBtn = alert.querySelector('.alert-close');
        closeBtn.addEventListener('click', () => {
            this.removeAlert(alert);
        });
        
        // Auto remove after duration
        setTimeout(() => {
            this.removeAlert(alert);
        }, duration);
    }

    removeAlert(alert) {
        alert.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 300);
    }

    removeExistingAlerts() {
        const existingAlerts = document.querySelectorAll('.global-alert');
        existingAlerts.forEach(alert => this.removeAlert(alert));
    }

    // Utility Functions
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    interceptAjaxRequests() {
        const originalFetch = window.fetch;
        window.fetch = async (...args) => {
            // Show loading state
            this.showLoading();
            
            try {
                const response = await originalFetch(...args);
                return response;
            } catch (error) {
                this.showAlert('Terjadi kesalahan jaringan', 'error');
                throw error;
            } finally {
                this.hideLoading();
            }
        };
    }

    showLoading() {
        // Implement loading state
        document.body.classList.add('loading');
    }

    hideLoading() {
        document.body.classList.remove('loading');
    }

    handleGlobalError(event) {
        console.error('Global error:', event.error);
        this.showAlert('Terjadi kesalahan tak terduga', 'error');
    }

    handleOnlineStatus() {
        this.showAlert('Koneksi internet tersedia', 'success', 3000);
    }

    handleOfflineStatus() {
        this.showAlert('Koneksi internet terputus', 'warning');
    }
}

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    window.MeetingReservation = new MeetingReservationApp();
});

// Additional utility functions
function formatDate(dateString) {
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

function formatTime(timeString) {
    return timeString.substring(0, 5);
}

function getTimeSlots() {
    const slots = [];
    for (let hour = 8; hour <= 17; hour++) {
        for (let minute = 0; minute < 60; minute += 30) {
            const time = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
            slots.push(time);
        }
    }
    return slots;
}

// Export for global access
window.MeetingReservationUtils = {
    formatDate,
    formatTime,
    getTimeSlots
};