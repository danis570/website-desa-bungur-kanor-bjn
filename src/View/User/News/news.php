<div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between mb-10">
    <div>
        <span class="text-sm tracking-[0.25em] uppercase text-primary font-semibold">
            Dashboard
        </span>
        <h1 class="text-4xl font-bold mt-2">
            Berita Saya
        </h1>
        <p class="text-gray-500 mt-2">
            Kelola seluruh berita yang telah Anda buat.
        </p>
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <!-- Search -->
        <div class="relative">
            <iconify-icon icon="solar:magnifer-linear"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl">
            </iconify-icon>
            <input id="searchInput" type="text" placeholder="Cari berita..."
                class="pl-12 pr-4 h-12 w-full sm:w-80 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
        </div>

        <!-- Add -->
        <a href="/user/news/add"
            class="h-12 px-6 rounded-2xl bg-primary text-white font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition">
            Tambah
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div
        class="mb-6 px-6 py-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <iconify-icon icon="solar:check-circle-linear" class="text-2xl text-green-500"></iconify-icon>
            <span><?= htmlspecialchars($_SESSION['success']) ?></span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
            <iconify-icon icon="solar:close-circle-linear" class="text-xl"></iconify-icon>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div
        class="mb-6 px-6 py-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <iconify-icon icon="solar:danger-circle-linear" class="text-2xl text-red-500"></iconify-icon>
            <span><?= htmlspecialchars($_SESSION['error']) ?></span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
            <iconify-icon icon="solar:close-circle-linear" class="text-xl"></iconify-icon>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Stats --><!-- Stats & Filter -->
<div class="bg-white rounded-3xl shadow-sm p-6 mb-10">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <!-- Stats -->
        <div class="flex items-center gap-6">
            <?php
            $total = count($model['articles']);
            $published = array_filter($model['articles'], fn($a) => $a->status === 'published');
            $draft = array_filter($model['articles'], fn($a) => $a->status === 'draft');
            ?>
            <div>
                <span class="text-gray-500 text-sm">Total</span>
                <span class="font-bold ml-2"><?= $total ?></span>
            </div>
            <div class="w-px h-8 bg-gray-200"></div>
            <div>
                <span class="text-gray-500 text-sm">Published</span>
                <span class="font-bold text-green-600 ml-2"><?= count($published) ?></span>
            </div>
            <div class="w-px h-8 bg-gray-200"></div>
            <div>
                <span class="text-gray-500 text-sm">Draft</span>
                <span class="font-bold text-amber-500 ml-2"><?= count($draft) ?></span>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-2">
            <button class="filter-btn px-4 h-9 rounded-full bg-primary text-white text-sm active" data-filter="all">
                Semua
            </button>
            <button class="filter-btn px-4 h-9 rounded-full border transition text-sm" data-filter="published">
                Published
            </button>
            <button class="filter-btn px-4 h-9 rounded-full border transition text-sm" data-filter="draft">
                Draft
            </button>
        </div>
    </div>
</div>

<!-- Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-32" id="articlesGrid">
    <?php if (empty($model['articles'])): ?>
        <div class="col-span-full text-center py-16">
            <iconify-icon icon="solar:document-text-linear" class="text-6xl text-gray-300 mx-auto"></iconify-icon>
            <h3 class="text-xl font-semibold text-gray-600 mt-4">Belum ada berita</h3>
            <p class="text-gray-400 mt-2">Mulai buat berita pertama Anda sekarang</p>
            <a href="/user/news/add"
                class="inline-block mt-4 px-6 py-3 bg-primary text-white rounded-2xl hover:opacity-90 transition">
                Tambah Berita
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($model['articles'] as $article): ?>

            <article class="article-card" data-status="<?= htmlspecialchars($article->status) ?>" data-aos="fade-up">
                <div class="group block">
                    <div class="relative overflow-hidden rounded-3xl shadow-lg">
                        <img src="/uploads/articles/<?= htmlspecialchars($article->image ?? 'default-news.jpg') ?>"
                            alt="<?= htmlspecialchars($article->title) ?>"
                            class="w-full h-72 object-cover transition duration-700 group-hover:scale-110"
                            onerror="this.src='/uploads/articles/default-news.jpg'">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent">
                        </div>

                        <div class="absolute bottom-0 left-0 p-7">
                            <span class="inline-block text-white text-xs px-3 py-1 rounded-full mb-3 
                                <?= $article->status === 'published' ? 'bg-green-500' : 'bg-amber-500' ?>">
                                <?= ucfirst($article->status) ?>
                            </span>

                            <h3 class="text-2xl font-bold text-white group-hover:text-green-300 transition line-clamp-2">
                                <?= htmlspecialchars($article->title) ?>
                            </h3>

                            <p class="text-gray-200 text-sm mt-2 line-clamp-2">
                                <?= htmlspecialchars(strip_tags($article->excerpt ?? '')) ?>
                            </p>

                            <p class="text-gray-300 text-xs mt-2">
                                <?php if ($article->publishedAt): ?>
                                    Published at
                                    <span class="underline">
                                        <?= date('d M Y', strtotime($article->publishedAt)) ?>
                                    </span>,
                                    <?= date('H:i', strtotime($article->publishedAt)) ?> WIB
                                <?php else: ?>
                                    Draft -
                                    <span class="underline">
                                        <?= date('d M Y', strtotime($article->createdAt)) ?>
                                    </span>,
                                    <?= date('H:i', strtotime($article->createdAt)) ?> WIB
                                <?php endif; ?>
                                <?php
                                // Tampilkan informasi update jika pernah diperbarui
                                if (
                                    !empty($article->updatedAt) &&
                                    $article->updatedAt !== $article->createdAt
                                ):
                                    ?>
                                    <br>
                                    <span class="text-blue-300">
                                        Updated:
                                        <?= date('d M Y', strtotime($article->updatedAt)) ?>
                                        <?= date('H:i', strtotime($article->updatedAt)) ?> WIB
                                    </span>
                                <?php endif; ?>

                                <br>
                                by <?= htmlspecialchars($article->authorName ?? 'Unknown') ?>
                            </p>

                            <div class="flex gap-2 mt-4">
                                <a href="/user/news/edit/<?= $article->id ?>"
                                    class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-xl hover:bg-white/30 transition text-sm">
                                    Edit
                                </a>
                                <button
                                    onclick="confirmDelete(<?= $article->id ?>, '<?= htmlspecialchars(addslashes($article->title)) ?>')"
                                    class="px-4 py-2 bg-red-500/80 backdrop-blur-sm text-white rounded-xl hover:bg-red-500 transition text-sm">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <iconify-icon icon="solar:danger-triangle-linear" class="text-4xl text-red-500"></iconify-icon>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Konfirmasi Hapus</h3>
            <p class="text-gray-500 mt-2" id="deleteMessage">Apakah Anda yakin ingin menghapus berita ini?</p>
            <form id="deleteForm" action="" method="POST" class="mt-6 flex gap-3 justify-center">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600 transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Search functionality
    const searchInput = document.getElementById("searchInput");
    const articleCards = document.querySelectorAll(".article-card");
    const filterBtns = document.querySelectorAll(".filter-btn");
    let currentFilter = "all";

    function filterArticles() {
        const keyword = searchInput.value.toLowerCase();

        articleCards.forEach(card => {
            const text = card.innerText.toLowerCase();
            const status = card.dataset.status;

            let matchFilter = currentFilter === "all" || status === currentFilter;
            let matchSearch = text.includes(keyword);

            card.style.display = (matchFilter && matchSearch) ? "block" : "none";
        });
    }

    if (searchInput) {
        searchInput.addEventListener("keyup", filterArticles);
    }

    filterBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            filterBtns.forEach(b => {
                b.classList.remove("bg-primary", "text-white");
                b.classList.add("border");
            });
            this.classList.add("bg-primary", "text-white");
            this.classList.remove("border");

            currentFilter = this.dataset.filter;
            filterArticles();
        });
    });

    // Delete confirmation
    function confirmDelete(id, title) {
        document.getElementById("deleteMessage").textContent =
            `Apakah Anda yakin ingin menghapus berita "${title}"? Tindakan ini tidak dapat dibatalkan.`;
        document.getElementById("deleteForm").action = `/user/news/delete/${id}`;
        document.getElementById("deleteModal").classList.remove("hidden");
        document.getElementById("deleteModal").classList.add("flex");
        document.body.style.overflow = "hidden";
    }

    function closeDeleteModal() {
        document.getElementById("deleteModal").classList.add("hidden");
        document.getElementById("deleteModal").classList.remove("flex");
        document.body.style.overflow = "auto";
    }

    // Close modal on click outside
    const deleteModal = document.getElementById("deleteModal");
    if (deleteModal) {
        deleteModal.addEventListener("click", function (e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    }

    // Close modal on ESC key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeDeleteModal();
        }
    });

    // AOS animation
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.article-card');
        if (cards.length > 0) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            });

            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });
        }
    });
</script>