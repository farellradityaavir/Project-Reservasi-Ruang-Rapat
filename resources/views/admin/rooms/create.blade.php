@extends('layouts.admin')

@section('title', 'Tambah Ruangan')
@section('breadcrumb', 'Tambah Ruangan')

@section('content')
<div class="admin-room-form">
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="card animate-slide-in-up">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--neutral-200);">
                <h1 style="display: flex; align-items: center; font-size: 1.5rem; font-weight: 700; color: var(--neutral-900); margin: 0;">
                    <i class="fas fa-plus-circle mr-3"></i>
                    Tambah Ruangan Baru
                </h1>
            </div>

            <div style="padding: 1.5rem;">
                <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data" id="room-form">
                    @csrf

                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="name">
                            <i class="fas fa-door-open mr-2"></i>Nama Ruangan *
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Contoh: Ruang Rapat A - Executive"
                               required>
                        @error('name')
                            <div style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="capacity">
                            <i class="fas fa-users mr-2"></i>Kapasitas *
                        </label>
                        <input type="number" 
                               class="form-control" 
                               id="capacity" 
                               name="capacity" 
                               value="{{ old('capacity') }}" 
                               min="1" 
                               max="100"
                               placeholder="Jumlah orang"
                               required>
                        @error('capacity')
                            <div style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="location">
                            <i class="fas fa-map-marker-alt mr-2"></i>Lokasi *
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="location" 
                               name="location" 
                               value="{{ old('location') }}" 
                               placeholder="Contoh: Lantai 3 - Gedung Utama"
                               required>
                        @error('location')
                            <div style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="description">
                            <i class="fas fa-info-circle mr-2"></i>Deskripsi
                        </label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Deskripsi fasilitas dan fitur ruangan...">{{ old('description') }}</textarea>
                        @error('description')
                            <div style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="image">
                            <i class="fas fa-image mr-2"></i>Gambar Ruangan
                        </label>
                        <input type="file" 
                               class="form-control" 
                               id="image" 
                               name="image" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               onchange="previewImage(this)">
                        <div style="color: var(--neutral-500); font-size: 0.75rem; margin-top: 0.5rem;">
                            Format: JPEG, PNG, JPG, GIF (Maks: 2MB)
                        </div>
                        @error('image')
                            <div style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                        
                        <!-- Image Preview -->
                        <div id="image-preview" style="margin-top: 1rem; display: none;">
                            <img id="preview" 
                                 style="max-width: 200px; max-height: 150px; border-radius: 0.5rem; border: 1px solid var(--neutral-200);">
                        </div>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label class="form-label" for="image_alt">
                            <i class="fas fa-tag mr-2"></i>Alt Text Gambar
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="image_alt" 
                               name="image_alt" 
                               value="{{ old('image_alt') }}" 
                               placeholder="Deskripsi singkat gambar untuk aksesibilitas">
                        @error('image_alt')
                            <div style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div style="display: flex; gap: 0.75rem;">
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary" style="flex: 1;">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" style="flex: 2;">
                            <i class="fas fa-save mr-2"></i>Simpan Ruangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.admin-room-form {
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

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--neutral-700);
    font-size: 0.875rem;
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

input[type="file"] {
    padding: 0.5rem;
}
</style>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
        
        // Check file size
        if (fileSize > 2) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            input.value = '';
            previewContainer.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('room-form');
    
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const capacity = document.getElementById('capacity').value;
        const location = document.getElementById('location').value.trim();
        
        if (!name || !capacity || !location) {
            e.preventDefault();
            alert('Harap isi semua field yang wajib diisi.');
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection