<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKAP - Sistem Kerja Praktik Universitas Bengkulu</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #0f1e56 0%, #15307f 50%, #1d4ed8 100%);
        }
        
        .floating {
            animation: floating 6s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translate(0, 0px) rotate(0deg); }
            50% { transform: translate(0, -20px) rotate(5deg); }
            100% { transform: translate(0, 0px) rotate(0deg); }
        }
        
        .pulse-slow {
            animation: pulse 4s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .blob {
            border-radius: 40% 60% 60% 40% / 70% 30% 70% 30%;
        }
        
        .text-gradient {
            background: linear-gradient(90deg, #1d4ed8, #a7d8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .moving-bg {
            background: linear-gradient(-45deg, #0f1e56, #15307f, #1d4ed8, #3b82f6);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Roadmap Styles */
        .roadmap-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .roadmap-line {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, #3b82f6, #8b5cf6, #ec4899);
            transform: translateX(-50%);
            z-index: 1;
        }
        
        .roadmap-item {
            position: relative;
            margin-bottom: 60px;
            width: 100%;
        }
        
        .roadmap-item:nth-child(odd) .roadmap-content {
            margin-left: auto;
            margin-right: 50px;
        }
        
        .roadmap-item:nth-child(even) .roadmap-content {
            margin-right: auto;
            margin-left: 50px;
        }
        
        .roadmap-dot {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 24px;
            height: 24px;
            background: white;
            border: 4px solid #3b82f6;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .roadmap-dot:hover {
            transform: translate(-50%, -50%) scale(1.2);
            box-shadow: 0 0 0 8px rgba(59, 130, 246, 0.2);
        }
        
        .roadmap-dot.active {
            background: #3b82f6;
            box-shadow: 0 0 0 8px rgba(59, 130, 246, 0.3);
        }
        
        .roadmap-content {
            width: calc(50% - 60px);
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .roadmap-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .roadmap-content::before {
            content: '';
            position: absolute;
            top: 50%;
            width: 20px;
            height: 20px;
            background: white;
            transform: translateY(-50%) rotate(45deg);
        }
        
        .roadmap-item:nth-child(odd) .roadmap-content::before {
            right: -10px;
        }
        
        .roadmap-item:nth-child(even) .roadmap-content::before {
            left: -10px;
        }
        
        .roadmap-step {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            font-weight: bold;
            margin-bottom: 16px;
        }
        
        .roadmap-date {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .roadmap-status {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .status-completed {
            background: #dcfce7;
            color: #166534;
        }
        
        .status-current {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-upcoming {
            background: #e0e7ff;
            color: #3730a3;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .roadmap-line {
                left: 30px;
            }
            
            .roadmap-dot {
                left: 30px;
            }
            
            .roadmap-content {
                width: calc(100% - 80px);
                margin-left: 80px !important;
                margin-right: 0 !important;
            }
            
            .roadmap-content::before {
                left: -10px !important;
                right: auto !important;
            }
            
            .roadmap-item:nth-child(odd) .roadmap-content,
            .roadmap-item:nth-child(even) .roadmap-content {
                margin-left: 80px;
                margin-right: 0;
            }
        }
        
        /* Progress Animation */
        .progress-bar {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
            margin: 40px 0;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border-radius: 2px;
            transition: width 1s ease-in-out;
            width: 0%;
        }
        
        /* Interactive Elements */
        .roadmap-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .roadmap-card:hover {
            transform: translateY(-5px);
        }
        
        .tooltip {
            position: relative;
        }
        
        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-white">
    <!-- Header/Navigation -->
    <header class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo-unib.PNG') }}" alt="SIKAP" class="h-10 w-auto">
                <span class="font-bold text-xl text-blue-800">SIKAP</span>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#tentang" class="text-gray-700 hover:text-blue-600 font-medium transition">Tentang</a>
                <a href="#fitur" class="text-gray-700 hover:text-blue-600 font-medium transition">Fitur</a>
                <a href="#timeline" class="text-gray-700 hover:text-blue-600 font-medium transition">Timeline</a>
                <a href="#roadmap" class="text-gray-700 hover:text-blue-600 font-medium transition">Alur KP</a>
                <a href="#faq" class="text-gray-700 hover:text-blue-600 font-medium transition">FAQ</a>
            </nav>
            
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-blue-700 hover:text-blue-800 font-medium transition">Masuk</a>
                <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-full font-medium shadow-md transition hover-lift">Daftar</a>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white py-4 px-6 shadow-lg">
            <div class="flex flex-col space-y-4">
                <a href="#tentang" class="text-gray-700 hover:text-blue-600 font-medium">Tentang</a>
                <a href="#fitur" class="text-gray-700 hover:text-blue-600 font-medium">Fitur</a>
                <a href="#timeline" class="text-gray-700 hover:text-blue-600 font-medium">Timeline</a>
                <a href="#roadmap" class="text-gray-700 hover:text-blue-600 font-medium">Alur KP</a>
                <a href="#faq" class="text-gray-700 hover:text-blue-600 font-medium">FAQ</a>
                <div class="pt-4 border-t border-gray-200 flex flex-col space-y-3">
                    <a href="{{ route('login') }}" class="text-blue-700 hover:text-blue-800 font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full font-medium text-center">Daftar</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section dengan Animasi Background -->
    <section class="moving-bg text-white pt-32 pb-20 overflow-hidden relative">
        <!-- Animated Background Elements -->
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-400/10 blob floating"></div>
        <div class="absolute top-40 -right-20 w-64 h-64 bg-purple-400/10 blob floating" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-1/3 w-56 h-56 bg-cyan-400/10 blob floating" style="animation-delay: 4s;"></div>
        
        <!-- Floating Icons -->
        <div class="absolute top-1/4 left-1/4 text-white/20 floating" style="animation-delay: 1s;">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        
        <div class="absolute bottom-1/3 right-1/4 text-white/20 floating" style="animation-delay: 3s;">
            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        Kelola Kerja Praktik <span class="text-gradient">Lebih Mudah</span> & Terintegrasi
                    </h1>
                    <p class="mt-6 text-blue-100 text-lg max-w-2xl">
                        Ajukan judul, pilih tempat magang, catat bimbingan & aktivitas, unggah laporan, dan isi kuesioner—semua dalam satu portal.
                    </p>
                    
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 rounded-xl font-semibold shadow-lg pulse-slow glow inline-flex items-center justify-center transition hover-lift">
                            <span>Daftar Sekarang</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="#fitur" class="px-6 py-3 border border-white/30 text-white/90 hover:bg-white/10 rounded-xl font-medium inline-flex items-center justify-center transition hover-lift">
                            <span>Pelajari Fitur</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                    </div>
                    
                    <div class="mt-12 flex flex-wrap gap-6 items-center justify-center lg:justify-start">
                        <div class="text-center">
                            <div class="text-2xl font-bold">500+</div>
                            <div class="text-blue-200 text-sm">Mahasiswa Terdaftar</div>
                        </div>
                        <div class="h-10 w-px bg-white/20"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">50+</div>
                            <div class="text-blue-200 text-sm">Instansi Mitra</div>
                        </div>
                        <div class="h-10 w-px bg-white/20"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">98%</div>
                            <div class="text-blue-200 text-sm">Kepuasan Pengguna</div>
                        </div>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                    <div class="relative">
                        <!-- Main Dashboard Illustration -->
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 shadow-2xl border border-white/20 hover-lift transition">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-3 h-3 rounded-full bg-red-400"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                                <span class="w-3 h-3 rounded-full bg-green-400"></span>
                                <span class="text-sm text-white/70 ml-auto">Dashboard SIKAP</span>
                            </div>
                            
                            <!-- Animated Dashboard Content -->
                            <div class="relative h-80 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl overflow-hidden">
                                <!-- Sidebar -->
                                <div class="absolute left-0 top-0 w-16 h-full bg-white shadow-sm flex flex-col items-center py-4 space-y-6">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <div class="w-4 h-4 bg-blue-500 rounded"></div>
                                    </div>
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg"></div>
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg"></div>
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg"></div>
                                </div>
                                
                               <!-- Header -->
                                <div class="absolute left-16 top-0 right-0 h-12 bg-white/10 backdrop-blur-sm border-b border-white/10"></div>
                                
                                <!-- Content Area -->
                                <div class="absolute left-16 top-12 right-0 bottom-0 p-4">
                                    <!-- Cards Grid -->
                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/10">
                                            <div class="h-2 w-1/2 bg-blue-200/50 rounded mb-2"></div>
                                            <div class="h-2 w-3/4 bg-white/30 rounded"></div>
                                        </div>
                                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/10">
                                            <div class="h-2 w-1/2 bg-green-200/50 rounded mb-2"></div>
                                            <div class="h-2 w-3/4 bg-white/30 rounded"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Chart Area -->
                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/10 h-24 mb-4">
                                        <div class="flex items-end h-16 gap-1">
                                            <div class="w-1/6 h-1/3 bg-blue-400/50 rounded-t"></div>
                                            <div class="w-1/6 h-2/3 bg-blue-500/50 rounded-t"></div>
                                            <div class="w-1/6 h-full bg-blue-600/50 rounded-t"></div>
                                            <div class="w-1/6 h-2/3 bg-blue-500/50 rounded-t"></div>
                                            <div class="w-1/6 h-1/3 bg-blue-400/50 rounded-t"></div>
                                            <div class="w-1/6 h-1/2 bg-blue-500/50 rounded-t"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Table -->
                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/10">
                                        <div class="h-2 w-1/3 bg-white/30 rounded mb-3"></div>
                                        <div class="space-y-2">
                                            <div class="h-2 w-full bg-white/20 rounded"></div>
                                            <div class="h-2 w-5/6 bg-white/20 rounded"></div>
                                            <div class="h-2 w-4/6 bg-white/20 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Elements -->
                        <div class="absolute -right-6 -top-6 bg-white rounded-xl p-4 shadow-lg border" data-aos="fade-down" data-aos-delay="600">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                                <span class="text-sm font-medium text-gray-700">Status Aktif</span>
                            </div>
                            <div class="mt-1 text-xs text-gray-500">KP Berjalan: 42</div>
                        </div>
                        
                        <div class="absolute -left-6 -bottom-6 bg-white rounded-xl p-4 shadow-lg border" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Terverifikasi</div>
                                    <div class="text-xs text-gray-500">Proses Cepat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4" data-aos="fade-up">Apa itu <span class="text-blue-600">SIKAP</span>?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-16 text-lg" data-aos="fade-up" data-aos-delay="100">
                Sistem Informasi Kerja Praktik (SIKAP) adalah platform web yang mengelola seluruh proses Kerja Praktik mahasiswa secara terintegrasi, efisien, dan transparan. Sistem ini mendigitalisasi tahapan KP agar lebih cepat, rapi, dan terdokumentasi dengan baik.

            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-blue-100 hover-lift" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 mx-auto bg-blue-100 rounded-2xl flex items-center justify-center mb-6 floating" style="animation-duration: 4s;">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Terstruktur</h3>
                    <p class="text-gray-600">
                        Alur terdefinisi, dan log aktivitas membantu menghindari kebingungan administrasi.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-gradient-to-br from-white to-orange-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-orange-100 hover-lift" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 mx-auto bg-orange-100 rounded-2xl flex items-center justify-center mb-6 floating" style="animation-duration: 4s; animation-delay: 1s;">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Koneksi Dosen & Industri</h3>
                    <p class="text-gray-600">
                        Memudahkan kolaborasi antara kampus dan mitra industri untuk penempatan KP.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-gradient-to-br from-white to-green-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-green-100 hover-lift" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-20 h-20 mx-auto bg-green-100 rounded-2xl flex items-center justify-center mb-6 floating" style="animation-duration: 4s; animation-delay: 2s;">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Manajemen Data Terstruktur</h3>
                    <p class="text-gray-600">
                        Seluruh informasi dan proses Kerja Praktik tercatat rapi dalam sistem, sehingga mudah dipantau dan dikelola.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl text-center font-bold text-gray-900 mb-4" data-aos="fade-up">Fitur Unggulan</h2>
            <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="100">
                Platform lengkap untuk mendukung proses Kerja Praktik Anda.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group hover-lift" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-lg">Pengajuan Online</h4>
                            <p class="text-gray-600 mt-2">Ajukan judul dan tempat KP secara digital dengan proses yang cepat dan mudah.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group hover-lift" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-orange-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-lg">Bimbingan Terstruktur</h4>
                            <p class="text-gray-600 mt-2">Log bimbingan dan jejak aktivitas lapangan yang terorganisir dengan baik.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group hover-lift" data-aos="fade-up" data-aos-delay="400">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-lg">Verifikasi Prodi</h4>
                            <p class="text-gray-600 mt-2">Alur verifikasi otomatis dari Program Studi dan penugasan pembimbing yang efisien.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group hover-lift" data-aos="fade-up" data-aos-delay="500">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-lg">Laporan & Kuesioner</h4>
                            <p class="text-gray-600 mt-2">Unggah laporan dan isi kuesioner pasca-KP dalam satu tempat yang tersentral.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group hover-lift" data-aos="fade-up" data-aos-delay="600">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-indigo-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-lg">Monitoring Aktifitas</h4>
                            <p class="text-gray-600 mt-2">Pantau perkembangan KP mahasiswa secara real-time dengan dashboard interaktif.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group hover-lift" data-aos="fade-up" data-aos-delay="700">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-pink-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-lg">Keamanan Data</h4>
                            <p class="text-gray-600 mt-2">Data dan dokumen KP terlindungi dengan sistem keamanan berlapis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section id="timeline" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl text-center font-bold text-gray-900 mb-4" data-aos="fade-up">Timeline Kerja Praktik</h2>
            <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="100">
                Periode pelaksanaan Kerja Praktik untuk semester ini
            </p>
            
            <div class="relative" data-aos="fade-up" data-aos-delay="200">
                <!-- Timeline Bar -->
                <div class="h-2 bg-gray-200 rounded-full mb-8 relative">
                    <div class="absolute top-0 left-0 h-full bg-blue-500 rounded-full" style="width: 5%"></div>
                    <div class="absolute top-1/2 left-0 w-full flex justify-between transform -translate-y-1/2">
                        <div class="w-4 h-4 bg-blue-500 rounded-full border-4 border-white shadow"></div>
                        <div class="w-4 h-4 bg-blue-500 rounded-full border-4 border-white shadow"></div>
                        <div class="w-4 h-4 bg-blue-500 rounded-full border-4 border-white shadow"></div>
                        <div class="w-4 h-4 bg-gray-300 rounded-full border-4 border-white shadow"></div>
                        <div class="w-4 h-4 bg-gray-300 rounded-full border-4 border-white shadow"></div>
                    </div>
                </div>
                
                <!-- Timeline Labels -->
                <div class="grid grid-cols-5 gap-4 text-center">
                    <div>
                        <div class="font-semibold text-gray-900">4-20 Des</div>
                        <div class="text-sm text-gray-500">Pengajuan</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">21-27 Des</div>
                        <div class="text-sm text-gray-500">Verifikasi</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">1 Jan</div>
                        <div class="text-sm text-gray-500">Mulai KP</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">1 Feb</div>
                        <div class="text-sm text-gray-500">Laporan</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">28 Feb</div>
                        <div class="text-sm text-gray-500">Selesai</div>
                    </div>
                </div>
                
                <!-- Current Date Marker -->
                <div class="absolute top-0 left-3/5 transform -translate-x-1/2 -translate-y-1/2" style="left: 5%;">
                    <div class="bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">
                        Sekarang
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
                <div class="bg-blue-50 rounded-2xl p-6 text-center hover-lift transition" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-3xl font-bold text-blue-600 mb-2">5%</div>
                    <div class="text-gray-700">Progress Semester Ini</div>
                </div>
                <div class="bg-green-50 rounded-2xl p-6 text-center hover-lift transition" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-3xl font-bold text-green-600 mb-2">85</div>
                    <div class="text-gray-700">Hari Tersisa</div>
                </div>
                <div class="bg-purple-50 rounded-2xl p-6 text-center hover-lift transition" data-aos="fade-up" data-aos-delay="500">
                    <div class="text-3xl font-bold text-purple-600 mb-2">65</div>
                    <div class="text-gray-700">Mahasiswa Aktif</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Roadmap Section -->
    <section id="roadmap" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl text-center font-bold text-gray-900 mb-4" data-aos="fade-up">Alur Kerja Praktik</h2>
            <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="100">
                Jelajahi setiap tahapan proses Kerja Praktik dari awal hingga akhir
            </p>
            
            <!-- Progress Bar -->
            <div class="progress-bar mb-16" data-aos="fade-up" data-aos-delay="200">
                <div class="progress-fill" id="roadmap-progress" style="width: 5%"></div>
            </div>
            
            <!-- Interactive Roadmap -->
            <div class="roadmap-container">
                <div class="roadmap-line"></div>
                
                <!-- Step 1 -->
                <div class="roadmap-item" data-aos="fade-right" data-aos-delay="300">
                    <div class="roadmap-dot active tooltip" data-tooltip="Tahap 1: Pengajuan" onclick="showStepDetails(1)"></div>
                    <div class="roadmap-content roadmap-card">
                        <div class="roadmap-step">1</div>
                        <div class="roadmap-date">Minggu 1-3</div>
                        <div class="roadmap-status status-current">Sedang Berjalan</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Pengajuan Judul & Tempat</h3>
                        <p class="text-gray-600 mb-4">
                            Ajukan judul KP dan pilih tempat magang melalui platform SIKAP. 
                            Pilih dari daftar mitra prodi atau ajukan tempat mandiri.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Durasi: 17 hari
                        </div>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="roadmap-item" data-aos="fade-left" data-aos-delay="400">
                    <div class="roadmap-dot tooltip" data-tooltip="Tahap 2: Verifikasi" onclick="showStepDetails(2)"></div>
                    <div class="roadmap-content roadmap-card">
                        <div class="roadmap-step">2</div>
                        <div class="roadmap-date">Minggu 4</div>
                        <div class="roadmap-status status-upcoming">Akan Datang</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Verifikasi Prodi</h3>
                        <p class="text-gray-600 mb-4">
                            Prodi memverifikasi kelayakan judul dan tempat, kemudian menetapkan dosen pembimbing.
                            Proses otomatis dengan notifikasi real-time.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Durasi: 7 hari
                        </div>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="roadmap-item" data-aos="fade-right" data-aos-delay="500">
                    <div class="roadmap-dot tooltip" data-tooltip="Tahap 3: Bimbingan" onclick="showStepDetails(3)"></div>
                    <div class="roadmap-content roadmap-card">
                        <div class="roadmap-step">3</div>
                        <div class="roadmap-date">Minggu 5-8</div>
                        <div class="roadmap-status status-upcoming">Akan Datang</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Pelaksanaan & Bimbingan</h3>
                        <p class="text-gray-600 mb-4">
                            Mulai kerja praktik di instansi mitra. Catat log harian aktivitas dan lakukan 
                            bimbingan berkala dengan dosen pembimbing melalui platform.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Durasi: 30 hari
                        </div>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="roadmap-item" data-aos="fade-left" data-aos-delay="600">
                    <div class="roadmap-dot tooltip" data-tooltip="Tahap 4: Laporan" onclick="showStepDetails(4)"></div>
                    <div class="roadmap-content roadmap-card">
                        <div class="roadmap-step">4</div>
                        <div class="roadmap-date">Minggu 9-11</div>
                        <div class="roadmap-status status-upcoming">Akan Datang</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Unggah Laporan</h3>
                        <p class="text-gray-600 mb-4">
                            Upload laporan akhir KP dan lakukan revisi sesuai masukan dari dosen pembimbing.
                            Sistem akan mencatat semua versi revisi.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Durasi: 14 hari
                        </div>
                    </div>
                </div>
                
                <!-- Step 5 -->
                <div class="roadmap-item" data-aos="fade-right" data-aos-delay="700">
                    <div class="roadmap-dot tooltip" data-tooltip="Tahap 5: Penilaian" onclick="showStepDetails(5)"></div>
                    <div class="roadmap-content roadmap-card">
                        <div class="roadmap-step">5</div>
                        <div class="roadmap-date">Minggu 11-13</div>
                        <div class="roadmap-status status-upcoming">Akan Datang</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Penilaian & Kuesioner</h3>
                        <p class="text-gray-600 mb-4">
                            Dosen melakukan penilaian akhir dan mahasiswa mengisi kuesioner evaluasi KP.
                            Hasil dapat diakses langsung di dashboard.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Durasi: 14 hari
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Step Details Modal -->
            <div id="step-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-2xl p-8 max-w-md mx-4 max-h-90vh overflow-y-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h3 id="modal-title" class="text-2xl font-bold text-gray-900"></h3>
                        <button onclick="closeStepDetails()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="modal-content" class="text-gray-600">
                        <!-- Content will be loaded dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6" data-aos="fade-up">Pertanyaan Umum</h2>
                <div class="space-y-4">
                    <details class="bg-gray-50 p-5 rounded-xl hover-lift transition" data-aos="fade-up" data-aos-delay="100">
                        <summary class="font-semibold text-gray-900 cursor-pointer flex justify-between items-center">
                            <span>Apakah SIKAP gratis untuk mahasiswa?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="mt-3 text-gray-600 pl-4 border-l-4 border-blue-500">Ya—platform ini disediakan gratis untuk seluruh mahasiswa Universitas Bengkulu sebagai bagian dari layanan kampus.</p>
                    </details>

                    <details class="bg-gray-50 p-5 rounded-xl hover-lift transition" data-aos="fade-up" data-aos-delay="200">
                        <summary class="font-semibold text-gray-900 cursor-pointer flex justify-between items-center">
                            <span>Bagaimana jika lupa password akun?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="mt-3 text-gray-600 pl-4 border-l-4 border-blue-500">Gunakan fitur 'Lupa Password' pada halaman login. Sistem akan mengirimkan tautan reset ke email kampus Anda.</p>
                    </details>

                    <details class="bg-gray-50 p-5 rounded-xl hover-lift transition" data-aos="fade-up" data-aos-delay="300">
                        <summary class="font-semibold text-gray-900 cursor-pointer flex justify-between items-center">
                            <span>Apakah saya bisa memilih tempat KP sendiri?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="mt-3 text-gray-600 pl-4 border-l-4 border-blue-500">Ya, tersedia opsi pengajuan mandiri atau memilih dari daftar mitra prodi yang telah bekerja sama dengan universitas.</p>
                    </details>

                    <details class="bg-gray-50 p-5 rounded-xl hover-lift transition" data-aos="fade-up" data-aos-delay="400">
                        <summary class="font-semibold text-gray-900 cursor-pointer flex justify-between items-center">
                            <span>Berapa lama proses verifikasi pengajuan KP?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="mt-3 text-gray-600 pl-4 border-l-4 border-blue-500">Biasanya membutuhkan waktu 3-5 hari kerja, tergantung kelengkapan dokumen dan ketersediaan dosen pembimbing.</p>
                    </details>
                </div>
            </div>

            <div class="relative">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-8 rounded-2xl shadow-lg hover-lift transition" data-aos="fade-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Butuh Bantuan Langsung?</h3>
                    <p class="text-gray-600 mb-6">Tim support kami siap membantu Anda melalui berbagai channel komunikasi.</p>

                    <div class="space-y-4">
                        <a href="mailto:support@sikap.unib.ac.id" class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Email Support</div>
                                <div class="text-sm text-gray-500">support@sikap.unib.ac.id</div>
                            </div>
                        </a>

                        <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">WhatsApp</div>
                                <div class="text-sm text-gray-500">+62 812-3456-7890</div>
                            </div>
                        </a>

                        <div class="flex items-center p-4 bg-white rounded-xl shadow-sm">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Lokasi</div>
                                <div class="text-sm text-gray-500">Gedung SI, Universitas Bengkulu</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Chat Button -->
                <a href="https://wa.me/6282272425184" target="_blank"
                   class="fixed right-6 bottom-6 z-50 bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 pulse-slow"
                   title="Chat Admin" data-aos="zoom-in" data-aos-delay="500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 moving-bg text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6" data-aos="fade-up">Siap Memulai Kerja Praktik Anda?</h2>
            <p class="text-blue-100 text-lg mb-10 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Daftar sekarang dan nikmati proses KP yang lebih cepat, terstruktur, dan tercatat dengan rapi.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-orange-500 hover:bg-orange-600 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl transition glow pulse-slow inline-flex items-center justify-center hover-lift">
                    <span>Daftar Sekarang</span>
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="{{ route('login') }}" class="px-8 py-4 border border-white/30 text-white/90 hover:bg-white/10 rounded-xl font-medium text-lg transition inline-flex items-center justify-center hover-lift">
                    <span>Masuk ke Akun</span>
                </a>
            </div>
            
            <p class="mt-8 text-blue-200 text-sm" data-aos="fade-up" data-aos-delay="300">
                Sudah digunakan oleh 100+ mahasiswa dan 30+ instansi mitra
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#07103a] text-white py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('logo-unib.PNG') }}" alt="SIKAP" class="h-10 w-auto">
                        <span class="font-bold text-xl">SIKAP</span>
                    </div>
                    <p class="text-white/70 mb-6 max-w-md">
                        Sistem Informasi Kerja Praktik Universitas Bengkulu. Platform terpadu untuk mengelola semua kebutuhan Kerja Praktik mahasiswa.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="text-white/70 hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-white/70 hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-white/70 hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="#tentang" class="text-white/70 hover:text-white transition">Tentang SIKAP</a></li>
                        <li><a href="#fitur" class="text-white/70 hover:text-white transition">Fitur</a></li>
                        <li><a href="#timeline" class="text-white/70 hover:text-white transition">Timeline</a></li>
                        <li><a href="#roadmap" class="text-white/70 hover:text-white transition">Alur KP</a></li>
                        <li><a href="#faq" class="text-white/70 hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Kontak</h3>
                    <ul class="space-y-2 text-white/70">
                        <li>Universitas Bengkulu</li>
                        <li>Jalan WR. Supratman, Kandang Limun</li>
                        <li>Bengkulu 38371</li>
                        <li>support@sikap.unib.ac.id</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-white/10 mt-8 pt-8 text-center text-white/60 text-sm">
                &copy; {{ date('Y') }} SIKAP — Universitas Bengkulu. Semua hak dilindungi.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                mirror: false,
                offset: 100
            });
            
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        // Close mobile menu if open
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                        
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Animate FAQ arrows
            document.querySelectorAll('details').forEach(detail => {
                detail.addEventListener('toggle', function() {
                    const arrow = this.querySelector('svg');
                    if (this.open) {
                        arrow.style.transform = 'rotate(180deg)';
                    } else {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                });
            });
            
            // Roadmap progress animation
            setTimeout(() => {
                const progressFill = document.getElementById('roadmap-progress');
                if (progressFill) {
                    progressFill.style.width = '60%';
                }
            }, 500);
        });
        
        // Roadmap interactive functions
        function showStepDetails(stepNumber) {
            const modal = document.getElementById('step-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalContent = document.getElementById('modal-content');
            
            const stepDetails = {
                1: {
                    title: "Pengajuan Judul & Tempat",
                    content: `
                        <p class="mb-4">Tahap ini merupakan langkah awal dalam proses Kerja Praktik. Mahasiswa dapat:</p>
                        <ul class="list-disc list-inside mb-4 space-y-2">
                            <li>Mengajukan judul KP yang sesuai dengan minat dan kompetensi</li>
                            <li>Memilih tempat magang dari daftar mitra prodi atau mengajukan tempat mandiri</li>
                            <li>Mengunggah dokumen pendukung yang diperlukan</li>
                            <li>Melakukan konsultasi awal dengan koordinator KP</li>
                        </ul>
                        <p><strong>Durasi:</strong> 17 hari</p>
                        <p><strong>Dokumen yang diperlukan:</strong> Form pengajuan, CV, transkrip nilai</p>
                    `
                },
                2: {
                    title: "Verifikasi Prodi",
                    content: `
                        <p class="mb-4">Proses verifikasi dilakukan oleh Program Studi untuk memastikan:</p>
                        <ul class="list-disc list-inside mb-4 space-y-2">
                            <li>Kelayakan judul KP yang diajukan</li>
                            <li>Kesesuaian tempat magang dengan kompetensi mahasiswa</li>
                            <li>Ketersediaan dosen pembimbing</li>
                            <li>Kelengkapan dokumen administrasi</li>
                        </ul>
                        <p class="mb-4">Setelah verifikasi berhasil, sistem akan secara otomatis:</p>
                        <ul class="list-disc list-inside mb-4 space-y-2">
                            <li>Menetapkan dosen pembimbing</li>
                            <li>Mengirimkan informasi ke mahasiswa</li>
                            <li>Membuat jadwal bimbingan awal</li>
                        </ul>
                        <p><strong>Durasi:</strong> 7 hari</p>
                    `
                },
                3: {
                    title: "Pelaksanaan & Bimbingan",
                    content: `
                        <p class="mb-4">Tahap pelaksanaan KP di instansi mitra dengan monitoring terstruktur:</p>
                        <ul class="list-disc list-inside mb-4 space-y-2">
                            <li>Mulai kerja praktik sesuai jadwal yang ditetapkan</li>
                            <li>Mencatat log harian aktivitas melalui platform</li>
                            <li>Melakukan bimbingan berkala dengan dosen pembimbing</li>
                            <li>Mengikuti progress review setiap 2 minggu</li>
                            <li>Menyelesaikan tugas dan proyek yang diberikan</li>
                        </ul>
                        <p class="mb-4">Fitur monitoring yang tersedia:</p>
                        <ul class="list-disc list-inside mb-4 space-y-2">
                            <li>Dashboard aktivitas harian</li>
                            <li>Catatan bimbingan online</li>
                            <li>Progress tracking otomatis</li>
                        </ul>
                        <p><strong>Durasi:</strong> 30 hari</p>
                    `
                },
                4: {
                    title: "Unggah Laporan",
                    content: `
                        <p class="mb-4">Tahap penyusunan dan pengumpulan laporan akhir KP:</p>
                        <ul class="list-disc list-inside mb-4 space-y-2">
                            <li>Menyusun laporan sesuai format yang ditetapkan</li>
                            <li>Mengunggah draft laporan melalui platform</li>
                            <li>Menerima masukan dan revisi dari dosen pembimbing</li>
                            <li>Mengunggah versi final laporan</li>
                            <li>Mendapatkan persetujuan final dari pembimbing</li>
                        </ul>
                        <p><strong>Durasi:</strong> 14 hari</p>
                    `
                },
                5: {
                    title: "Penilaian & Kuesioner",
                    content: `
                        <p class="mb-4">Tahap akhir proses Kerja Praktik:</p>
                        <ul class="list-disc list-inside mb-4 space-y-2">
                            <li>Dosen pembimbing melakukan penilaian akhir</li>
                            <li>Pembimbing industri memberikan evaluasi</li>
                            <li>Mahasiswa mengisi kuesioner evaluasi KP</li>
                            <li>Sistem menghitung nilai akhir secara otomatis</li>
                            <li>Penerbitan sertifikat dan transkrip nilai</li>
                        </ul>
                        <p class="mb-4">Hasil yang dapat diakses:</p>
                        <ul class="list-disc list-inside mb-4 space-y-2">
                            <li>Nilai akhir KP</li>
                            <li>Sertifikat penyelesaian KP</li>
                            <li>Laporan evaluasi dari pembimbing</li>
                            <li>Rekomendasi untuk pengembangan selanjutnya</li>
                        </ul>
                        <p><strong>Durasi:</strong> 14 hari</p>
                    `
                }
            };
            
            if (stepDetails[stepNumber]) {
                modalTitle.textContent = stepDetails[stepNumber].title;
                modalContent.innerHTML = stepDetails[stepNumber].content;
                modal.classList.remove('hidden');
            }
        }
        
        function closeStepDetails() {
            const modal = document.getElementById('step-modal');
            modal.classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('step-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStepDetails();
            }
        });
    </script>
</body>
</html>