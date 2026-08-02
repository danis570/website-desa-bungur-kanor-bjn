<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $model['title'] ?? '' ?></title>

    <!-- ==========================================================
        GOOGLE FONT
    =========================================================== -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- ==========================================================
       Bootstrap Icons
    =========================================================== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- ==========================================================
        SWIPER
    =========================================================== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- ==========================================================
       DATA-AOS
    =========================================================== -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <!-- ==========================================================
       PHOTOSWIPE
    =========================================================== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.css">

    <!-- ==========================================================
        TAILWIND CSS
    =========================================================== -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#15803d",
                        secondary: "#166534",
                        gold: "#f59e0b"
                    }
                }
            }
        }
    </script>

    <!-- ==========================================================
        LUCIDE ICON
    =========================================================== -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- ==========================================================
        CUSTOM STYLE
    =========================================================== -->

    <style>
        /* ==========================================================
           RESET
        ========================================================== */

        * {
            font-family: 'Poppins', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #f8fafc;
            overflow-x: hidden;
        }

        /* ==========================================================
           NAVBAR
        ========================================================== */

        .navbar {
            transition: .35s ease;
        }

        .navbar.scrolled {
            background: #fff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .08);
        }

        /* ==========================================================
        NAVBAR MENU
        ========================================================== */

        .nav-link {

            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: .75rem 1.25rem;

            border-radius: 9999px;

            font-weight: 500;

            transition: all .35s ease;

        }

        /* Navbar setelah scroll */
        .navbar.scrolled .nav-link {

            color: #111827;
            font-weight: 600;
            /* sedikit lebih tebal */

        }

        /* Hover */

        .nav-link:hover {

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(0, 0, 0, .10),
                inset 0 1px 0 rgba(255, 255, 255, .35);

        }

        /* Hover saat navbar putih */
        .navbar.scrolled .nav-link:hover {

            color: #111827;

        }


        /* ==========================================================
       SEARCH MODAL
    ========================================================== */
        #searchModal {
            transition: all 0.3s ease;
        }

        #searchModal.show {
            opacity: 1;
            visibility: visible;
        }

        #searchModal .modal-content {
            transform: scale(0.95);
            transition: all 0.3s ease;
        }

        #searchModal.show .modal-content {
            transform: scale(1);
        }

        .search-result-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .search-result-item:hover {
            background: #f8fafc;
            border-color: #16a34a;
        }


        /* ==========================================================
           MOBILE MENU
        ========================================================== */

        .mobile-menu {
            transition: .35s ease;
        }

        /* ==========================================================
           RESPONSIVE
        ========================================================== */

        .container-web {
            max-width: 1440px;
            margin: 0 auto;
            padding-inline: 1.5rem;
        }

        @media (min-width:768px) {
            .container-web {
                padding-inline: 4rem;
            }
        }

        @media (min-width:1024px) {
            .container-web {
                padding-inline: 6rem;
            }
        }

        @media (min-width:1280px) {
            .container-web {
                padding-inline: 8rem;
            }
        }
    </style>

</head>

<body>

    <!-- ==========================
        NAVBAR
    =========================== -->

    <header class="navbar scrolled fixed w-full z-50">

        <div class="container-web">


            <div class="flex items-center justify-between py-5">

                <!-- Logo -->

                <a href="/" class="flex items-center gap-3">

                    <img src="/assets/logo-bojonegoro.png" class="w-14 h-14 object-contain">

                    <div>

                        <h1 id="logoTitle" class="font-bold text-xl transition-colors duration-300">
                            Desa Bungur
                        </h1>

                        <p id="logoSubtitle" class="text-sm transition-colors duration-300">
                            Kecamatan Kanor
                        </p>

                    </div>

                </a>

                <!-- Desktop -->

                <nav class="hidden lg:flex items-center gap-3">

                    <a href="profil" class="<?= $model['current'] == 'profile'
                        ? 'inline-flex items-center gap-3 px-8 py-2 rounded-full border-2 border-primary text-primary font-semibold transition duration-300'
                        : 'nav-link'
                        ?>">
                        Profil
                    </a>

                    <a href="/demografi" class="<?= $model['current'] == 'demographics'
                        ? 'inline-flex items-center gap-3 px-8 py-2 rounded-full border-2 border-primary text-primary font-semibold transition duration-300'
                        : 'nav-link'
                        ?>">
                        Demografi
                    </a>

                    <a href="/kabar" class="<?= $model['current'] == 'village-news'
                        ? 'inline-flex items-center gap-3 px-8 py-2 rounded-full border-2 border-primary text-primary font-semibold transition duration-300'
                        : 'nav-link'
                        ?>">
                        Kabar Desa
                    </a>

                    <a href="/photo" class="<?= $model['current'] == 'photo'
                        ? 'inline-flex items-center gap-3 px-8 py-2 rounded-full border-2 border-primary text-primary font-semibold transition duration-300'
                        : 'nav-link'
                        ?>">
                        Photo
                    </a>


                    <a href="/umkm" class="<?= $model['current'] == 'msme'
                        ? 'inline-flex items-center gap-3 px-8 py-2 rounded-full border-2 border-primary text-primary font-semibold transition duration-300'
                        : 'nav-link'
                        ?>">
                        UMKM
                    </a>

                </nav>

                <!-- Right -->

                <div class="hidden lg:flex items-center gap-4">

                    <button id="openSearch"
                        class="w-11 h-11 rounded-full bg-white shadow flex justify-center items-center hover:bg-primary hover:text-white transition">
                        <i data-lucide="search" class="w-5"></i>
                    </button>

                </div>

                <!-- Mobile -->

                <button id="openMenu" class="lg:hidden">

                    <i data-lucide="menu" class="w-8 h-8"></i>

                </button>

            </div>

        </div>

    </header>

    <!-- ==========================
        MOBILE MENU
    =========================== -->

    <div id="mobileMenu" class="mobile-menu fixed top-0 right-[-100%] w-80 h-full bg-white shadow-2xl z-[999]">

        <div class="p-6 border-b">

            <div class="flex justify-between">

                <h2 class="font-bold text-xl">
                    Menu
                </h2>

                <button id="closeMenu">

                    <i data-lucide="x"></i>

                </button>

            </div>

        </div>

        <!-- ==========================
SEARCH BAR - BUKA MODAL
=========================== -->
        <div class="px-6 py-4 border-b border-gray-100">
            <button id="openSearchFromMobile"
                class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl border border-gray-200 hover:border-primary hover:bg-gray-50 transition group">
                <iconify-icon icon="solar:magnifer-linear" width="18"
                    class="text-gray-400 group-hover:text-primary"></iconify-icon>
                <span class="text-sm text-gray-400 group-hover:text-gray-700">Cari di website...</span>
                <span class="ml-auto text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded">Ctrl+K</span>
            </button>
        </div>


        <nav class="p-6 space-y-5">

            <a href="/profil" class="<?= $model['current'] == 'profile'
                ? 'block px-4 py-3 rounded-xl border-2 border-primary text-primary font-semibold'
                : 'block font-medium'
                ?>">
                Profil
            </a>

            <a href="/demografi" class="<?= $model['current'] == 'demographics'
                ? 'block px-4 py-3 rounded-xl border-2 border-primary text-primary font-semibold'
                : 'block font-medium'
                ?>">
                Demografi
            </a>

            <a href="/kabar" class="<?= $model['current'] == 'village-news'
                ? 'block px-4 py-3 rounded-xl border-2 border-primary text-primary font-semibold'
                : 'block font-medium'
                ?>">
                Kabar Desa
            </a>

            <a href="/photo" class="<?= $model['current'] == 'photo'
                ? 'block px-4 py-3 rounded-xl border-2 border-primary text-primary font-semibold'
                : 'block font-medium'
                ?>">
                Photo
            </a>

            <a href="/umkm" class="<?= $model['current'] == 'msme'
                ? 'block px-4 py-3 rounded-xl border-2 border-primary text-primary font-semibold'
                : 'block font-medium'
                ?>">
                UMKM
            </a>

        </nav>

    </div>

    <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-[998]"></div>

    <!-- Konten -->
    <main class="relative z-20 bg-white pt-24">

        <div class="container-web">