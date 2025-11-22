# SISTEM RESERVASI RUANG RAPAT

## 📋 Daftar Isi
1. [Skema Basis Data](#-skema-basis-data)
2. [Alur Logika Sistem](#-alur-logika-sistem)
3. [Dokumentasi AI](#-dokumentasi-ai)

---

## 🗃️ Skema Basis Data

### Database: `db_ruangrapat`

#### 1. 🧑‍🤝‍🧑 Tabel: `users` (Pengguna)
Menyimpan informasi pengguna yang berhak melakukan reservasi.

**Struktur Tabel:**
| Field | Type | Keterangan |
|-------|------|------------|
| `id` | BIGINT UNSIGNED | **Primary Key**, pengenal unik |
| `email` | VARCHAR | Unik, untuk login dan identifikasi |
| `name` | VARCHAR | Nama lengkap pengguna |
| `password` | VARCHAR | Hash kata sandi |
| `role` | ENUM('admin','user') | Peran pengguna (default: 'user') |
| `created_at` | TIMESTAMP | Waktu pembuatan data |
| `updated_at` | TIMESTAMP | Waktu pembaruan data |

#### 2. 🏢 Tabel: `rooms` (Ruangan)
Berisi daftar ruangan rapat yang tersedia untuk dipesan.

**Struktur Tabel:**
| Field | Type | Keterangan |
|-------|------|------------|
| `id` | BIGINT UNSIGNED | **Primary Key**, pengenal unik ruangan |
| `name` | VARCHAR | Nama ruangan (contoh: 'Ruang Rapat A - Creative') |
| `capacity` | INT UNSIGNED | Kapasitas maksimum ruangan |
| `location` | VARCHAR | Lokasi ruangan (contoh: 'Lantai 2 - Gedung Kreatif') |
| `description` | TEXT | Deskripsi fasilitas ruangan |
| `image_path` | VARCHAR | Path file gambar ruangan |
| `image_alt` | VARCHAR | Deskripsi gambar ruangan |
| `created_at` | TIMESTAMP | Waktu pembuatan data |
| `updated_at` | TIMESTAMP | Waktu pembaruan data |

#### 3. 🗓️ Tabel: `reservations` (Pemesanan)
Mencatat setiap permintaan pemesanan ruangan.

**Struktur Tabel:**
| Field | Type | Keterangan |
|-------|------|------------|
| `id` | BIGINT UNSIGNED | **Primary Key** |
| `user_id` | BIGINT UNSIGNED | **Foreign Key** → `users.id` (pemesan) |
| `room_id` | BIGINT UNSIGNED | **Foreign Key** → `rooms.id` (ruangan) |
| `date` | DATE | Tanggal pemesanan |
| `start_time` | TIME | Waktu mulai pemakaian |
| `end_time` | TIME | Waktu selesai pemakaian |
| `purpose` | TEXT | Tujuan/keperluan pemesanan |
| `status` | ENUM('active','cancelled') | Status pemesanan (default: 'active') |
| `created_at` | TIMESTAMP | Waktu pembuatan data |
| `updated_at` | TIMESTAMP | Waktu pembaruan data |

**Relasi dan Constraints:**
- `ON DELETE CASCADE` pada foreign keys
- Data pemesanan terhapus otomatis jika user/room dihapus

---

## 🔄 Alur Logika Sistem

### Validasi Konflik Jadwal

Sistem mencegah konflik reservasi dengan mengecek tumpang tindih jadwal pada ruangan yang sama.

#### 🎯 Logika Deteksi Konflik
Konflik terjadi jika:
**Reservasi baru dimulai SEBELUM reservasi lama selesai, DAN**
**Reservasi baru berakhir SETELAH reservasi lama dimulai**

#### 📊 Contoh Skenario Konflik

| Reservasi Sistem | Reservasi Baru | Status |
|------------------|----------------|---------|
| 10:00–11:00 | 10:30–11:30 | ❌ **Bentrok** |
| 10:00–11:00 | 09:00–10:00 | ✅ Tidak bentrok |
| 10:00–11:00 | 11:00–12:00 | ✅ Tidak bentrok |
| 10:00–11:00 | 09:30–10:30 | ❌ **Bentrok** |

#### 💻 Implementasi Kode (Laravel)

```php
$conflict = Reservation::where('room_id', $request->room_id)
    ->where(function ($query) use ($start, $end) {
        $query->where('start_time', '<', $end)
              ->where('end_time', '>', $start);
    })
    ->exists();

if ($conflict) {
    return back()->withErrors(['msg' => 'Ruangan sudah dipesan pada waktu tersebut.'])->withInput();
}
```

#### 🔍 Penjelasan Kode:
- `where('room_id', $request->room_id)` - Cek hanya pada ruangan yang sama
- `start_time < end` - Awal reservasi baru sebelum jadwal lama berakhir
- `end_time > start` - Akhir reservasi baru setelah jadwal lama dimulai

#### ✅ Kesimpulan
Logika ini memastikan:
- Tidak terjadi double booking
- Data reservasi konsisten
- Jadwal ruang rapat tertata rapi

---

## 🤖 Dokumentasi AI

### Platform AI yang Digunakan:
- **ChatGPT & Gemini** - Backend development & analisis
- **Claude** - Frontend development & tampilan
- **Amazon** - Debugging & problem solving

### 📋 Strategi Prompt Engineering

#### 1. 🎯 PERENCANAAN AWAL
**Prompt:**
```
"Buat analisis rancangan lengkap sistem reservasi ruang rapat dengan spesifikasi:
- Role: User & Admin
- Fitur: Lihat ruang, reservasi, batalkan reservasi, riwayat
- Teknis: Laravel, MySQL, GUI, validasi bentrok jadwal
- Tema: Corporate merah-putih
Beri struktur database dan alur sistem"
```

**Hasil:** Analisis requirement, database schema, user flow diagram, teknologi stack

#### 2. ⚙️ IMPLEMENTASI BACKEND
**Prompt:**
```
"Buat struktur project Laravel lengkap untuk sistem reservasi dengan:
- Models: User, Room, Reservation
- Controllers dengan middleware
- Migrations & relationships
- Validasi reservasi (bentrok jadwal, jam kerja)
Sertakan kode lengkap setiap file"
```

**File yang Dihasilkan:**
- `User.php`, `Room.php`, `Reservation.php`
- `AuthController.php`, `AdminController.php`
- Migrations dengan foreign keys
- Middleware role-based

#### 3. 🎨 IMPLEMENTASI FRONTEND
**Prompt:**
```
"Rombak seluruh tampilan dengan tema corporate putih-merah yang aesthetic professional:
- Layout konsisten untuk semua halaman
- CSS terstruktur dengan design system
- Komponen reusable
- Responsive design
- Animasi smooth"
```

**Komponen yang Dibuat:**
- Layout utama & admin
- CSS variables system
- Component classes
- Responsive breakpoints
- Hover animations

#### 4. 🔗 INTEGRASI FULL-STACK
**Prompt:**
```
"Integrasikan semua bagian menjadi sistem yang utuh:
- Sesuaikan backend dengan frontend
- Pastikan konsistensi design
- Fix error dan bug
- Optimasi performance
- Testing flow lengkap"
```

### 🚀 Best Practices Prompt Engineering

#### ✅ DO's:
- **Spesifik & Terstruktur**
  ```
  ✅ "Buat sistem reservasi ruang rapat dengan fitur X, Y, Z menggunakan teknologi A, B, C"
  ```

- **Bertahap & Modular**
  ```
  1. "Analisis kebutuhan dan buat database design"
  2. "Implementasi backend dengan Laravel"
  3. "Buat frontend dengan design system"
  4. "Integrasikan dan testing"
  ```

- **Contoh Kode Lengkap**
  ```
  "Sertakan kode lengkap untuk Model User dengan:
  - Fillable attributes
  - Relationships
  - Custom methods
  - Validation rules"
  ```

#### ❌ DON'Ts:
- Request terlalu umum
- Gabungkan banyak fitur dalam satu prompt
- Asumsi pengetahuan AI
- Lupakan testing instructions

### 📝 Template Prompt Standard

#### Untuk Fitur Baru:
```
"Buat [nama fitur] untuk sistem reservasi dengan:
- Deskripsi: [jelaskan fungsionalitas]
- Teknologi: [Laravel/MySQL/Blade]
- Requirements: [spesifik kebutuhan]
- Integration: [bagaimana terhubung dengan existing system]
Beri kode lengkap dan penjelasan implementasi"
```

#### Untuk Debugging:
```
"Error Analysis:
- Error: [paste error]
- File: [file path]
- Context: [apa yang dilakukan saat error]
Request: Analisis root cause dan berikan fix lengkap"
```

### 🏆 Hasil Capaian

#### ✅ Fitur Sistem:
- Authentication system
- Role-based access control
- Room management
- Reservation dengan validasi konflik
- Admin dashboard
- Responsive design
- Professional UI/UX

#### 🛠️ Tech Stack:
- Laravel 10 + MySQL
- Blade templating
- Custom CSS design system
- Font Awesome icons
- Responsive grid layout

#### 📊 Kualitas Kode:
- Clean architecture
- Consistent naming
- Proper error handling
- Security implemented
- Performance optimized

---
