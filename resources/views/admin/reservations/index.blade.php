@extends('layouts.admin')

@section('title', 'Kelola Reservasi')
@section('breadcrumb', 'Kelola Reservasi')

@section('content')
<div class="admin-reservations">
    <!-- Header -->
    <div class="card animate-slide-in-up" style="padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; justify-content: between; gap: 1rem; flex-wrap: wrap;">
            <h1 style="display: flex; align-items: center; font-size: 1.5rem; font-weight: 700; color: var(--neutral-900); margin: 0;">
                Kelola Reservasi
            </h1>
            <div style="display: flex; gap: 0.5rem;">
                <button class="btn btn-secondary btn-sm" onclick="exportReservations()">
                    <i class="fas fa-download mr-1"></i>Export
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card animate-slide-in-up" style="animation-delay: 0.1s; padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="flex: 1; max-width: 300px;">
                <div style="position: relative;">
                    <input type="text" 
                           id="reservation-search" 
                           class="form-control" 
                           placeholder="Cari reservasi..."
                           style="padding-left: 2.5rem;">
                    <i class="fas fa-search" 
                       style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--neutral-400);"></i>
                </div>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <select id="status-filter" class="form-control" style="max-width: 150px;">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
                <button class="btn btn-secondary btn-sm" onclick="resetFilters()">
                    <i class="fas fa-refresh mr-1"></i>Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Reservations Table -->
    @if($reservations->count() > 0)
        <div class="card animate-slide-in-up" style="animation-delay: 0.2s; padding: 0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--neutral-50);">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Ruangan</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">User</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Tanggal</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Waktu</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Status</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr style="border-bottom: 1px solid var(--neutral-200); transition: background 0.2s;" 
                            data-status="{{ $reservation->status }}"
                            data-search="{{ strtolower($reservation->room->name . ' ' . $reservation->user->name . ' ' . $reservation->purpose) }}">
                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 2rem; height: 2rem; background: var(--primary-red-light); border-radius: 0.5rem; 
                                              display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                                        <i class="fas fa-door-open text-red-600" style="font-size: 0.875rem;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 500; color: var(--neutral-900);">{{ $reservation->room->name }}</div>
                                        <div style="font-size: 0.75rem; color: var(--neutral-500);">{{ $reservation->room->location }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                <div style="font-weight: 500; color: var(--neutral-900);">{{ $reservation->user->name }}</div>
                                <div style="font-size: 0.75rem; color: var(--neutral-500);">{{ $reservation->user->email }}</div>
                            </td>
                            <td style="padding: 1rem;">
                                <div style="font-size: 0.875rem; color: var(--neutral-900);">
                                    {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('d M Y') }}
                                </div>
                                <div style="font-size: 0.75rem; color: var(--neutral-500);">
                                    {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('l') }}
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                <div style="font-size: 0.875rem; font-weight: 600; color: var(--primary-red);">
                                    {{ $reservation->start_time }} - {{ $reservation->end_time }}
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                @if($reservation->status === 'active')
                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; 
                                          background: #dcfce7; color: #166534; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                                @else
                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; 
                                          background: #f3f4f6; color: #6b7280; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                                    <i class="fas fa-times-circle mr-1"></i>Dibatalkan
                                </span>
                                @endif
                            </td>
                            <td style="padding: 1rem;">
                                @if($reservation->status === 'active')
                                <form action="{{ route('admin.reservations.cancel', $reservation) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Batalkan reservasi ini?')">
                                        <i class="fas fa-times mr-1"></i>Batalkan
                                    </button>
                                </form>
                                @else
                                <span style="color: var(--neutral-400); font-size: 0.75rem;">
                                    Dibatalkan
                                </span>
                                @endif
                            </td>
                        </tr>
                        @if($reservation->purpose)
                        <tr>
                            <td colspan="6" style="padding: 0 1rem 1rem 1rem;">
                                <div style="color: var(--neutral-500); font-style: italic; font-size: 0.875rem; padding: 0.5rem 0.75rem; background: var(--neutral-50); border-radius: 0.375rem;">
                                    <i class="fas fa-info-circle mr-2"></i>{{ $reservation->purpose }}
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($reservations->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                @if($reservations->onFirstPage())
                <span class="btn btn-ghost btn-sm disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
                @else
                <a href="{{ $reservations->previousPageUrl() }}" class="btn btn-ghost btn-sm">
                    <i class="fas fa-chevron-left"></i>
                </a>
                @endif

                @foreach($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url)
                    @if($page == $reservations->currentPage())
                    <span class="btn btn-primary btn-sm" style="min-width: 2.5rem;">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" class="btn btn-ghost btn-sm" style="min-width: 2.5rem;">{{ $page }}</a>
                    @endif
                @endforeach

                @if($reservations->hasMorePages())
                <a href="{{ $reservations->nextPageUrl() }}" class="btn btn-ghost btn-sm">
                    <i class="fas fa-chevron-right"></i>
                </a>
                @else
                <span class="btn btn-ghost btn-sm disabled">
                    <i class="fas fa-chevron-right"></i>
                </span>
                @endif
            </div>
        </div>
        @endif
    @else
        <div class="card" style="text-align: center; padding: 3rem;">
            <div style="font-size: 4rem; color: var(--neutral-300); margin-bottom: 1rem;">
                <i class="fas fa-calendar-times"></i>
            </div>
            <h3 style="color: var(--neutral-400); margin-bottom: 0.5rem;">Belum ada reservasi</h3>
            <p style="color: var(--neutral-500);">Tidak ada reservasi yang tercatat dalam sistem.</p>
        </div>
    @endif
</div>

<style>
.admin-reservations {
    max-width: 1200px;
    margin: 0 auto;
}

@keyframes slideInUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.animate-slide-in-up {
    animation: slideInUp 0.3s ease;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--neutral-300);
    border-radius: 0.5rem;
    font-family: inherit;
    font-size: 0.875rem;
    color: var(--neutral-800);
    background: white;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-red);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

table {
    width: 100%;
}

th, td {
    padding: 1rem;
    text-align: left;
}

tbody tr:hover {
    background: var(--neutral-50);
}

.btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
    }
    
    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-container {
        max-width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('reservation-search');
    const statusFilter = document.getElementById('status-filter');
    const tableRows = document.querySelectorAll('tbody tr[data-status]');
    
    function filterReservations() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const statusValue = statusFilter ? statusFilter.value : '';
        
        tableRows.forEach(row => {
            const searchData = row.getAttribute('data-search');
            const rowStatus = row.getAttribute('data-status');
            
            const matchesSearch = searchData.includes(searchTerm);
            const matchesStatus = !statusValue || rowStatus === statusValue;
            
            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            
            // Show/hide purpose row
            const nextRow = row.nextElementSibling;
            if (nextRow && nextRow.querySelector('td[colspan="6"]')) {
                nextRow.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            }
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', filterReservations);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterReservations);
    }
    
    // Add hover effects to table rows
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.background = 'var(--neutral-50)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.background = '';
        });
    });
});

function resetFilters() {
    const searchInput = document.getElementById('reservation-search');
    const statusFilter = document.getElementById('status-filter');
    
    if (searchInput) searchInput.value = '';
    if (statusFilter) statusFilter.value = '';
    
    const tableRows = document.querySelectorAll('tbody tr[data-status]');
    tableRows.forEach(row => {
        row.style.display = '';
        const nextRow = row.nextElementSibling;
        if (nextRow && nextRow.querySelector('td[colspan="6"]')) {
            nextRow.style.display = '';
        }
    });
}

function exportReservations() {
    // Simple export functionality - in real app, this would call an API
    alert('Fitur export akan mengunduh data reservasi dalam format CSV.\\n\\nFitur ini akan diimplementasikan di versi mendatang.');
}
</script>
@endsection