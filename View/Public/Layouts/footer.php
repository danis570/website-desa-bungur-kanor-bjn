</div>

<!-- ==========================================================
            FOOTER
        ========================================================== -->

<footer class="mt-16 shadow-[0_-10px_30px_rgba(0,0,0,0.08)] pt-12">
    <div class="container-web">

        <div class="flex flex-col md:flex-row justify-between w-full gap-10 border-b border-gray-500/30 pb-6">
            <div class="md:max-w-96">
                <div class="flex items-center gap-4 mb-6">

                    <img src="../assets/logo-bojonegoro.png" class="w-14 h-14 object-contain" alt="Logo Desa">

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

        <div class="flex flex-col items-center text-center gap-3 lg:flex-row lg:justify-between lg:text-left py-6">

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

    <div class="max-w-3xl mx-auto mt-24 bg-white rounded-3xl shadow-2xl overflow-hidden">

        <div class="flex justify-between items-center p-6 border-b">

            <h2 class="text-2xl font-bold">
                Pencarian
            </h2>

            <button id="closeSearch" class="w-10 h-10 rounded-full hover:bg-gray-100">

                <i data-lucide="x"></i>

            </button>

        </div>

        <div class="p-6">

            <div class="relative">

                <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <input id="searchInput" type="text" placeholder="Cari berita, layanan, perangkat desa..."
                    class="w-full pl-14 pr-5 py-5 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-primary outline-none text-lg">

            </div>

            <div class="mt-8">

                <h3 class="font-semibold mb-4">
                    Pencarian Populer
                </h3>

                <div class="flex flex-wrap gap-3">

                    <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition">
                        Profil Desa
                    </button>

                    <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition">
                        Berita
                    </button>

                    <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition">
                        APBDes
                    </button>

                    <button class="px-5 py-2 rounded-full bg-gray-100 hover:bg-primary hover:text-white transition">
                        Layanan
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
     LIBRARY
    ========================================================== -->

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- ==========================================================
     MAIN SCRIPT
    ========================================================== -->

<script>

    document.addEventListener("DOMContentLoaded", () => {

        /* ==========================================================
           INITIALIZE
        ========================================================== */

        AOS.init({
            duration: 900,
            once: true,
            offset: 80,
        });

        lucide.createIcons();

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
           SEARCH MODAL
        ========================================================== */

        const searchModal = document.getElementById("searchModal");
        const searchInput = document.getElementById("searchInput");

        function openSearch() {

            searchModal.classList.remove("opacity-0", "invisible");

            setTimeout(() => {
                searchInput.focus();
            }, 200);

        }

        function closeSearch() {

            searchModal.classList.add("opacity-0", "invisible");

        }

        document.getElementById("openSearch").onclick = openSearch;
        document.getElementById("closeSearch").onclick = closeSearch;

        searchModal.addEventListener("click", (e) => {

            if (e.target === searchModal) {

                closeSearch();

            }

        });

        document.addEventListener("keydown", (e) => {

            if (e.key === "Escape") {

                closeSearch();

            }

        });

        if (document.querySelector(".aparaturSwiper")) {

            new Swiper(".aparaturSwiper", {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,

                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },

                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },

                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });

        }

    });
</script>

</body>

</html>