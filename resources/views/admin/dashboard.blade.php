@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="admin-dashboard">
    <!-- Welcome Section -->
    <div class="welcome-section card animate-slide-in-up" 
         style="background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%); 
                color: white; padding: 2rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; justify-content: between; gap: 2rem;">
            <div style="flex: 1;">
                <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; color: white;">
                    Selamat Datang, {{ auth()->user()->name }}! 
                </h1>
                <p style="color: rgba(255,255,255,0.9); margin: 0;">
                    Kelola sistem reservasi ruang rapat dengan mudah dan efisien.
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem; flex-shrink: 0;">
                <a href="{{ route('admin.rooms.create') }}" class="btn" 
                   style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                    <i class="fas fa-plus mr-2"></i>Tambah Ruangan
                </a>
                <a href="{{ route('admin.reservations') }}" class="btn" 
                   style="background:  rgba(255,255,255,0.2);  color: white; border: 1px solid rgba(255,255,255,0.3);">
                    <i class="fas fa-list mr-2"></i>Lihat Reservasi
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card animate-slide-in-up" style="animation-delay: 0.1s; padding: 1.5rem; position: relative; text-align: center;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--primary-red);"></div>
            <div style="width: 48px; height: 48px; background: var(--primary-red-light); color: var(--primary-red); 
                      border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                      margin: 0 auto 1rem; font-size: 1.25rem;">
                <i class="fas fa-door-open"></i>
            </div>
            <div style="font-size: 1.875rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 0.5rem;">
                {{ $stats['total_rooms'] }}
            </div>
            <div style="color: var(--neutral-500); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">
                Total Ruangan
            </div>
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.25rem; font-size: 0.75rem; color: var(--neutral-400);">
                <i class="fas fa-building"></i>
                <span>Semua ruangan</span>
            </div>
        </div>
        
        <div class="card animate-slide-in-up" style="animation-delay: 0.2s; padding: 1.5rem; position: relative; text-align: center;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--primary-red);"></div>
            <div style="width: 48px; height: 48px; background: var(--primary-red-light); color: var(--primary-red); 
                      border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                      margin: 0 auto 1rem; font-size: 1.25rem;">
                <i class="fas fa-users"></i>
            </div>
            <div style="font-size: 1.875rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 0.5rem;">
                {{ $stats['total_users'] }}
            </div>
            <div style="color: var(--neutral-500); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">
                Total Pengguna
            </div>
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.25rem; font-size: 0.75rem; color: var(--neutral-400);">
                <i class="fas fa-user-friends"></i>
                <span>Admin & User</span>
            </div>
        </div>
        
        <div class="card animate-slide-in-up" style="animation-delay: 0.3s; padding: 1.5rem; position: relative; text-align: center;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--primary-red);"></div>
            <div style="width: 48px; height: 48px; background: var(--primary-red-light); color: var(--primary-red); 
                      border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                      margin: 0 auto 1rem; font-size: 1.25rem;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div style="font-size: 1.875rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 0.5rem;">
                {{ $stats['active_reservations'] }}
            </div>
            <div style="color: var(--neutral-500); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">
                Reservasi Aktif
            </div>
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.25rem; font-size: 0.75rem; color: var(--neutral-400);">
                <i class="fas fa-clock"></i>
                <span>Mendatang</span>
            </div>
        </div>
        
        <div class="card animate-slide-in-up" style="animation-delay: 0.4s; padding: 1.5rem; position: relative; text-align: center;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--primary-red);"></div>
            <div style="width: 48px; height: 48px; background: var(--primary-red-light); color: var(--primary-red); 
                      border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                      margin: 0 auto 1rem; font-size: 1.25rem;">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div style="font-size: 1.875rem; font-weight: 700; color: var(--neutral-900); margin-bottom: 0.5rem;">
                {{ $stats['today_reservations'] }}
            </div>
            <div style="color: var(--neutral-500); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">
                Reservasi Hari Ini
            </div>
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.25rem; font-size: 0.75rem; color: var(--neutral-400);">
                <i class="fas fa-sun"></i>
                <span>{{ now()->translatedFormat('d M Y') }}</span>
            </div>
        </div>
    </div>

    <div style="display: grid; gap: 2rem;">
        <!-- Recent Reservations -->
        <div class="card animate-slide-in-up" style="animation-delay: 0.5s; padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1.5rem;">
                <h2 style="display: flex; align-items: center; font-size: 1.25rem; font-weight: 600; color: var(--neutral-900); margin: 0;">
                    Reservasi Terbaru
                </h2>
                <a href="{{ route('admin.reservations') }}" class="btn btn-ghost btn-sm">
                    Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            @if($recentReservations->count() > 0)
                <div style="overflow: hidden; border-radius: 0.75rem; border: 1px solid var(--neutral-200);">
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
                            @foreach($recentReservations as $reservation)
                            <tr style="border-bottom: 1px solid var(--neutral-200); transition: background 0.2s;">
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
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="font-size: 0.875rem; font-weight: 600; color: var(--primary-red);">
                                        {{ $reservation->start_time }} - {{ $reservation->end_time }}
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; 
                                              background: #dcfce7; color: #166534; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                </td>
                                <td style="padding: 1rem;">
                                    <form action="{{ route('admin.reservations.cancel', $reservation) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Batalkan reservasi ini?')">
                                            <i class="fas fa-times mr-1"></i>Batalkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: var(--neutral-500);">
                    <div style="font-size: 3rem; margin-bottom: 1rem; color: var(--neutral-300);">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3 style="color: var(--neutral-400); margin-bottom: 0.5rem;">Tidak ada reservasi terbaru</h3>
                    <p>Belum ada reservasi yang dibuat hari ini.</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="card animate-slide-in-up" style="animation-delay: 0.6s; padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1.5rem;">
                <h2 style="display: flex; align-items: center; font-size: 1.25rem; font-weight: 600; color: var(--neutral-900); margin: 0;">
                    Quick Actions
                </h2>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
                <a href="{{ route('admin.rooms.create') }}" 
                   style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--neutral-50); 
                          border: 1px solid var(--neutral-200); border-radius: 0.75rem; text-decoration: none; 
                          color: inherit; transition: all 0.2s;">
                    <div style="width: 3rem; height: 3rem; background: var(--primary-red); color: white; 
                              border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                              font-size: 1.125rem;">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 1rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 0.25rem;">
                            Tambah Ruangan
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--neutral-500); margin: 0;">
                            Buat ruangan meeting baru
                        </p>
                    </div>
                    <div style="color: var(--neutral-400); transition: all 0.2s;">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.rooms.index') }}" 
                   style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--neutral-50); 
                          border: 1px solid var(--neutral-200); border-radius: 0.75rem; text-decoration: none; 
                          color: inherit; transition: all 0.2s;">
                    <div style="width: 3rem; height: 3rem; background: var(--primary-red); color: white; 
                              border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                              font-size: 1.125rem;">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 1rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 0.25rem;">
                            Kelola Ruangan
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--neutral-500); margin: 0;">
                            Edit atau hapus ruangan
                        </p>
                    </div>
                    <div style="color: var(--neutral-400); transition: all 0.2s;">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.reservations') }}" 
                   style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--neutral-50); 
                          border: 1px solid var(--neutral-200); border-radius: 0.75rem; text-decoration: none; 
                          color: inherit; transition: all 0.2s;">
                    <div style="width: 3rem; height: 3rem; background: var(--primary-red); color: white; 
                              border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                              font-size: 1.125rem;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 1rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 0.25rem;">
                            Kelola Reservasi
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--neutral-500); margin: 0;">
                            Lihat semua reservasi
                        </p>
                    </div>
                    <div style="color: var(--neutral-400); transition: all 0.2s;">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.users') }}" 
                   style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--neutral-50); 
                          border: 1px solid var(--neutral-200); border-radius: 0.75rem; text-decoration: none; 
                          color: inherit; transition: all 0.2s;">
                    <div style="width: 3rem; height: 3rem; background: var(--primary-red); color: white; 
                              border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; 
                              font-size: 1.125rem;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 1rem; font-weight: 600; color: var(--neutral-900); margin-bottom: 0.25rem;">
                            Kelola Pengguna
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--neutral-500); margin: 0;">
                            Manage user roles
                        </p>
                    </div>
                    <div style="color: var(--neutral-400); transition: all 0.2s;">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
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

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.quick-action-card:hover {
    background: white !important;
    border-color: var(--primary-red) !important;
    transform: translateY(-2px);
}

.quick-action-card:hover .quick-action-arrow {
    color: var(--primary-red) !important;
    transform: translateX(4px);
}

table tbody tr:hover {
    background: var(--neutral-50);
}

@media (max-width: 768px) {
    .welcome-section div {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .welcome-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .welcome-actions .btn {
        width: 100%;
    }
    
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    table {
        display: block;
        overflow-x: auto;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to quick action cards
        const quickActions = document.querySelectorAll('.card a');
        quickActions.forEach(action => {
            action.addEventListener('mouseenter', function() {
                this.style.background = 'white';
                this.style.borderColor = 'var(--primary-red)';
                this.style.transform = 'translateY(-2px)';
                this.style.color = 'var(--primary-red)';
    
                const iconBox = this.querySelector('div[style*="background: var(--primary-red)"]');
                if (iconBox) {
                    iconBox.style.background = 'var(--primary-red-light)';
                    iconBox.style.color = 'var(--primary-red)';
                }
    
                const arrow = this.querySelector('.fa-chevron-right');
                if (arrow) {
                    arrow.style.color = 'var(--primary-red)';
                    arrow.style.transform = 'translateX(4px)';
                }
            });
            
            action.addEventListener('mouseleave', function() {
                this.style.background = 'var(--neutral-50)';
                this.style.borderColor = 'var(--neutral-200)';
                this.style.transform = '';
                this.style.color = '';
    
                const iconBox = this.querySelector('div[style*="background: var(--primary-red)"]');
                if (iconBox) {
                    iconBox.style.background = 'var(--primary-red)';
                    iconBox.style.color = 'white';
                }
    
                const arrow = this.querySelector('.fa-chevron-right');
                if (arrow) {
                    arrow.style.color = '';
                    arrow.style.transform = '';
                }
            });
        });
    
        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.background = 'var(--neutral-50)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.background = '';
            });
        });
    });
    </script>
    
@endsection