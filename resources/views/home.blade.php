<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Ruang Rapat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ANIMASI -->
    <style>
        @keyframes navbarFadeDown {
            0% { opacity: 0; transform: translateY(-25px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-navbarFadeDown { animation: navbarFadeDown .8s ease-out forwards; }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-logoFloat { animation: logoFloat 4s ease-in-out infinite; }

        @keyframes fadeSoft {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeSoft { animation: fadeSoft 1s ease-out forwards; }

        #navbar.nav-small {
            padding-top: 6px !important;
            padding-bottom: 6px !important;
            background-color: rgba(255,255,255,0.95);
            backdrop-blur: 14px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
            transition: all .3s ease;
        }

        .nav-item { 
            position: relative; 
            padding-bottom: 4px; 
        }
        .nav-item::after {
            content: "";
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg,#ff7a00,#ffb347,#ff7a00);
            border-radius: 2px;
            transition: width .35s ease;
        }
        .nav-item:hover::after, .nav-item.active::after { 
            width: 100%; 
        }

        html { scroll-behavior: smooth; }

        .room-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .placeholder-image {
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
    </style>
</head>
<body class="bg-[#f7f8fa] text-gray-800 font-sans">

<!-- NAVBAR -->
<nav id="navbar" class="fixed w-full z-50 bg-white/80 backdrop-blur-xl shadow-sm border-b border-gray-200 animate-navbarFadeDown transition-all duration-500">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="h-11 w-11 rounded-xl shadow-lg animate-logoFloat transition-transform duration-500 hover:scale-110 hover:drop-shadow-lg bg-red-600 flex items-center justify-center">
                <i class="fas fa-calendar-alt text-white text-lg"></i>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 animate-fadeSoft">
                <span class="text-gray-900">Ruang</span><span class="text-red-700">Rapat</span>
            </h1>
        </div>

        <div class="hidden md:flex space-x-10 text-lg font-medium">
            <a href="#jadwal" class="nav-item relative font-semibold">Jadwal</a>
            <a href="#fasilitas" class="nav-item relative font-semibold">Fasilitas</a>
            <a href="#lokasi" class="nav-item relative font-semibold">Lokasi</a>
        </div>

        <div class="hidden md:flex items-center space-x-4">
            <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl shadow-lg font-semibold hover:shadow-red-300 hover:-translate-y-1 animate-fadeSoft transition duration-300">Login</a>
            <a href="{{ route('register') }}" class="bg-white border border-red-600 text-red-700 px-6 py-2.5 rounded-xl shadow-lg font-semibold hover:bg-red-600 hover:text-white hover:shadow-red-300 hover:-translate-y-1 animate-fadeSoft transition duration-300">Registrasi</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="pt-40 pb-36 bg-cover bg-center relative" style="background-image:url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d');">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative max-w-5xl mx-auto px-6 text-center">
        <h2 class="text-5xl md:text-6xl font-extrabold text-white leading-tight mb-6 animate-fadeSoft">Solusi Reservasi Ruang Rapat Modern & Profesional</h2>
        <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto animate-fadeSoft">Sistem reservasi yang dirancang untuk efisiensi, kenyamanan, dan kecepatan. Booking ruang rapat kini menjadi jauh lebih mudah.</p>
        @auth
            <a href="{{ route('user.dashboard') }}" class="bg-white/95 text-red-700 px-10 py-4 rounded-2xl text-xl font-bold shadow-xl hover:bg-red-700 hover:text-white transition animate-fadeSoft">Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="bg-white/95 text-red-700 px-10 py-4 rounded-2xl text-xl font-bold shadow-xl hover:bg-red-700 hover:text-white transition animate-fadeSoft">Mulai Booking</a>
        @endauth
    </div>
</section>

<!-- JADWAL -->
<section id="jadwal" class="py-24 animate-fadeSoft">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h3 class="text-4xl font-bold text-gray-900 mb-6">Ruang Rapat Tersedia</h3>
        <p class="text-gray-600 mb-10 max-w-xl mx-auto">Pilih ruang rapat yang sesuai dengan kebutuhan meeting Anda.</p>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($rooms as $room)
            <div class="bg-white shadow-lg p-6 rounded-3xl text-gray-700 border border-gray-200 hover:shadow-xl transition-all duration-300">
                @if($room->image_path)
                    <img src="{{ asset('storage/' . $room->image_path) }}" alt="{{ $room->image_alt ?? $room->name }}" class="room-image rounded-xl mb-4">
                @else
                    <div class="placeholder-image rounded-xl mb-4">
                        <i class="fas fa-building"></i>
                    </div>
                @endif
                
                <h4 class="text-xl font-semibold mb-2 text-gray-900">{{ $room->name }}</h4>
                <p class="mb-2 text-gray-600"><i class="fas fa-map-marker-alt text-red-600 mr-2"></i><strong>Lokasi:</strong> {{ $room->location }}</p>
                <p class="mb-2 text-gray-600"><i class="fas fa-users text-red-600 mr-2"></i><strong>Kapasitas:</strong> {{ $room->capacity }} orang</p>
                <p class="mb-4 text-gray-600"><i class="fas fa-info-circle text-red-600 mr-2"></i>{{ Str::limit($room->description, 100) }}</p>
                
                @auth
                    <a href="{{ route('reservations.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-semibold transition duration-300 inline-block">
                        Pesan Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-xl font-semibold transition duration-300 inline-block">
                        Login untuk Memesan
                    </a>
                @endauth
            </div>
            @endforeach
        </div>
        
        @if($rooms->isEmpty())
            <div class="text-center py-8">
                <i class="fas fa-door-closed text-6xl text-gray-400 mb-4"></i>
                <p class="text-gray-500 text-xl">Tidak ada ruang rapat tersedia saat ini.</p>
            </div>
        @endif
    </div>
</section>

<!-- FASILITAS -->
<section id="fasilitas" class="py-24 bg-white animate-fadeSoft">
    <div class="max-w-7xl mx-auto px-6">
        <h3 class="text-4xl font-bold text-gray-900 text-center mb-14">Fasilitas Premium</h3>
        <div class="grid md:grid-cols-3 gap-10">
            <div class="p-10 bg-gray-50 shadow-md border border-gray-200 rounded-3xl text-center hover:shadow-xl transition-all duration-300">
                <div class="text-6xl mb-4 text-red-600">📽️</div>
                <h4 class="text-2xl font-semibold mb-3">Proyektor HD</h4>
                <p class="text-gray-600">Kualitas presentasi terbaik untuk kebutuhan meeting profesional.</p>
            </div>
            <div class="p-10 bg-gray-50 shadow-md border border-gray-200 rounded-3xl text-center hover:shadow-xl transition-all duration-300">
                <div class="text-6xl mb-4 text-red-600">📶</div>
                <h4 class="text-2xl font-semibold mb-3">WiFi Cepat</h4>
                <p class="text-gray-600">Koneksi stabil dan cepat untuk meeting hybrid.</p>
            </div>
            <div class="p-10 bg-gray-50 shadow-md border border-gray-200 rounded-3xl text-center hover:shadow-xl transition-all duration-300">
                <div class="text-6xl mb-4 text-red-600">❄️</div>
                <h4 class="text-2xl font-semibold mb-3">Ruangan Nyaman</h4>
                <p class="text-gray-600">AC, tata cahaya modern, dan suasana tenang.</p>
            </div>
        </div>
    </div>
</section>

<!-- LOKASI -->
<section id="lokasi" class="py-24 animate-fadeSoft">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h3 class="text-4xl font-bold mb-10 text-gray-900">Lokasi Kantor</h3>
        <p class="text-gray-600 mb-8 max-w-xl mx-auto">Kunjungi kantor kami untuk melakukan pengecekan ruangan atau konsultasi langsung.</p>
        <div class="shadow-2xl rounded-3xl overflow-hidden border border-gray-300 bg-white">
            <iframe class="w-full h-[420px]"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.965991180416!2d107.5853442!3d-6.8769119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7836ed029e5%3A0x87b73a85095a48ae!2sPT%20Kazee%20Digital%20Indonesia!5e0!3m2!1sid!2sid!4v1732126531333!5m2!1sid!2sid"
                loading="lazy"></iframe>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white py-8 animate-fadeSoft">
    <p class="text-center text-lg opacity-70">&copy; 2024 Reservasi Ruang Rapat — All Rights Reserved.</p>
</footer>

<!-- JS Navbar shrink + menu aktif -->
<script>
const navbar = document.getElementById('navbar');
const navItems = document.querySelectorAll('.nav-item');

window.addEventListener('scroll', () => {
    if(window.scrollY > 50) {
        navbar.classList.add('nav-small');
    } else {
        navbar.classList.remove('nav-small');
    }

    document.querySelectorAll('section[id]').forEach(section => {
        const top = window.scrollY + 150;
        const offset = section.offsetTop;
        const height = section.offsetHeight;
        const id = section.getAttribute('id');

        if(top >= offset && top < offset + height){
            navItems.forEach(item => item.classList.remove('active'));
            const activeItem = document.querySelector(`.nav-item[href="#${id}"]`);
            if(activeItem) activeItem.classList.add('active');
        }
    });
});
</script>

</body>
</html>