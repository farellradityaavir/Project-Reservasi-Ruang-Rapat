// ===== MEETING RESERVATION SYSTEM - MAIN JAVASCRIPT =====

class MeetingReservationApp {
    constructor() {
        this.init();
    }

    init() {
        this.initializeComponents();
        this.bindEvents();
        this.setupRealTimeUpdates();
    }

    // Initialize all components
    initializeComponents() {
        this.initDateTimePickers();
        this.initFormValidations();
        this.initCancelConfirmations();
        this.initRoomFilters();
        this.initScheduleView();
        this.initImageUploadPreview();
        this.initAutoLogoutWarning();
        this.initResponsiveNavigation();
    }

    // Bind global events
    bindEvents() {
        // Global click handler for dynamic content
        document.addEventListener('click', this.handleGlobalClick.bind(this));
        
        // Form submission handling
        document.addEventListener('submit', this.handleFormSubmission.bind(this));
        
        // Keyboard shortcuts
        document.addEventListener('keydown', this.handleKeyboardShortcuts.bind(this));
        
        // Window resize handling
        window.addEventListener('resize', this.debounce(this.handleResize.bind(this), 250));
    }

    // ===== DATE & TIME PICKERS =====
    initDateTimePickers() {
        // Date inputs - set min date to today
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            const today = new Date().toISOString().split('T')[0];
            input.min = today;
            
            // Add custom styling on focus
            input.addEventListener('focus', () => {
                input.style.borderColor = '#DC2626';
                input.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.1)';
            });
            
            input.addEventListener('blur', () => {
                input.style.borderColor = '';
                input.style.boxShadow = '';
            });
        });

        // Time inputs with validation
        const timeInputs = document.querySelectorAll('input[type="time"]');
        timeInputs.forEach(input => {
            input.addEventListener('change', this.validateTimeRange.bind(this));
        });

        // Initialize flatpickr if available
        if (typeof flatpickr !== 'undefined') {
            this.initFlatpickr();
        }
    }

    initFlatpickr() {
        // Example flatpickr initialization for better date picking
        const dateElements = document.querySelectorAll('.date-picker');
        dateElements.forEach(el => {
            flatpickr(el, {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                locale: 'id',
                disableMobile: true
            });
        });
    }

    // ===== FORM VALIDATIONS =====
    initFormValidations() {
        const reservationForm = document.getElementById('reservation-form');
        if (reservationForm) {
            reservationForm.addEventListener('submit', (e) => {
                if (!this.validateReservationForm(reservationForm)) {
                    e.preventDefault();
                    this.showAlert('Mohon periksa form reservasi Anda.', 'error');
                }
            });
        }

        // Room creation/editing form validation
        const roomForm = document.getElementById('room-form');
        if (roomForm) {
            roomForm.addEventListener('submit', (e) => {
                if (!this.validateRoomForm(roomForm)) {
                    e.preventDefault();
                    this.showAlert('Mohon periksa form ruangan Anda.', 'error');
                }
            });
        }
    }

    validateReservationForm(form) {
        const date = form.querySelector('input[name="date"]')?.value;
        const startTime = form.querySelector('input[name="start_time"]')?.value;
        const endTime = form.querySelector('input[name="end_time"]')?.value;
        const roomId = form.querySelector('input[name="room_id"]')?.value;
        
        // Basic validation
        if (!date || !startTime || !endTime || !roomId) {
            this.showAlert('Semua field wajib diisi.', 'error');
            return false;
        }
        
        // Time validation
        if (startTime >= endTime) {
            this.showAlert('Waktu selesai harus setelah waktu mulai.', 'error');
            return false;
        }
        
        // Business hours validation (08:00 - 17:00)
        if (startTime < '08:00' || endTime > '17:00') {
            this.showAlert('Reservasi hanya dapat dilakukan antara jam 08:00 - 17:00.', 'error');
            return false;
        }
        
        // Duration validation (minimum 30 minutes)
        const start = new Date(`2000-01-01T${startTime}`);
        const end = new Date(`2000-01-01T${endTime}`);
        const duration = (end - start) / (1000 * 60); // in minutes
        
        if (duration < 30) {
            this.showAlert('Durasi reservasi minimal 30 menit.', 'error');
            return false;
        }
        
        return true;
    }

    validateRoomForm(form) {
        const name = form.querySelector('input[name="name"]')?.value;
        const capacity = form.querySelector('input[name="capacity"]')?.value;
        const location = form.querySelector('input[name="location"]')?.value;
        
        if (!name || !capacity || !location) {
            this.showAlert('Nama, kapasitas, dan lokasi ruangan wajib diisi.', 'error');
            return false;
        }
        
        if (capacity < 1) {
            this.showAlert('Kapasitas ruangan minimal 1 orang.', 'error');
            return false;
        }
        
        return true;
    }

    validateTimeRange() {
        const startTime = document.querySelector('input[name="start_time"]');
        const endTime = document.querySelector('input[name="end_time"]');
        
        if (startTime && endTime && startTime.value && endTime.value) {
            if (startTime.value >= endTime.value) {
                this.showAlert('Waktu selesai harus setelah waktu mulai.', 'error');
                endTime.focus();
                return false;
            }
        }
        return true;
    }

    // ===== ROOM MANAGEMENT =====
    initRoomFilters() {
        const filterInput = document.getElementById('room-filter');
        if (filterInput) {
            filterInput.addEventListener('input', this.debounce(() => {
                this.filterRooms(filterInput.value);
            }, 300));
        }
    }

    filterRooms(searchTerm) {
        const roomCards = document.querySelectorAll('.room-card');
        const term = searchTerm.toLowerCase().trim();
        
        roomCards.forEach(card => {
            const roomName = card.querySelector('.room-title')?.textContent.toLowerCase() || '';
            const roomLocation = card.querySelector('.room-location')?.textContent.toLowerCase() || '';
            const roomDescription = card.querySelector('.room-description')?.textContent.toLowerCase() || '';
            
            const matches = roomName.includes(term) || 
                          roomLocation.includes(term) || 
                          roomDescription.includes(term);
            
            card.style.display = matches ? 'block' : 'none';
            
            // Add highlight effect for matched terms
            if (term && matches) {
                this.highlightText(card, term);
            } else {
                this.removeHighlights(card);
            }
        });
    }

    highlightText(element, term) {
        this.removeHighlights(element);
        
        const walker = document.createTreeWalker(
            element,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );
        
        let node;
        while (node = walker.nextNode()) {
            if (node.parentNode.nodeName === 'SCRIPT' || 
                node.parentNode.nodeName === 'STYLE') {
                continue;
            }
            
            const text = node.nodeValue;
            const regex = new RegExp(`(${term})`, 'gi');
            const newText = text.replace(regex, '<mark class="search-highlight">$1</mark>');
            
            if (newText !== text) {
                const newSpan = document.createElement('span');
                newSpan.innerHTML = newText;
                node.parentNode.replaceChild(newSpan, node);
            }
        }
    }

    removeHighlights(element) {
        const highlights = element.querySelectorAll('.search-highlight');
        highlights.forEach(highlight => {
            const parent = highlight.parentNode;
            parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
            parent.normalize();
        });
    }

    // ===== SCHEDULE MANAGEMENT =====
    initScheduleView() {
        // Add click handlers for schedule items
        const scheduleItems = document.querySelectorAll('.schedule-item');
        scheduleItems.forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('expanded');
            });
        });

        // Initialize schedule date picker
        const scheduleDatePicker = document.getElementById('schedule-date');
        if (scheduleDatePicker) {
            scheduleDatePicker.addEventListener('change', (e) => {
                this.loadRoomSchedule(e.target.value);
            });
        }
    }

    loadRoomSchedule(date = null) {
        const roomId = document.getElementById('room-id')?.value;
        if (!roomId) return;

        const targetDate = date || new Date().toISOString().split('T')[0];
        
        this.showLoading('#schedule-container');
        
        fetch(`/api/rooms/${roomId}/schedule?date=${targetDate}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(schedule => {
                this.updateScheduleView(schedule);
            })
            .catch(error => {
                console.error('Error loading schedule:', error);
                this.showAlert('Gagal memuat jadwal ruangan.', 'error');
            })
            .finally(() => {
                this.hideLoading('#schedule-container');
            });
    }

    updateScheduleView(schedule) {
        const container = document.getElementById('schedule-container');
        if (!container) return;
        
        if (schedule.length === 0) {
            container.innerHTML = `
                <div class="text-center p-5">
                    <i class="fas fa-calendar-times text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Tidak ada reservasi untuk hari ini.</p>
                </div>
            `;
            return;
        }
        
        let html = '<div class="schedule-timeline">';
        schedule.forEach(item => {
            html += `
                <div class="schedule-item fade-in">
                    <div class="schedule-time">${item.start_time} - ${item.end_time}</div>
                    <div class="schedule-user">
                        <i class="fas fa-user"></i> ${item.user_name}
                    </div>
                    ${item.purpose ? `<div class="schedule-purpose">${item.purpose}</div>` : ''}
                </div>
            `;
        });
        html += '</div>';
        
        container.innerHTML = html;
        
        // Re-initialize schedule item click handlers
        this.initScheduleView();
    }

    // ===== IMAGE UPLOAD & PREVIEW =====
    initImageUploadPreview() {
        const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
        imageInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                this.handleImageUpload(e.target);
            });
        });
    }

    handleImageUpload(input) {
        const file = input.files[0];
        if (!file) return;

        // File validation
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (!validTypes.includes(file.type)) {
            this.showAlert('Format file tidak didukung. Gunakan JPEG, PNG, JPG, atau GIF.', 'error');
            input.value = '';
            return;
        }

        if (file.size > maxSize) {
            this.showAlert('Ukuran file terlalu besar. Maksimal 2MB.', 'error');
            input.value = '';
            return;
        }

        // Preview image
        const reader = new FileReader();
        reader.onload = (e) => {
            this.showImagePreview(e.target.result, input);
        };
        reader.readAsDataURL(file);
    }

    showImagePreview(imageData, input) {
        // Remove existing preview
        const existingPreview = input.parentNode.querySelector('.image-preview');
        if (existingPreview) {
            existingPreview.remove();
        }

        // Create preview element
        const preview = document.createElement('div');
        preview.className = 'image-preview mt-3';
        preview.innerHTML = `
            <div class="card">
                <div class="card-body text-center">
                    <img src="${imageData}" alt="Preview" style="max-width: 300px; max-height: 200px; object-fit: cover; border-radius: 8px;">
                    <p class="text-muted mt-2">Preview Gambar</p>
                    <button type="button" class="btn btn-outline btn-sm mt-2 remove-preview">
                        <i class="fas fa-times"></i> Hapus Preview
                    </button>
                </div>
            </div>
        `;

        input.parentNode.appendChild(preview);

        // Add remove preview functionality
        preview.querySelector('.remove-preview').addEventListener('click', () => {
            preview.remove();
            input.value = '';
        });
    }

    // ===== CANCELLATION CONFIRMATIONS =====
    initCancelConfirmations() {
        // Use event delegation for dynamic content
        document.addEventListener('click', (e) => {
            const cancelBtn = e.target.closest('form[action*="reservations"] button[type="submit"]');
            if (cancelBtn) {
                e.preventDefault();
                this.showCancellationConfirmation(cancelBtn);
            }
        });
    }

    showCancellationConfirmation(button) {
        const form = button.closest('form');
        const reservationInfo = this.getReservationInfo(form);
        
        Swal.fire({
            title: 'Batalkan Reservasi?',
            html: `
                <div class="text-left">
                    <p>Anda yakin ingin membatalkan reservasi ini?</p>
                    ${reservationInfo}
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    getReservationInfo(form) {
        // Extract reservation info from the form or nearby elements
        const card = form.closest('.reservation-card, .schedule-item');
        if (card) {
            const roomName = card.querySelector('.room-title, h4')?.textContent || 'Ruangan';
            const time = card.querySelector('.schedule-time, [class*="time"]')?.textContent || '';
            const date = card.querySelector('[class*="date"]')?.textContent || '';
            
            if (roomName || time || date) {
                return `<div class="bg-red-50 p-3 rounded-lg mt-3">
                    <strong>${roomName}</strong><br>
                    ${date} ${time}
                </div>`;
            }
        }
        
        return '';
    }

    // ===== REAL-TIME UPDATES =====
    setupRealTimeUpdates() {
        // Update schedules every 30 seconds if on a room page
        if (window.location.pathname.includes('/rooms/')) {
            setInterval(() => {
                this.loadRoomSchedule();
            }, 30000);
        }

        // Check for new reservations (admin dashboard)
        if (window.location.pathname.includes('/admin/dashboard')) {
            setInterval(() => {
                this.checkNewReservations();
            }, 60000); // Every minute
        }
    }

    checkNewReservations() {
        // Implementation for checking new reservations
        // This would typically involve WebSockets or API polling
        console.log('Checking for new reservations...');
    }

    // ===== AUTO LOGOUT WARNING =====
    initAutoLogoutWarning() {
        const logoutTime = 60 * 60 * 1000; // 1 hour in milliseconds
        let warningShown = false;

        setInterval(() => {
            const lastActivity = localStorage.getItem('lastActivity');
            const currentTime = new Date().getTime();
            
            if (lastActivity && (currentTime - lastActivity > logoutTime - 60000)) {
                // Show warning 1 minute before logout
                if (!warningShown) {
                    this.showLogoutWarning();
                    warningShown = true;
                }
            }
        }, 30000); // Check every 30 seconds

        // Update last activity on user interaction
        ['click', 'keypress', 'scroll', 'mousemove'].forEach(event => {
            document.addEventListener(event, () => {
                localStorage.setItem('lastActivity', new Date().getTime());
                warningShown = false;
            });
        });
    }

    showLogoutWarning() {
        Swal.fire({
            title: 'Sesi akan berakhir',
            text: 'Sesi Anda akan segera berakhir karena tidak ada aktivitas. Klik OK untuk memperpanjang sesi.',
            icon: 'warning',
            confirmButtonText: 'OK',
            confirmButtonColor: '#DC2626',
            allowOutsideClick: false
        }).then(() => {
            localStorage.setItem('lastActivity', new Date().getTime());
        });
    }

    // ===== RESPONSIVE NAVIGATION =====
    initResponsiveNavigation() {
        const navbarToggler = document.querySelector('.navbar-toggler');
        const sidebarCollapse = document.querySelector('.sidebar-collapse');
        
        if (navbarToggler) {
            navbarToggler.addEventListener('click', () => {
                const target = document.querySelector(navbarToggler.dataset.target);
                if (target) {
                    target.classList.toggle('show');
                }
            });
        }
        
        if (sidebarCollapse) {
            sidebarCollapse.addEventListener('click', () => {
                document.querySelector('.admin-sidebar').classList.toggle('collapsed');
            });
        }
    }

    // ===== GLOBAL EVENT HANDLERS =====
    handleGlobalClick(e) {
        // Handle dynamic content clicks
        const target = e.target;
        
        // Expandable cards
        if (target.closest('.expandable')) {
            target.closest('.expandable').classList.toggle('expanded');
        }
        
        // Copy to clipboard
        if (target.closest('.copy-btn')) {
            this.copyToClipboard(target.closest('.copy-btn'));
        }
    }

    handleFormSubmission(e) {
        const form = e.target;
        
        // Add loading state to submit button
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        }
        
        // Remove loading state after form submission completes
        setTimeout(() => {
            if (submitBtn) {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
        }, 3000);
    }

    handleKeyboardShortcuts(e) {
        // Ctrl/Cmd + K for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.getElementById('room-filter') || 
                              document.querySelector('input[type="search"]');
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Escape to close modals
        if (e.key === 'Escape') {
            this.closeAllModals();
        }
    }

    handleResize() {
        // Handle responsive behavior on window resize
        if (window.innerWidth < 768) {
            document.body.classList.add('mobile-view');
        } else {
            document.body.classList.remove('mobile-view');
        }
    }

    // ===== UTILITY FUNCTIONS =====
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

    showAlert(message, type = 'info', duration = 5000) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.custom-alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create alert element
        const alert = document.createElement('div');
        alert.className = `custom-alert alert alert-${type} fade-in`;
        alert.innerHTML = `
            <div class="d-flex justify-between align-center">
                <span>${message}</span>
                <button type="button" class="alert-close btn btn-sm" 
                        style="background: none; border: none; color: inherit;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        // Style and position
        Object.assign(alert.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            zIndex: '9999',
            minWidth: '300px',
            maxWidth: '500px',
            boxShadow: 'var(--shadow-lg)'
        });
        
        document.body.appendChild(alert);
        
        // Add close functionality
        const closeBtn = alert.querySelector('.alert-close');
        closeBtn.addEventListener('click', () => {
            alert.remove();
        });
        
        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100%)';
                    setTimeout(() => alert.remove(), 300);
                }
            }, duration);
        }
        
        return alert;
    }

    showLoading(selector = 'body') {
        const element = document.querySelector(selector);
        if (element) {
            element.classList.add('loading');
        }
    }

    hideLoading(selector = 'body') {
        const element = document.querySelector(selector);
        if (element) {
            element.classList.remove('loading');
        }
    }

    copyToClipboard(button) {
        const text = button.dataset.clipboardText || button.textContent;
        
        navigator.clipboard.writeText(text).then(() => {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i> Disalin!';
            button.classList.add('btn-success');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
            }, 2000);
        }).catch(err => {
            this.showAlert('Gagal menyalin teks', 'error');
        });
    }

    closeAllModals() {
        // Close any open modals (implementation depends on your modal library)
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(modal => {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    }
}

// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the main application
    window.MeetingReservation = new MeetingReservationApp();
    
    // Add some global utility functions
    window.copyToClipboard = (text) => {
        window.MeetingReservation.copyToClipboard({ dataset: { clipboardText: text } });
    };
    
    window.showAlert = (message, type, duration) => {
        return window.MeetingReservation.showAlert(message, type, duration);
    };
    
    console.log('Meeting Reservation System initialized successfully!');
});

// ===== GLOBAL ERROR HANDLING =====
window.addEventListener('error', function(e) {
    console.error('Global error:', e.error);
    
    // Don't show error alerts for production
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        window.MeetingReservation?.showAlert(
            `Error: ${e.message}`, 
            'error', 
            10000
        );
    }
});

// ===== OFFLINE DETECTION =====
window.addEventListener('online', function() {
    window.MeetingReservation?.showAlert('Koneksi internet kembali tersedia.', 'success', 3000);
});

window.addEventListener('offline', function() {
    window.MeetingReservation?.showAlert(
        'Koneksi internet terputus. Beberapa fitur mungkin tidak berfungsi.', 
        'warning', 
        0
    );
});