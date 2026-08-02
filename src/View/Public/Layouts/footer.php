</div>

<!-- ==========================================================
            FOOTER
        ========================================================== -->

<footer class="mt-16 shadow-[0_-10px_30px_rgba(0,0,0,0.08)] pt-12">
    <div class="container-web">

        <div class="flex flex-col md:flex-row justify-between w-full gap-10 border-b border-gray-500/30 pb-6">
            <div class="md:max-w-96">
                <div class="flex items-center gap-4 mb-6">

                    <img src="/assets/logo-bojonegoro.png" class="w-14 h-14 object-contain" alt="Logo Desa">

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

    <div class="max-w-3xl mx-auto mt-24 bg-white rounded-3xl shadow-2xl overflow-hidden modal-content">

        <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-2xl font-bold">
                Pencarian
            </h2>
            <button id="closeSearch" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center">
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
        APARATUR SWIPER
     ========================================================== */

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