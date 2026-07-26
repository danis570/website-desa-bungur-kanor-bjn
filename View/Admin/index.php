<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxe Dashboard</title>

    <!-- Fonts: Montserrat (Sans) & Playfair Display (Serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Iconify -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.7/dist/iconify-icon.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#5802f7',
                        secondary: '#f3f0ff',
                        dark: '#1a1a1a',
                        pastelBlue: '#eef2ff',
                        pastelPurple: '#f5f3ff',
                    },
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Glassmorphism Utilities */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Chart Tooltip Customization */
        #chartjs-tooltip {
            opacity: 1;
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            color: black;
            border-radius: 8px;
            pointer-events: none;
            transform: translate(-50%, 0);
            transition: all .1s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-600 font-sans antialiased overflow-x-hidden">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar-transition fixed inset-y-0 left-0 z-50 w-64 bg-white/90 backdrop-blur-xl border-r border-slate-100 transform -translate-x-full md:relative md:translate-x-0 flex flex-col justify-between shadow-[4px_0_24px_rgba(0,0,0,0.02)]">

            <!-- ==========================================================
                LOGO
            =========================================================== -->
            <div class="h-20 flex items-center px-8 border-b border-slate-50">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 flex items-center justify-center">

                        <img src="assets/logo-bojonegoro.png" alt="Logo Desa Bungur"
                            class="w-10 h-10 object-contain">

                    </div>
                    <div>

                        <h2 class="font-bold text-slate-800 leading-none">
                            Desa Bungur
                        </h2>

                        <p class="text-xs text-slate-500 mt-1">
                            Admin Panel
                        </p>

                    </div>

                </div>

            </div>


            <!-- ==========================================================
        MENU
    =========================================================== -->

            <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-1">

                <p class="px-4 mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Dashboard
                </p>

                <!-- Dashboard -->

                <a href="#"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary font-semibold">

                    <iconify-icon icon="solar:widget-5-linear" width="20"></iconify-icon>

                    Dashboard

                </a>


                <!-- ===================================================== -->

                <p class="px-4 mt-8 mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Konten Website
                </p>

                <!-- Artikel -->

                <a href="#"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 hover:text-primary transition">

                    <iconify-icon icon="solar:document-text-linear" width="20"></iconify-icon>

                    Artikel

                </a>

                <!-- Galeri -->

                <a href="#"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 hover:text-primary transition">

                    <iconify-icon icon="solar:gallery-linear" width="20"></iconify-icon>

                    Galeri Foto

                </a>

                <!-- UMKM -->

                <a href="#"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 hover:text-primary transition">

                    <iconify-icon icon="solar:shop-linear" width="20"></iconify-icon>

                    UMKM

                </a>

                <!-- Demografi -->

                <a href="#"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 hover:text-primary transition">

                    <iconify-icon icon="solar:users-group-rounded-linear" width="20"></iconify-icon>

                    Demografi

                </a>


                <!-- ===================================================== -->

                <p class="px-4 mt-8 mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">

                    Profil Desa

                </p>

                <!-- Dropdown -->

                <details class="group">

                    <summary
                        class="flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer hover:bg-slate-50 list-none">

                        <div class="flex items-center gap-3">

                            <iconify-icon icon="solar:buildings-2-linear" width="20"></iconify-icon>

                            <span>Profil Desa</span>

                        </div>

                        <iconify-icon class="transition group-open:rotate-180"
                            icon="solar:alt-arrow-down-linear"></iconify-icon>

                    </summary>

                    <div class="mt-2 ml-8 flex flex-col">

                        <a href="#" class="py-2 text-slate-500 hover:text-primary">
                            Sejarah Desa
                        </a>

                        <a href="#" class="py-2 text-slate-500 hover:text-primary">
                            Visi & Misi
                        </a>

                        <a href="#" class="py-2 text-slate-500 hover:text-primary">
                            Aparatur Desa
                        </a>

                    </div>

                </details>


                <!-- ===================================================== -->

                <p class="px-4 mt-8 mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Pengguna
                </p>

                <a href="#"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 hover:text-primary transition">

                    <iconify-icon icon="solar:user-rounded-linear" width="20"></iconify-icon>

                    Pengguna

                </a>

            </nav>


            <!-- ==========================================================
        BOTTOM
    =========================================================== -->

            <div class="p-4 border-t border-slate-100">

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 transition">

                    <iconify-icon icon="solar:settings-linear" width="20"></iconify-icon>

                    Pengaturan

                </a>

                <a href="#"
                    class="mt-2 flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 hover:text-red-500 transition">

                    <iconify-icon icon="solar:logout-2-linear" width="20"></iconify-icon>

                    Keluar

                </a>

            </div>

        </aside>

        <!-- Overlay for Mobile -->
        <div id="sidebar-overlay" onclick="toggleSidebar()"
            class="fixed inset-0 bg-dark/20 backdrop-blur-sm z-40 hidden md:hidden transition-opacity opacity-0"></div>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col relative overflow-y-auto overflow-x-hidden scroll-smooth">

            <!-- Header -->
            <header
                class="sticky flex glass md:px-10 md:pt-3 md:pb-3 h-20 z-30 pt-3 pr-6 pb-3 pl-6 top-0 items-center justify-between">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()"
                        class="md:hidden text-slate-500 hover:text-primary transition-colors p-1">
                        <iconify-icon icon="solar:hamburger-menu-linear" width="24" stroke-width="1.5"></iconify-icon>
                    </button>
                    <!-- Breadcrumbs -->
                    <nav class="hidden sm:flex items-center text-sm font-medium text-slate-400">
                        <span class="hover:text-primary cursor-pointer transition-colors">Profil</span>
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="mx-2 text-xs"></iconify-icon>
                        <span class="text-primary">Sejarah</span>
                    </nav>
                </div>

                <div class="flex items-center gap-4 md:gap-6">
                    <!-- Search -->
                    <div
                        class="hidden md:flex focus-within:border-primary/20 focus-within:bg-white focus-within:shadow-sm transition-all duration-300 bg-slate-100/50 w-64 border-transparent border rounded-full pt-2 pr-4 pb-2 pl-4 items-center">
                        <iconify-icon icon="solar:magnifer-linear" class="text-slate-400 mr-2"
                            width="18"></iconify-icon>
                        <input type="text" placeholder="Search..."
                            class="bg-transparent border-none outline-none text-sm text-slate-600 w-full placeholder-slate-400">
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200 cursor-pointer group">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-semibold text-dark group-hover:text-primary transition-colors">Alex
                                Morgan</p>
                            <p class="text-xs text-slate-400">Administrator</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary to-indigo-400 p-[2px]">
                            <img src="https://avatars.githubusercontent.com/u/152723454?w=800&q=80" alt="Profile"
                                class="w-full h-full object-cover border-white border-2 rounded-full">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Container -->
            <div class="md:p-10 w-full max-w-7xl mr-auto ml-auto pt-6 pr-6 pb-6 pl-6 space-y-8">

                <!-- Welcome Section -->
                <div class="flex flex-col md:flex-row md:items-end gap-4 gap-x-4 gap-y-4 justify-between">
                    <div class="">
                        <h1 class="md:text-4xl text-dark text-3xl font-semibold tracking-tight font-poppins mb-2">
                            Selamat Datang di admin panel</h1>
                        <p class="text-slate-500 font-poppins"> Kelola seluruh informasi Website Desa Bungur mulai dari
                            artikel,
                            galeri foto, UMKM, profil desa hingga demografi masyarakat
                            melalui dashboard administrator.</p>
                    </div>
                </div>

                <!-- Stats Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 : Total Artikel -->
                    <div
                        class="bg-white rounded-2xl p-6 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_-4px_rgba(88,2,247,0.08)] transition-all duration-300 border border-slate-50 group">

                        <div class="flex justify-between items-start mb-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-pastelPurple text-primary flex items-center justify-center group-hover:scale-110 transition-transform">

                                <iconify-icon icon="solar:document-text-linear" width="24"
                                    stroke-width="1.5"></iconify-icon>

                            </div>

                            <span
                                 class="flex items-center text-xs font-semibold text-orange-600 bg-orange-50 px-2 py-1 rounded-full">

                                +12 pending

                            </span>

                        </div>

                        <h3 class="text-slate-400 text-sm font-medium mb-1">
                            Total Artikel
                        </h3>

                        <p class="text-dark text-2xl font-bold font-poppins">
                            124
                        </p>

                        <p class="text-xs text-slate-400 mt-2">
                            Artikel telah dipublikasikan
                        </p>

                    </div>


                    <!-- Card 2 : Galeri Foto -->
                    <div
                        class="bg-white rounded-2xl p-6 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_-4px_rgba(88,2,247,0.08)] transition-all duration-300 border border-slate-50 group">

                        <div class="flex justify-between items-start mb-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">

                                <iconify-icon icon="solar:gallery-wide-linear" width="24"
                                    stroke-width="1.5"></iconify-icon>

                            </div>

                            <span
                                class="flex items-center text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">

                                +28

                                <iconify-icon icon="solar:arrow-right-up-linear" class="ml-1"></iconify-icon>

                            </span>

                        </div>

                        <h3 class="text-slate-400 text-sm font-medium mb-1">
                            Galeri Foto
                        </h3>

                        <p class="text-dark text-2xl font-bold font-poppins">
                            1.258
                        </p>

                        <p class="text-xs text-slate-400 mt-2">
                            Dokumentasi kegiatan desa
                        </p>

                    </div>


                    <!-- Card 3 : Produk UMKM -->
                    <div
                        class="bg-white rounded-2xl p-6 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_-4px_rgba(88,2,247,0.08)] transition-all duration-300 border border-slate-50 group">

                        <div class="flex justify-between items-start mb-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center group-hover:scale-110 transition-transform">

                                <iconify-icon icon="solar:shop-linear" width="24" stroke-width="1.5"></iconify-icon>

                            </div>

                        </div>

                        <h3 class="text-slate-400 text-sm font-medium mb-1">
                            Produk UMKM
                        </h3>

                        <p class="text-dark text-2xl font-bold font-poppins">
                            32
                        </p>

                        <p class="text-xs text-slate-400 mt-2">
                            UMKM terdaftar di website
                        </p>

                    </div>


                    <!-- Card 4 : Pengunjung Website -->
                    <div
                        class="bg-white rounded-2xl p-6 shadow-[0_2px_20px_-4px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_-4px_rgba(88,2,247,0.08)] transition-all duration-300 border border-slate-50 group">

                        <div class="flex justify-between items-start mb-4">

                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">

                                <iconify-icon icon="solar:eye-linear" width="24" stroke-width="1.5"></iconify-icon>

                            </div>

                        </div>

                        <h3 class="text-slate-400 text-sm font-medium mb-1">
                            Pengunjung Website
                        </h3>

                        <p class="text-dark text-2xl font-bold font-poppins">
                            18.524
                        </p>

                        <p class="text-xs text-slate-400 mt-2">
                            Total kunjungan bulan ini
                        </p>

                    </div>
                </div>

                <!-- Footer -->
                <footer
                    class="mt-8 pb-4 text-center sm:text-left flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400">
                    <p>© 2023 Aura Dashboard UI. All rights reserved.</p>
                    <div class="flex gap-4 mt-2 sm:mt-0">
                        <a href="#" class="hover:text-primary">Privacy Policy</a>
                        <a href="#" class="hover:text-primary">Terms of Service</a>
                    </div>
                </footer>

            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // --- Sidebar Logic ---
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            // Mobile: Toggle Translate X
            const isClosed = sidebar.classList.contains('-translate-x-full');

            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                // Small delay to allow display:block to apply before opacity transition
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                }, 10);
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        // --- Charts Configuration ---
        document.addEventListener('DOMContentLoaded', function () {
            Chart.defaults.font.family = "'Montserrat', sans-serif";
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.scale.grid.color = '#f1f5f9';
            Chart.defaults.scale.grid.borderColor = 'transparent';

            // Revenue Chart (Line with Gradient)
            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');

            // Gradient
            let gradient = ctxRevenue.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(88, 2, 247, 0.2)');
            gradient.addColorStop(1, 'rgba(88, 2, 247, 0)');

            new Chart(ctxRevenue, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    datasets: [{
                        label: 'Revenue',
                        data: [30000, 35000, 32000, 48000, 45000, 60000, 58000, 75000, 72000, 84254],
                        borderColor: '#5802f7',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#5802f7',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'white',
                            titleColor: '#1a1a1a',
                            bodyColor: '#64748b',
                            borderColor: '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function (context) {
                                    return '$ ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [4, 4] },
                            ticks: { callback: function (value) { return '$' + value / 1000 + 'k'; } }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Device Chart (Doughnut)
            const ctxDevice = document.getElementById('deviceChart').getContext('2d');
            new Chart(ctxDevice, {
                type: 'doughnut',
                data: {
                    labels: ['Desktop', 'Mobile', 'Tablet'],
                    datasets: [{
                        data: [65, 25, 10],
                        backgroundColor: [
                            '#5802f7', // Primary
                            '#2dd4bf', // Teal
                            '#fb923c'  // Orange
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'white',
                            bodyColor: '#1a1a1a',
                            borderColor: '#e2e8f0',
                            borderWidth: 1,
                        }
                    }
                }
            });
        });
    </script>

</body>

</html>