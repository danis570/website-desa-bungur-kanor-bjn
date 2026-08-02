<!-- ==========================================================
HEADING
========================================================== -->

<div class="my-16">

    <span class="text-sm tracking-[0.25em] uppercase text-primary font-semibold">
        Produk Lokal
    </span>

    <h2 class="text-3xl font-bold mt-4">
        UMKM Desa Bungur
    </h2>

</div>

<!-- ==========================================================
GRID
========================================================== -->

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-32">

    <?php if (!empty($model['umkms'])): ?>
        <?php foreach ($model['umkms'] as $umkm): ?>
            <article>

                <a href="/umkm/detail/<?= htmlspecialchars($umkm->slug) ?>" class="group block" data-aos="fade-up">

                    <div class="relative overflow-hidden rounded-3xl shadow-lg">

                        <img src="/uploads/umkm/<?= htmlspecialchars($umkm->featuredImage ?? 'default-umkm.jpg') ?>"
                            class="w-full h-72 object-cover transition duration-700 group-hover:scale-110"
                            alt="<?= htmlspecialchars($umkm->featuredImageAlt ?? $umkm->name) ?>"
                            onerror="this.src='https://picsum.photos/seed/umkm<?= $umkm->id ?>/800/500'">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 p-7 w-full">

                            <!-- Kategori -->
                            <span class="inline-block bg-primary text-white text-xs px-3 py-1 rounded-full mb-3">
                                <?= htmlspecialchars($umkm->categoryName ?? 'UMKM') ?>
                            </span>

                            <!-- Nama Toko -->
                            <h3 class="text-2xl font-bold text-white group-hover:text-green-300 transition">
                                <?= htmlspecialchars($umkm->name) ?>
                            </h3>

                            <!-- Owner -->
                            <p class="text-gray-200 text-sm mt-3 flex items-center gap-2">
                                <i class="bi bi-person-circle"></i>
                                Owner : <?= htmlspecialchars($umkm->owner) ?>
                            </p>

                            <!-- Lokasi -->
                            <?php if (!empty($umkm->address)): ?>
                                <p class="text-gray-300 text-sm mt-1 flex items-center gap-2">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <?= htmlspecialchars($umkm->address) ?>
                                </p>
                            <?php endif; ?>

                        </div>

                    </div>

                </a>

            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full text-center py-16 text-gray-400">
            <iconify-icon icon="solar:shop-2-linear" class="text-6xl mx-auto"></iconify-icon>
            <p class="mt-4 text-lg">Belum ada UMKM</p>
        </div>
    <?php endif; ?>

</div>