<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $model['title'] ?? '' ?></title>

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-grid.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-quartz.css">

    <link rel="stylesheet" href="/assets/ckeditor5-48.3.0/ckeditor5/ckeditor5.css">
    <script src="/assets/ckeditor5-48.3.0/ckeditor5/ckeditor5.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tagify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>

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

                        <img src="/assets/logo-bojonegoro.png" alt="Logo Desa Bungur" class="w-10 h-10 object-contain">

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

            <nav class="flex-1 px-4 py-6 overflow-y-auto">

                <p class="px-4 mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Dashboard
                </p>

                <!-- Dashboard -->

                <a href="/user/dashboard" class="group flex items-center gap-3 px-4 py-3 rounded-xl
                    <?= $model['current'] === 'dashboard'
                        ? 'bg-primary/10 text-primary font-semibold'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-primary' ?>">

                    <iconify-icon icon="solar:widget-5-linear" width="20"></iconify-icon>

                    Dashboard

                </a>


                <!-- ===================================================== -->

                <p class="px-4 mt-8 mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Konten Website
                </p>

                <!-- News -->

                <a href="/user/news" class="group flex items-center gap-3 px-4 py-3 rounded-xl
                    <?= $model['current'] === 'news'
                        ? 'bg-primary/10 text-primary font-semibold'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-primary' ?>">
                    <iconify-icon icon="solar:document-text-linear" width="20"></iconify-icon>

                    Berita

                </a>

                <!-- Galeri -->

                <a href="../Photo/foto.php"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-50 hover:text-primary transition">

                    <iconify-icon icon="solar:gallery-linear" width="20"></iconify-icon>

                    Galeri Foto

                </a>

            </nav>


            <!-- ==========================================================
        BOTTOM
    =========================================================== -->

            <div class="p-4 border-t border-slate-100">

                <button disabled
                    class="flex items-center gap-3 w-full px-4 py-3 rounded-xl opacity-50 cursor-not-allowed select-none text-left">

                    <iconify-icon icon="solar:settings-linear" width="20"></iconify-icon>

                    <span>Pengaturan</span>

                </button>

                <a href="#" onclick="confirmLogout(event)"
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
            <header class="sticky top-0 z-30 h-20 shrink-0 flex items-center justify-between glass md:px-10 px-6 py-3">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()"
                        class="md:hidden text-slate-500 hover:text-primary transition-colors p-1">
                        <iconify-icon icon="solar:hamburger-menu-linear" width="24" stroke-width="1.5"></iconify-icon>
                    </button>
                    <!-- Breadcrumbs -->
                    <nav class="hidden sm:flex items-center text-sm font-medium text-slate-400">

                        <?php foreach ($model['breadcrumbs'] as $index => $breadcrumb): ?>

                            <?php if ($index > 0): ?>
                                <iconify-icon icon="solar:alt-arrow-right-linear" class="mx-2 text-xs">
                                </iconify-icon>
                            <?php endif; ?>

                            <?php if ($breadcrumb['url']): ?>

                                <a href="<?= $breadcrumb['url'] ?>" class="hover:text-primary transition-colors">

                                    <?= htmlspecialchars($breadcrumb['title']) ?>

                                </a>

                            <?php else: ?>

                                <span class="text-primary">

                                    <?= htmlspecialchars($breadcrumb['title']) ?>

                                </span>

                            <?php endif; ?>

                        <?php endforeach; ?>
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
                            <p class="text-sm font-semibold text-dark group-hover:text-primary transition-colors">
                                <?= $model['user']->name ?>
                            </p>
                            <p class="text-xs text-slate-400">
                                <?= $model['user']->position ?>
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary to-indigo-400 p-[2px]">
                            <img src="/uploads/avatar/<?= htmlspecialchars(!empty($model['user']->avatar) ? $model['user']->avatar : 'default.png') ?>"
                                alt="<?= htmlspecialchars($model['user']->name) ?>"
                                class="w-full h-full object-cover border-white border-2 rounded-full">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Container -->
            <div class="md:p-10 w-full max-w-7xl mr-auto ml-auto pt-6 pr-6 pb-6 pl-6 space-y-8">