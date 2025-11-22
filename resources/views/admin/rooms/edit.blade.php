@extends('layouts.admin')

@section('title', 'Edit Ruangan - ' . $room->name)

@section('content')
<div>
    <div style="max-width: 600px; margin: 0 auto;">
        <div class="card">
            <h1 style="color: var(--accent-red); margin-bottom: 2rem;">
                <i class="fas fa-edit"></i> Edit Ruangan: {{ $room->name }}
            </h1>

            @if($room->image_path)
            <div style="text-align: center; margin-bottom: 2rem;">
                <img src="{{ $room->image_url }}" 
                     alt="{{ $room->image_alt ?? $room->name }}"
                     style="max-width: 300px; height: 200px; object-fit: cover; border-radius: 8px;">
                <p style="color: var(--secondary-gray); font-size: 0.8rem; margin-top: 0.5rem;">
                    Gambar saat ini
                </p>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nama Ruangan *</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ old('name', $room->name) }}" required>
                    @error('name')
                        <span style="color: var(--error-red); font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="capacity">Kapasitas *</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" 
                           value="{{ old('capacity', $room->capacity) }}" min="1" required>
                    @error('capacity')
                        <span style="color: var(--error-red); font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="location">Lokasi *</label>
                    <input type="text" class="form-control" id="location" name="location" 
                           value="{{ old('location', $room->location) }}" required>
                    @error('location')
                        <span style="color: var(--error-red); font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" 
                              rows="4" placeholder="Deskripsi fasilitas dan fitur ruangan...">{{ old('description', $room->description) }}</textarea>
                    @error('description')
                        <span style="color: var(--error-red); font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="image">Gambar Ruangan Baru</label>
                    <input type="file" class="form-control" id="image" name="image" 
                           accept="image/jpeg,image/png,image/jpg,image/gif">
                    <div style="color: var(--secondary-gray); font-size: 0.8rem; margin-top: 0.5rem;">
                        Biarkan kosong jika tidak ingin mengubah gambar. Format: JPEG, PNG, JPG, GIF (Maks: 2MB)
                    </div>
                    @error('image')
                        <span style="color: var(--error-red); font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="image_alt">Alt Text Gambar</label>
                    <input type="text" class="form-control" id="image_alt" name="image_alt" 
                           value="{{ old('image_alt', $room->image_alt) }}" 
                           placeholder="Deskripsi singkat gambar untuk aksesibilitas">
                    @error('image_alt')
                        <span style="color: var(--error-red); font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary" style="flex: 1;">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="flex: 2;">
                        <i class="fas fa-save"></i> Update Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection