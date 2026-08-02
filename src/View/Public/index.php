<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Desa Bungur | Kecamatan Kanor</title>

    <!-- ==========================================================
        GOOGLE FONT
    =========================================================== -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

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
        SWIPER
    =========================================================== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- ==========================================================
        AOS
    =========================================================== -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

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
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(18px);
            box-shadow: 0 10px 35px rgba(0, 0, 0, .08);
        }

        /* Hamburger saat navbar transparan */
        .navbar:not(.scrolled) #openMenu {
            color: #ffffff;
        }

        /* Hamburger saat navbar putih */
        .navbar.scrolled #openMenu {
            color: #111827;
        }

        /* Logo */

        .navbar:not(.scrolled) #logoTitle {
            color: #fff;
        }

        .navbar:not(.scrolled) #logoSubtitle {
            color: #e5e7eb;
        }

        .navbar.scrolled #logoTitle {
            color: #111827;
        }

        .navbar.scrolled #logoSubtitle {
            color: #4b5563;
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

        /* Navbar transparan (di atas hero) */
        .navbar:not(.scrolled) .nav-link {

            color: #ffffff;
            font-weight: 600;

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

        /* Hover saat navbar masih transparan */
        .navbar:not(.scrolled) .nav-link:hover {

            color: #ffffff;

        }

        /* Hover saat navbar putih */
        .navbar.scrolled .nav-link:hover {

            color: #111827;

        }

        /* ==========================================================
           MOBILE MENU
        ========================================================== */

        .mobile-menu {
            transition: .35s ease;
        }

        /* ==========================================================
           HERO
        ========================================================== */

        .hero-image {
            animation: zoomHero 12s linear infinite alternate;
        }

        @keyframes zoomHero {

            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.12);
            }

        }

        /* ==========================================================
           SWIPER
        ========================================================== */

        .swiper-pagination {
            bottom: 80px !important;
        }

        .swiper-pagination-bullet {
            background: #fff;
            opacity: .7;
        }

        .swiper-pagination-bullet-active {
            background: #22c55e;
            opacity: 1;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            display: none;
        }

        .swiper-button-prev,
        .swiper-button-next {
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
            z-index: 20;
        }

        .swiper-button-prev {
            left: max(24px, calc((100vw - 1440px) / 2 + 13.5rem));
        }

        .swiper-button-next {
            right: max(24px, calc((100vw - 1440px) / 2 + 13.5rem));
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            display: none;
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

        @media (max-width:768px) {

            .swiper-button-next,
            .swiper-button-prev {
                display: none;
            }

        }
    </style>

</head>

<body>

    <!-- ==========================
        NAVBAR
    =========================== -->

    <header id="navbar" class="navbar fixed w-full z-50">

        <div class="container-web">

            <div class="flex items-center justify-between py-5">

                <!-- Logo -->

                <a href="#" class="flex items-center gap-3">

                    <img src="assets/logo-bojonegoro.png" class="w-14 h-14 object-contain">

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

                    <a href="profil" class="nav-link">
                        Profil
                    </a>

                    <a href="/demografi" class="nav-link">
                        Demografi
                    </a>

                    <a href="/kabar" class="nav-link">
                        kabar Desa
                    </a>

                    <a href="/photo" class="nav-link">
                        Photo
                    </a>

                    <a href="/umkm" class="nav-link">
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


            <a href="/profil" class="block font-medium">
                Profil
            </a>

            <a href="/demografi" class="block font-medium">
                Demografi
            </a>

            <a href="/kabar" class="block font-medium">
                Kabar Desa
            </a>

            <a href="/photo" class="block font-medium">
                Photo
            </a>

            <a href="/umkm" class="block font-medium">
                UMKM
            </a>
        </nav>

    </div>

    <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-[998]"></div>

    <!-- ==========================
    HERO
    ========================== -->

    <section class="sticky top-0 h-screen overflow-hidden z-0">

        <div class="swiper heroSwiper h-full">

            <div class="swiper-wrapper">

                <?php if (!empty($model['banners'])): ?>
                    <?php foreach ($model['banners'] as $banner): ?>
                        <div class="swiper-slide relative">
                            <img src="/uploads/banner/<?= htmlspecialchars($banner->image) ?>"
                                class="hero-image absolute inset-0 w-full h-full object-cover"
                                alt="<?= htmlspecialchars($banner->title) ?>"
                                onerror="this.src='https://picsum.photos/seed/banner<?= $banner->id ?>/1920/1080'">

                            <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/20"></div>

                            <div class="relative z-10 h-full flex items-center">
                                <div class="max-w-7xl mx-auto px-6">
                                    <div class="container-web">
                                        <div class="max-w-3xl">
                                            <h2 class="text-5xl lg:text-6xl font-bold text-white mb-6">
                                                <?= htmlspecialchars($banner->title) ?>
                                            </h2>
                                            <?php if (!empty($banner->description)): ?>
                                                <p class="text-xl text-gray-200 mb-8">
                                                    <?= htmlspecialchars($banner->description) ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Default Slide jika tidak ada banner -->
                    <div class="swiper-slide relative">
                        <img src="https://picsum.photos/seed/desa/1920/1080"
                            class="hero-image absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/20"></div>
                        <div class="relative z-10 h-full flex items-center">
                            <div class="max-w-7xl mx-auto px-6">
                                <div class="container-web">
                                    <div class="max-w-3xl">
                                        <h2 class="text-5xl lg:text-6xl font-bold text-white mb-6">
                                            Desa Bungur
                                        </h2>
                                        <p class="text-xl text-gray-200 mb-8">
                                            Kecamatan Kanor - Kabupaten Bojonegoro
                                            <br>
                                            Selamat datang di website resmi desa bungur
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <div class="swiper-pagination"></div>

            <div class="swiper-button-prev">
                <i data-lucide="chevron-left"></i>
            </div>

            <div class="swiper-button-next">
                <i data-lucide="chevron-right"></i>
            </div>
        </div>

    </section>

    <!-- Konten -->
    <main class="relative z-20 bg-white rounded-t-[48px] -mt-12">

        <!-- ==========================================================
        SAMBUTAN KEPALA DESA
        ========================================================== -->

        <section class="py-20 bg-white">

            <div class="container-web">

                <!-- Heading -->
                <div class="mb-12" data-aos="fade-up">

                    <span class="text-sm tracking-[0.25em] uppercase font-semibold text-primary">
                        Sambutan Kepala Desa
                    </span>

                    <h2 class="text-3xl lg:text-4xl font-bold mt-4 text-gray-900">
                        Membangun Desa Bersama Masyarakat
                        </hh2>

                </div>

                <?php if (!empty($model['greeting'])): ?>
                    <?php $greeting = $model['greeting']; ?>

                    <div class="grid lg:grid-cols-[1.5fr_380px] gap-14 items-start">

                        <!-- Text -->
                        <div class="text-gray-600 text-lg leading-9" data-aos="fade-right">

                            <?php if (!empty($greeting->opening)): ?>
                                <p class="font-semibold text-gray-900 mb-6">
                                    <?= htmlspecialchars($greeting->opening) ?>
                                </p>
                            <?php endif; ?>

                            <?php
                            // Pisahkan paragraf berdasarkan baris kosong
                            $paragraphs = preg_split("/\R{2,}/", trim($greeting->content));

                            foreach ($paragraphs as $paragraph):
                                ?>
                                <p class="mb-6 text-justify">
                                    <?= nl2br(htmlspecialchars(trim($paragraph))) ?>
                                </p>
                            <?php endforeach; ?>

                            <?php if (!empty($greeting->closing)): ?>
                                <p class="mt-8 font-semibold text-gray-900">
                                    <?= htmlspecialchars($greeting->closing) ?>
                                </p>
                            <?php endif; ?>

                        </div>

                        <!-- Profile -->
                        <div class="lg:sticky lg:top-28">

                            <div class="p-6 text-center">

                                <?php if (!empty($greeting->image)): ?>
                                    <img src="/uploads/greeting/<?= htmlspecialchars($greeting->image) ?>"
                                        class="w-full aspect-[4/5] object-cover rounded-3xl"
                                        alt="<?= htmlspecialchars($greeting->name) ?>"
                                        onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($greeting->name) ?>&size=400&background=15803d&color=fff'">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($greeting->name) ?>&size=400&background=15803d&color=fff"
                                        class="w-full aspect-[4/5] object-cover rounded-3xl"
                                        alt="<?= htmlspecialchars($greeting->name) ?>">
                                <?php endif; ?>

                                <div class="mt-6">

                                    <p class="text-gray-500">
                                        Hormat Kami,
                                    </p>

                                    <?php if (!empty($greeting->signatureImage)): ?>
                                        <img src="/uploads/signature/<?= htmlspecialchars($greeting->signatureImage) ?>"
                                            class="h-16 mx-auto my-4 object-contain" alt="Tanda Tangan"
                                            onerror="this.style.display='none'">
                                    <?php else: ?>
                                        <div class="h-16 my-4"></div>
                                    <?php endif; ?>

                                    <h3 class="text-xl font-bold">
                                        <?= htmlspecialchars($greeting->name) ?>
                                    </h3>

                                    <p class="text-gray-500">
                                        Kepala Desa Bungur
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php else: ?>

                    <!-- Default jika tidak ada data -->
                    <div class="text-center py-12">

                        <div class="text-gray-400">

                            <iconify-icon icon="solar:user-speak-rounded-linear" class="text-6xl mx-auto"></iconify-icon>

                            <p class="mt-4 text-lg">
                                Belum ada sambutan Kepala Desa
                            </p>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </section>

        <!-- ==========================================================
            GALERI & BERITA
        ========================================================== -->

        <section class="py-20">

            <div class="container-web">

                <div class="mb-12">
                    <span class="text-sm tracking-[0.25em] uppercase text-primary font-semibold">
                        Informasi Terbaru
                    </span>
                    <h2 class="text-3xl font-bold mt-4">
                        Berita & Aktivitas Desa
                    </h2>
                </div>

                <div class="grid lg:grid-cols-[1.2fr_1fr] gap-10">

                    <!-- Galeri -->
                    <div class="overflow-hidden">

                        <div class="p-6 flex justify-between items-center">

                            <div>
                                <h3 class="text-xl font-bold">
                                    Galeri
                                </h3>
                                <p class="text-gray-500 text-sm">
                                    <?= !empty($model['latestPhoto']) ? 'Foto terbaru dari desa' : 'Belum ada foto' ?>
                                </p>
                            </div>

                            <span class="flex items-center gap-2 text-red-500 font-semibold text-sm">
                                <a href="/photo">Lihat semua foto</a>
                            </span>

                        </div>

                        <?php if (!empty($model['latestPhoto'])): ?>
                            <img src="/uploads/photos/<?= htmlspecialchars($model['latestPhoto']->image ?? 'default-photo.jpg') ?>"
                                class="w-full aspect-video object-cover"
                                alt="<?= htmlspecialchars($model['latestPhoto']->caption ?? 'Foto Desa') ?>"
                                onerror="this.src='https://picsum.photos/seed/desa/1200/675'">
                        <?php else: ?>
                            <img src="https://picsum.photos/seed/desa/1200/675" class="w-full aspect-video object-cover"
                                alt="Galeri Desa">
                        <?php endif; ?>

                        <div class="px-6 py-4 text-sm text-gray-500 flex justify-between">
                            <span>
                                <?= !empty($model['latestPhoto']) ? 'Update terakhir' : 'Total foto' ?>
                            </span>
                            <span>
                                <?php if (!empty($model['latestPhoto']) && !empty($model['latestPhoto']->createdAt)): ?>
                                    <?= date('d M Y • H:i', strtotime($model['latestPhoto']->createdAt)) ?> WIB
                                <?php else: ?>
                                    <?= ($model['totalPhotos'] ?? 0) ?> foto
                                <?php endif; ?>
                            </span>
                        </div>

                    </div>

                    <!-- Berita -->
                    <div>

                        <div class="flex justify-between mb-8">
                            <h3 class="text-xl font-bold">
                                Berita Terbaru
                            </h3>

                            <a href=" /kabar" class="text-primary font-semibold text-sm">
                                Lihat Semua →
                            </a>
                        </div>

                        <div class="space-y-8">

                            <?php if (!empty($model['latestArticles'])): ?>
                                <?php foreach ($model['latestArticles'] as $index => $article): ?>
                                    <a href=" /kabar/detail/<?= htmlspecialchars($article->slug) ?>" class="flex gap-5 group"
                                        data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">

                                        <img src="/uploads/articles/<?= htmlspecialchars($article->image ?? 'default-news.jpg') ?>"
                                            class="w-28 h-20 rounded-2xl object-cover"
                                            alt="<?= htmlspecialchars($article->title) ?>"
                                            onerror="this.src='https://picsum.photos/seed /kabar<?= $index ?>/200/150'">

                                        <div>

                                            <p class="text-sm text-primary font-semibold">
                                                <?php if (!empty($article->publishedAt)): ?>
                                                    <?= date('d M Y', strtotime($article->publishedAt)) ?>
                                                <?php else: ?>
                                                    <?= date('d M Y', strtotime($article->createdAt)) ?>
                                                <?php endif; ?>
                                            </p>

                                            <h4 class="font-bold group-hover:text-primary transition">
                                                <?= htmlspecialchars($article->title) ?>
                                            </h4>

                                            <p class="text-sm text-gray-500">
                                                <?= htmlspecialchars(substr(strip_tags($article->excerpt ?? $article->content ?? ''), 0, 50)) ?>...
                                            </p>

                                        </div>

                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center text-gray-400 py-8">
                                    <p>Belum ada berita terbaru</p>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!-- ==========================================================
            FOOTER
        ========================================================== -->

        <footer class="mt-12 shadow-[0_-10px_30px_rgba(0,0,0,0.08)] pt-12">
            <div class="container-web">

                <div class="flex flex-col md:flex-row justify-between w-full gap-10 border-b border-gray-500/30 pb-6">
                    <div class="md:max-w-96">
                        <div class="flex items-center gap-4 mb-6">

                            <img src="assets/logo-bojonegoro.png" class="w-14 h-14 object-contain" alt="Logo Desa">

                            <div>

                                <h3 class="text-2xl font-bold text-black-600">

                                    Desa Bungur

                                </h3>

                                <p class="text-sm text-black-400">

                                    Kecamatan Kanor • Kabupaten Bojonegoro

                                </p>

                            </div>

                        </div>
                        <p class="mt-6 text-sm">
                            Website resmi Pemerintah Desa Bungur sebagai media
                            informasi, pelayanan publik, transparansi pemerintahan,
                            serta sarana komunikasi digital bagi seluruh masyarakat.
                        </p>
                    </div>
                    <div class="flex-1 flex flex-col md:flex-row items-start md:justify-end gap-10 md:gap-20">
                        <div>
                            <h2 class="font-semibold mb-5 text-gray-800">Kontak</h2>
                            <ul class="text-sm space-y-2">
                                <li class="flex items-start gap-3">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-primary mt-1 shrink-0"></i>

                                    <p class="text-sm leading-6">
                                        Desa Bungur,<br>
                                        Kecamatan Kanor,<br>
                                        Kabupaten Bojonegoro
                                    </p>
                                </li>
                                <li class="flex items-start gap-3">

                                    <i data-lucide="mail" class="w-5 h-5 text-primary"></i>

                                    <a href="#" class="text-sm leading-6">
                                        desabungur@example.id
                                    </a>
                                </li>

                                <li class="flex items-start gap-3">
                                    <i data-lucide="phone" class="w-5 h-5 text-primary"></i>

                                    <a href="#" class="text-sm leading-6">
                                        085xxxxxxx
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="font-semibold mb-5 text-gray-800">Menu</h2>

                            <ul class="flex flex-col gap-3 text-sm">
                                <li><a href="#">Profil</a></li>
                                <li><a href="#">Demografi</a></li>
                                <li><a href="#">Berita</a></li>
                                <li><a href="#">UMKM</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container-web">

                <div
                    class="flex flex-col items-center text-center gap-3 lg:flex-row lg:justify-between lg:text-left py-6">

                    <!-- Copyright -->
                    <p class="text-sm text-gray-500">
                        © 2026 Pemerintah Desa Bungur. Seluruh hak cipta dilindungi.
                    </p>

                    <!-- Developer -->
                    <p class="text-sm">
                        <span class="text-gray-500">
                            Designed & Developed by
                        </span>

                        <span class="font-semibold text-blue-700">
                            KKN-27 Universitas PGRI Ronggolawe Tuban 2026
                        </span>
                    </p>

                </div>

            </div>
        </footer>

    </main>


    <!-- ==========================================================
SEARCH MODAL
========================================================== -->
    <div id="searchModal"
        class="fixed inset-0 z-[9999] bg-black/60 backdrop-blur-sm opacity-0 invisible transition-all duration-300">

        <div class="max-w-3xl mx-auto mt-24 bg-white rounded-3xl shadow-2xl overflow-hidden modal-content">

            <div class="flex justify-between items-center p-6 border-b">
                <h2 class="text-2xl font-bold">
                    Pencarian
                </h2>
                <button id="closeSearch"
                    class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <div class="p-6">

                <div class="relative">
                    <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="searchInput" type="text" placeholder="Cari berita, UMKM, perangkat desa..."
                        class="w-full pl-14 pr-5 py-5 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-primary outline-none text-lg"
                        autocomplete="off">
                </div>

                <!-- Search Results -->
                <div id="searchResults" class="mt-6 hidden">
                    <h3 class="font-semibold mb-3 text-gray-700">Hasil Pencarian</h3>
                    <div id="searchResultList" class="space-y-2 max-h-96 overflow-y-auto"></div>
                </div>

                <div class="mt-8" id="popularSearches">
                    <h3 class="font-semibold mb-4 text-gray-700">
                        Pencarian Populer
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        <button
                            class="popular-search px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition text-sm">
                            Profil Desa
                        </button>
                        <button
                            class="popular-search px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition text-sm">
                            Berita
                        </button>
                        <button
                            class="popular-search px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition text-sm">
                            UMKM
                        </button>
                        <button
                            class="popular-search px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition text-sm">
                            Aparatur Desa
                        </button>
                        <button
                            class="popular-search px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition text-sm">
                            Sejarah Desa
                        </button>
                        <button
                            class="popular-search px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition text-sm">
                            Demografi
                        </button>
                    </div>
                </div>

                <!-- No Results -->
                <div id="noResults" class="mt-8 text-center text-gray-500 hidden">
                    <i data-lucide="search-x" class="w-12 h-12 mx-auto text-gray-300"></i>
                    <p class="mt-2">Tidak ada hasil untuk pencarian "<span id="searchQueryDisplay"></span>"</p>
                    <p class="text-sm text-gray-400 mt-1">Coba kata kunci lain</p>
                </div>

            </div>

        </div>

    </div>

    <!-- ==========================================================
     LIBRARY
    ========================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <!-- ==========================================================
     MAIN SCRIPT
    ========================================================== -->

    <script>

        document.addEventListener("DOMContentLoaded", () => {

            /* ==========================================================
               INITIALIZE
            ========================================================== */

            lucide.createIcons();

            AOS.init({
                duration: 900,
                once: true
            });

            /* ==========================================================
               NAVBAR
            ========================================================== */

            const navbar = document.getElementById("navbar");

            window.addEventListener("scroll", () => {

                navbar.classList.toggle("scrolled", window.scrollY > 40);

            });

            /* ==========================================================
               MOBILE MENU
            ========================================================== */

            const menu = document.getElementById("mobileMenu");
            const overlay = document.getElementById("overlay");

            function openMenu() {

                menu.style.right = "0";
                overlay.classList.remove("hidden");

            }

            function closeMenu() {

                menu.style.right = "-100%";
                overlay.classList.add("hidden");

            }

            document.getElementById("openMenu").onclick = openMenu;
            document.getElementById("closeMenu").onclick = closeMenu;
            overlay.onclick = closeMenu;

            /* ==========================================================
      SEARCH MOBILE - BUKA MODAL
   ========================================================== */

            const mobileSearchBtn = document.getElementById("openSearchFromMobile");

            if (mobileSearchBtn) {
                mobileSearchBtn.addEventListener("click", function (e) {
                    e.preventDefault();
                    // Tutup mobile menu
                    closeMenu();
                    // Buka search modal (pakai fungsi yang sudah ada)
                    setTimeout(() => {
                        if (typeof openSearch === "function") {
                            openSearch();
                        }
                    }, 300);
                });
            }

            /* ==========================================================
               HERO SWIPER
            ========================================================== */

            new Swiper(".heroSwiper", {

                loop: true,

                effect: "fade",

                speed: 1200,

                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },

                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },

                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                }

            });

        });

    </script>

    <!-- Search Modal -->
    <script>
        // ==========================================================
        // SEARCH MODAL
        // ==========================================================

        document.addEventListener('DOMContentLoaded', function () {
            const searchModal = document.getElementById('searchModal');
            const searchInput = document.getElementById('searchInput');
            const closeSearch = document.getElementById('closeSearch');
            const searchResults = document.getElementById('searchResults');
            const searchResultList = document.getElementById('searchResultList');
            const popularSearches = document.getElementById('popularSearches');
            const noResults = document.getElementById('noResults');
            const searchQueryDisplay = document.getElementById('searchQueryDisplay');

            let searchTimeout = null;

            // ==========================================================
            // OPEN SEARCH
            // ==========================================================

            window.openSearch = function () {
                searchModal.classList.remove('opacity-0', 'invisible');
                searchModal.classList.add('show');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    searchInput.focus();
                }, 200);
            };

            // ==========================================================
            // CLOSE SEARCH
            // ==========================================================

            function closeSearchModal() {
                searchModal.classList.add('opacity-0', 'invisible');
                searchModal.classList.remove('show');
                document.body.style.overflow = '';
                searchInput.value = '';
                searchResults.classList.add('hidden');
                popularSearches.classList.remove('hidden');
                noResults.classList.add('hidden');
            }

            // ==========================================================
            // SEARCH FUNCTION
            // ==========================================================

            function performSearch(query) {
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    popularSearches.classList.remove('hidden');
                    noResults.classList.add('hidden');
                    return;
                }

                // Show loading
                searchResults.classList.remove('hidden');
                searchResultList.innerHTML = '<div class="text-center py-4 text-gray-400">Mencari...</div>';
                popularSearches.classList.add('hidden');
                noResults.classList.add('hidden');

                // Fetch search results from server
                fetch(`/search/api?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.results && data.results.length > 0) {
                            searchResultList.innerHTML = '';
                            data.results.forEach(result => {
                                const div = document.createElement('div');
                                div.className = 'search-result-item p-3 rounded-xl border border-gray-100 hover:border-primary transition';
                                div.innerHTML = `
                                <a href="${result.url}" class="flex items-start gap-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">${result.title}</h4>
                                        <p class="text-sm text-gray-500">${result.description || ''}</p>
                                        <span class="text-xs text-primary font-medium">${result.type}</span>
                                    </div>
                                </a>
                            `;
                                searchResultList.appendChild(div);
                            });
                        } else {
                            searchResultList.innerHTML = '';
                            noResults.classList.remove('hidden');
                            searchQueryDisplay.textContent = query;
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResultList.innerHTML = '<div class="text-center py-4 text-red-500">Terjadi kesalahan</div>';
                    });
            }

            // ==========================================================
            // EVENT LISTENERS
            // ==========================================================

            // Open search button
            document.querySelectorAll('#openSearch').forEach(btn => {
                btn.addEventListener('click', openSearch);
            });

            // Close search
            closeSearch.addEventListener('click', closeSearchModal);

            // Close on backdrop click
            searchModal.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeSearchModal();
                }
            });

            // Close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && searchModal.classList.contains('show')) {
                    closeSearchModal();
                }
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    openSearch();
                }
            });

            // Search input
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch(this.value.trim());
                }, 300);
            });

            // Enter key
            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value.trim();
                    if (query.length >= 2) {
                        window.location.href = `/search?q=${encodeURIComponent(query)}`;
                    }
                }
            });

            // Popular search buttons
            document.querySelectorAll('.popular-search').forEach(btn => {
                btn.addEventListener('click', function () {
                    searchInput.value = this.textContent.trim();
                    performSearch(searchInput.value);
                });
            });

            // Open search with Ctrl+K
            document.addEventListener('keydown', function (e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    openSearch();
                }
            });
        });
    </script>

</body>

</html>