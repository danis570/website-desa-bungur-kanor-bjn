<!-- ==========================================================
BREADCRUMB
========================================================== -->

<nav class="flex my-16" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="/"
                class="ml-1 inline-flex text-sm font-medium text-gray-500 hover:text-primary hover:underline md:ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="mr-4 h-4 w-4">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Home
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-400">/</span>
                <span class="ml-1 text-sm font-medium text-gray-800 md:ml-2">
                    Hasil Pencarian
                </span>
            </div>
        </li>
    </ol>
</nav>

<!-- ==========================================================
HEADING
========================================================== -->

<div class="my-16">

    <span class="text-sm tracking-[0.25em] uppercase text-primary font-semibold">
        Pencarian
    </span>

    <h2 class="text-3xl font-bold mt-4">
        Hasil Pencarian
    </h2>

    <?php if (!empty($model['query']) && strlen($model['query']) >= 2): ?>
        <p class="text-gray-500 mt-2">
            Menampilkan <?= $model['totalResults'] ?> hasil untuk
            "<strong><?= htmlspecialchars($model['query']) ?></strong>"
        </p>
    <?php endif; ?>

</div>

<!-- ==========================================================
SEARCH FORM
========================================================== -->

<div class="mb-12">
    <form action="/search" method="GET" class="max-w-2xl">
        <div class="relative">
            <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="q" value="<?= htmlspecialchars($model['query'] ?? '') ?>"
                placeholder="Cari berita, UMKM, perangkat desa..."
                class="w-full pl-14 pr-5 py-5 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-primary outline-none text-lg"
                autofocus>
            <button type="submit"
                class="absolute right-3 top-1/2 -translate-y-1/2 px-6 py-2.5 bg-primary text-white rounded-xl hover:opacity-90 transition">
                Cari
            </button>
        </div>
    </form>
</div>

<!-- ==========================================================
RESULTS
========================================================== -->

<?php if (empty($model['query']) || strlen($model['query']) < 2): ?>
    <!-- Jika tidak ada query atau query kurang dari 2 karakter -->
    <div class="text-center py-16 text-gray-400">
        <iconify-icon icon="solar:search-linear" class="text-6xl mx-auto"></iconify-icon>
        <p class="mt-4 text-lg">Masukkan kata kunci untuk mencari</p>
    </div>

<?php elseif ($model['totalResults'] > 0): ?>
    <!-- Jika ada hasil -->
    <div class="space-y-4 mb-32">

        <?php foreach ($model['results'] as $result): ?>
            <div class="bg-white rounded-2xl border border-gray-100 hover:border-primary transition shadow-sm overflow-hidden">
                <a href="<?= $result['url'] ?>" class="block p-6 hover:bg-gray-50 transition">
                    <div class="flex items-start gap-4">

                        <!-- Gambar / Icon -->
                        <div class="flex-shrink-0">
                            <?php if (!empty($result['image'])): ?>
                                <img src="<?= $result['image'] ?>" class="w-24 h-24 rounded-xl object-cover"
                                    alt="<?= htmlspecialchars($result['title']) ?>"
                                    onerror="this.src='https://picsum.photos/seed/result/96/96'">
                            <?php else: ?>
                                <?php
                                $icons = [
                                    'Berita' => '📰',
                                    'UMKM' => '🏪',
                                    'Aparatur Desa' => '👤',
                                    'Sejarah Desa' => '📜',
                                    'Galeri Foto' => '🖼️',
                                    'Sambutan' => '👋',
                                    'Visi & Misi' => '🎯'
                                ];
                                ?>
                                <div class="w-24 h-24 rounded-xl bg-gray-100 flex items-center justify-center text-4xl">
                                    <?= $icons[$result['type']] ?? '🔍' ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="text-xs font-semibold text-primary bg-primary/10 px-3 py-1 rounded-full">
                                    <?= $result['type'] ?>
                                </span>
                                <?php if (!empty($result['date'])): ?>
                                    <span class="text-xs text-gray-400">
                                        <?= date('d M Y', strtotime($result['date'])) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mt-2 group-hover:text-primary transition">
                                <?= htmlspecialchars($result['title']) ?>
                            </h3>
                            <p class="text-gray-600 text-sm mt-1 line-clamp-2">
                                <?= htmlspecialchars($result['description']) ?>
                            </p>
                            <span class="text-primary text-sm font-medium mt-2 inline-block">
                                Baca selengkapnya →
                            </span>
                        </div>

                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>

<?php else: ?>
    <!-- Jika tidak ada hasil -->
    <div class="text-center py-16 text-gray-400">
        <iconify-icon icon="solar:search-remove-linear" class="text-6xl mx-auto"></iconify-icon>
        <p class="mt-4 text-lg">Tidak ada hasil untuk "<strong><?= htmlspecialchars($model['query']) ?></strong>"</p>
        <p class="text-sm text-gray-300 mt-2">Coba dengan kata kunci lain</p>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <span class="text-gray-500 text-sm">Suggestions:</span>
            <button class="suggestion-btn text-primary hover:underline text-sm">Profil Desa</button>
            <button class="suggestion-btn text-primary hover:underline text-sm">Berita</button>
            <button class="suggestion-btn text-primary hover:underline text-sm">UMKM</button>
            <button class="suggestion-btn text-primary hover:underline text-sm">Aparatur</button>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Suggestion buttons
        document.querySelectorAll('.suggestion-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const form = document.querySelector('form');
                const input = form.querySelector('input[name="q"]');
                input.value = this.textContent.trim();
                form.submit();
            });
        });

        // Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>