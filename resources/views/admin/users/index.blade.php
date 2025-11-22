@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('breadcrumb', 'Kelola Pengguna')

@section('content')
<div class="admin-users">
    <!-- Header -->
    <div class="card animate-slide-in-up" style="padding: 1.5rem; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; justify-content: between; gap: 1rem; flex-wrap: wrap;">
            <h1 style="display: flex; align-items: center; font-size: 1.5rem; font-weight: 700; color: var(--neutral-900); margin: 0;">
                Kelola Pengguna
            </h1>
            <div style="color: var(--neutral-500); font-size: 0.875rem;">
                Total: {{ $users->total() }} pengguna
            </div>
        </div>
    </div>

    <!-- Users Table -->
    @if($users->count() > 0)
        <div class="card animate-slide-in-up" style="animation-delay: 0.1s; padding: 0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--neutral-50);">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Nama</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Email</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Role</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Tanggal Bergabung</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--neutral-700); font-size: 0.875rem; border-bottom: 1px solid var(--neutral-200);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr style="border-bottom: 1px solid var(--neutral-200); transition: background 0.2s;">
                            <td style="padding: 1rem;">
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 2.5rem; height: 2.5rem; background: var(--primary-red); color: white; 
                                              border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                                              margin-right: 0.75rem; font-weight: 600; font-size: 0.875rem;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 500; color: var(--neutral-900);">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                            <span style="color: var(--primary-red); font-size: 0.75rem; margin-left: 0.5rem;">(Anda)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                <div style="color: var(--neutral-700);">{{ $user->email }}</div>
                            </td>
                            <td style="padding: 1rem;">
                                @if($user->role === 'admin')
                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; 
                                          background: var(--primary-red-light); color: var(--primary-red); border-radius: 9999px; 
                                          font-size: 0.75rem; font-weight: 500;">
                                    <i class="fas fa-crown mr-1"></i>Administrator
                                </span>
                                @else
                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; 
                                          background: var(--neutral-100); color: var(--neutral-600); border-radius: 9999px; 
                                          font-size: 0.75rem; font-weight: 500;">
                                    <i class="fas fa-user mr-1"></i>User
                                </span>
                                @endif
                            </td>
                            <td style="padding: 1rem;">
                                <div style="font-size: 0.875rem; color: var(--neutral-900);">
                                    {{ $user->created_at->translatedFormat('d M Y') }}
                                </div>
                                <div style="font-size: 0.75rem; color: var(--neutral-500);">
                                    {{ $user->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-role', $user) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-secondary btn-sm"
                                            onclick="return confirm('Ubah role {{ $user->name }}?')">
                                        <i class="fas fa-user-cog mr-1"></i>
                                        {{ $user->role === 'admin' ? 'Jadikan User' : 'Jadikan Admin' }}
                                    </button>
                                </form>
                                @else
                                <span style="color: var(--neutral-400); font-size: 0.75rem;">
                                    Current User
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                @if($users->onFirstPage())
                <span class="btn btn-ghost btn-sm disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
                @else
                <a href="{{ $users->previousPageUrl() }}" class="btn btn-ghost btn-sm">
                    <i class="fas fa-chevron-left"></i>
                </a>
                @endif

                @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if($page == $users->currentPage())
                    <span class="btn btn-primary btn-sm" style="min-width: 2.5rem;">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" class="btn btn-ghost btn-sm" style="min-width: 2.5rem;">{{ $page }}</a>
                    @endif
                @endforeach

                @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="btn btn-ghost btn-sm">
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
                <i class="fas fa-users-slash"></i>
            </div>
            <h3 style="color: var(--neutral-400); margin-bottom: 0.5rem;">Tidak ada pengguna</h3>
            <p style="color: var(--neutral-500);">Tidak ada pengguna yang terdaftar dalam sistem.</p>
        </div>
    @endif
</div>

<style>
.admin-users {
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
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // Add confirmation for role changes
    const roleButtons = document.querySelectorAll('form button');
    roleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm(this.getAttribute('onclick')?.match(/return confirm\('([^']+)'\)/)?.[1])) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection