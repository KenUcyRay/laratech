<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaraTech - Dashboard Selection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Header -->
    <header class="bg-white/10 backdrop-blur-sm border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-blue-600 font-bold text-xl">L</span>
                    </div>
                    <h1 class="text-white text-2xl font-bold">LaraTech</h1>
                </div>
                <a href="{{ route('login') }}" class="bg-white/20 hover:bg-white/30 text-white px-6 py-2 rounded-full transition-colors">
                    Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Pilih Dashboard Anda
            </h2>
            <p class="text-xl text-white/80 max-w-2xl mx-auto">
                Akses sistem manajemen peralatan sesuai dengan peran dan tanggung jawab Anda
            </p>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Admin Dashboard -->
            <div class="card-hover bg-white rounded-2xl p-8 text-center shadow-xl">
                <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Admin Dashboard</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Kelola seluruh sistem, pengguna, dan konfigurasi. Akses penuh untuk administrasi platform.
                </p>
                <ul class="text-sm text-gray-500 mb-8 space-y-2">
                    <li>✓ Manajemen Pengguna</li>
                    <li>✓ Konfigurasi Sistem</li>
                    <li>✓ Laporan Lengkap</li>
                    <li>✓ Pengaturan Keamanan</li>
                </ul>
                <a href="{{ route('login') }}?role=admin" class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-xl transition-all">
                    Masuk sebagai Admin
                </a>
            </div>

            <!-- Operator Dashboard -->
            <div class="card-hover bg-white rounded-2xl p-8 text-center shadow-xl">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Operator Dashboard</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Pantau operasional harian, kelola tugas, dan koordinasi dengan tim teknis.
                </p>
                <ul class="text-sm text-gray-500 mb-8 space-y-2">
                    <li>✓ Monitoring Peralatan</li>
                    <li>✓ Manajemen Tugas</li>
                    <li>✓ Koordinasi Tim</li>
                    <li>✓ Laporan Operasional</li>
                </ul>
                <a href="{{ route('login') }}?role=operator" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all">
                    Masuk sebagai Operator
                </a>
            </div>

            <!-- Mechanic Dashboard -->
            <div class="card-hover bg-white rounded-2xl p-8 text-center shadow-xl">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Mekanik Dashboard</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Kelola perbaikan, maintenance, dan dokumentasi teknis peralatan.
                </p>
                <ul class="text-sm text-gray-500 mb-8 space-y-2">
                    <li>✓ Jadwal Maintenance</li>
                    <li>✓ Riwayat Perbaikan</li>
                    <li>✓ Dokumentasi Teknis</li>
                    <li>✓ Status Peralatan</li>
                </ul>
                <a href="{{ route('login') }}?role=mekanik" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-all">
                    Masuk sebagai Mekanik
                </a>
            </div>
        </div>

        <!-- Features Section -->
        <div class="mt-20 text-center">
            <h3 class="text-2xl font-bold text-white mb-8">Fitur Unggulan LaraTech</h3>
            <div class="grid md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-white">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold mb-2">Real-time Monitoring</h4>
                    <p class="text-sm text-white/80">Pantau status peralatan secara real-time</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-white">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold mb-2">Analytics</h4>
                    <p class="text-sm text-white/80">Analisis performa dan efisiensi</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-white">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold mb-2">Secure</h4>
                    <p class="text-sm text-white/80">Keamanan data terjamin</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-white">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold mb-2">User Friendly</h4>
                    <p class="text-sm text-white/80">Interface yang mudah digunakan</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/10 backdrop-blur-sm border-t border-white/20 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-white/60">
                <p>&copy; 2024 LaraTech. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>