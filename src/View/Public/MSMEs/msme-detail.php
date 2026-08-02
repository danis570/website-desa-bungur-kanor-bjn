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
                Beranda
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-400">/</span>
                <a href="/umkm"
                    class="ml-1 text-sm font-medium text-gray-500 hover:text-primary hover:underline md:ml-2">
                    UMKM Desa
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-400">/</span>
                <span class="ml-1 text-sm font-medium text-gray-800 md:ml-2 line-clamp-1 max-w-[200px]">
                    <?= htmlspecialchars($model['umkm']->name) ?>
                </span>
            </div>
        </li>
    </ol>
</nav>

<!-- ==========================================================
DETAIL UMKM
========================================================== -->

<article>

    <header class="mb-10">

        <!-- FOTO PEMILIK / UMKM -->
        <div class="flex items-center gap-5 mb-8">

            <?php if (!empty($model['umkm']->ownerPhoto)): ?>
                <img src="/uploads/umkm/<?= htmlspecialchars($model['umkm']->ownerPhoto) ?>"
                    class="w-20 h-20 rounded-full object-cover shadow"
                    alt="<?= htmlspecialchars($model['umkm']->ownerPhotoAlt ?? $model['umkm']->owner) ?>"
                    onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($model['umkm']->owner) ?>&size=80&background=15803d&color=fff'">
            <?php else: ?>
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($model['umkm']->owner) ?>&size=80&background=15803d&color=fff"
                    class="w-20 h-20 rounded-full object-cover shadow"
                    alt="<?= htmlspecialchars($model['umkm']->ownerPhotoAlt ?? $model['umkm']->owner) ?>">
            <?php endif; ?>

            <div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900">
                    <?= htmlspecialchars($model['umkm']->name) ?>
                </h1>

                <p class="text-gray-500 mt-2">
                    Kategori: <?= htmlspecialchars($model['umkm']->categoryName ?? 'UMKM') ?>
                </p>

                <p class="text-gray-500">
                    Pemilik : <?= htmlspecialchars($model['umkm']->owner) ?>
                </p>
            </div>

        </div>

        <!-- HERO IMAGE -->
        <figure>
            <img src="/uploads/umkm/<?= htmlspecialchars($model['umkm']->featuredImage ?? 'default-umkm.jpg') ?>"
                class="w-full h-[420px] lg:h-[550px] object-cover rounded-3xl shadow-lg"
                alt="<?= htmlspecialchars($model['umkm']->featuredImageAlt ?? $model['umkm']->name) ?>"
                onerror="this.src='https://picsum.photos/seed/umkm<?= $model['umkm']->id ?>/1200/500'">

            <figcaption class="text-center text-sm text-gray-500 mt-3">
                <?= htmlspecialchars($model['umkm']->featuredImageAlt ?: 'Produk UMKM Desa Bungur') ?>
            </figcaption>
        </figure>

    </header>

    <!-- ==========================================================
    INFORMASI UMKM
    ========================================================== -->

    <div class="grid lg:grid-cols-3 gap-8">

        <!-- CONTENT - MENU -->
        <div class="lg:col-span-2 prose max-w-none">

            <h3 class="text-xl font-bold mb-5">
                Menu
            </h3>

            <?php if (!empty($model['umkm']->menus)): ?>
                <div class="grid sm:grid-cols-2 gap-6 not-prose">
                    <?php foreach ($model['umkm']->menus as $menu): ?>
                        <div class="border rounded-2xl p-5">

                            <?php if (!empty($menu->image)): ?>
                                <img src="/uploads/umkm/<?= htmlspecialchars($menu->image) ?>"
                                    class="rounded-xl h-40 w-full object-cover" alt="<?= htmlspecialchars($menu->name) ?>"
                                    onerror="this.src='https://picsum.photos/seed/menu<?= $menu->id ?>/400/300'">
                            <?php else: ?>
                                <img src="https://picsum.photos/seed/menu<?= $menu->id ?>/400/300"
                                    class="rounded-xl h-40 w-full object-cover" alt="<?= htmlspecialchars($menu->name) ?>">
                            <?php endif; ?>

                            <h3 class="font-bold text-lg mt-4">
                                <?= htmlspecialchars($menu->name) ?>
                            </h3>

                            <p class="text-gray-500">
                                Rp <?= number_format($menu->price, 0, ',', '.') ?>
                            </p>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400">Belum ada menu</p>
            <?php endif; ?>

        </div>

        <!-- SIDEBAR - INFORMASI USAHA -->
        <aside>

            <div class="bg-white border rounded-3xl p-6 shadow-sm">

                <h3 class="text-xl font-bold mb-5">
                    Informasi Usaha
                </h3>

                <div class="space-y-5 text-gray-600">

                    <!-- DESKRIPSI -->
                    <?php if (!empty($model['umkm']->description)): ?>
                        <div>

                            <p class="text-sm leading-relaxed"><?= htmlspecialchars($model['umkm']->description) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($model['umkm']->address)): ?>
                        <div>
                            <p class="font-semibold text-gray-900">Alamat</p>
                            <p><?= htmlspecialchars($model['umkm']->address) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($model['umkm']->businessHours)): ?>
                        <div>
                            <p class="font-semibold text-gray-900">Jam Operasional</p>
                            <p><?= htmlspecialchars($model['umkm']->businessHours) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($model['umkm']->whatsapp)): ?>
                        <div>
                            <p class="font-semibold text-gray-900">Kontak</p>
                            <a href="https://wa.me/<?= htmlspecialchars($model['umkm']->whatsapp) ?>" target="_blank"
                                class="text-green-600 font-semibold hover:underline">
                                WhatsApp
                            </a>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

            <!-- BUTTON WHATSAPP -->
            <?php if (!empty($model['umkm']->whatsapp)): ?>
                <a href="https://wa.me/<?= htmlspecialchars($model['umkm']->whatsapp) ?>" target="_blank"
                    class="mt-6 flex items-center justify-center gap-2 bg-green-500 text-white rounded-full py-3 font-semibold hover:bg-green-600 transition">
                    <i class="bi bi-whatsapp"></i>
                    Hubungi Pemilik
                </a>
            <?php endif; ?>

        </aside>

    </div>

</article>

<!-- ==========================================================
LOKASI
========================================================== -->

<!-- ==========================================================
LOKASI
========================================================== -->
<!-- ==========================================================
LOKASI
========================================================== -->

<section class="mt-16">

    <h2 class="text-2xl font-bold mb-6">
        Lokasi UMKM
    </h2>

    <?php
    $mapsUrl = $model['umkm']->mapsEmbedUrl ?? '';
    // Cek apakah URL valid dan mengandung 'google.com/maps/embed'
    $isValidMaps = !empty($mapsUrl) && strpos($mapsUrl, 'google.com/maps/embed') !== false;
    ?>

    <?php if ($isValidMaps): ?>
        <div class="rounded-3xl overflow-hidden shadow">
            <iframe src="<?= htmlspecialchars($mapsUrl) ?>" width="100%" height="400" style="border:0" allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    <?php else: ?>
        <div class="rounded-3xl bg-gray-100 border-2 border-dashed border-gray-300 p-12 text-center">
            <iconify-icon icon="solar:map-point-remove-linear" class="text-5xl text-gray-400 mx-auto"></iconify-icon>
            <p class="text-gray-500 mt-3">Belum ada data lokasi</p>
            <p class="text-gray-400 text-sm mt-1">Admin UMKM belum menambahkan lokasi</p>
        </div>
    <?php endif; ?>

</section>

<!-- ==========================================================
SHARE
========================================================== -->

<section class="mt-16 border-t py-8">

    <h3 class="font-bold text-xl mb-5">
        Bagikan UMKM
    </h3>

    <div class="flex gap-3">

        <?php
        $shareUrl = urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $shareText = urlencode($model['umkm']->name . ' - ' . $model['umkm']->owner);
        ?>

        <a href="https://wa.me/?text=<?= $shareText ?>%20<?= $shareUrl ?>" target="_blank"
            class="w-11 h-11 rounded-full bg-green-500 text-white flex items-center justify-center hover:scale-110 transition">
            <i class="bi bi-whatsapp"></i>
        </a>

        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>" target="_blank"
            class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center hover:scale-110 transition">
            <i class="bi bi-facebook"></i>
        </a>

        <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareText ?>" target="_blank"
            class="w-11 h-11 rounded-full bg-black text-white flex items-center justify-center hover:scale-110 transition">
            <i class="bi bi-twitter-x"></i>
        </a>

        <!-- Copy Link -->
        <button id="copy-link"
            class="w-11 h-11 rounded-full bg-gray-700 text-white flex items-center justify-center hover:scale-110 transition duration-300">
            <i class="bi bi-link-45deg text-xl"></i>
        </button>

    </div>

</section>

<script>document.addEventListener('DOMContentLoaded', function () {

        const copyBtn = document.getElementById('copy-link');

        if (!copyBtn) return;

        copyBtn.addEventListener('click', function (e) {

            e.preventDefault();

            copyLink();

        });

        function copyLink() {

            if (navigator.clipboard && window.isSecureContext) {

                navigator.clipboard.writeText(window.location.href)
                    .then(successCopy)
                    .catch(fallbackCopy);

            } else {

                fallbackCopy();

            }

        }

        function successCopy() {

            copyBtn.innerHTML = '<i class="bi bi-check-lg text-xl text-green-400"></i>';

            setTimeout(() => {
                copyBtn.innerHTML = '<i class="bi bi-link-45deg text-xl"></i>';
            }, 2000);

            showToast('✅ Link berhasil disalin');

        }

        function fallbackCopy() {

            const textarea = document.createElement('textarea');

            textarea.value = window.location.href;

            document.body.appendChild(textarea);

            textarea.select();

            try {

                document.execCommand('copy');

                successCopy();

            } catch (err) {

                console.error(err);

                showToast('❌ Gagal menyalin link');

            }

            document.body.removeChild(textarea);

        }

        function showToast(message) {

            document.querySelector('.share-toast')?.remove();

            const toast = document.createElement('div');

            toast.className =
                'share-toast fixed bottom-6 left-1/2 -translate-x-1/2 z-[99999] px-6 py-3 rounded-2xl bg-gray-900 text-white shadow-xl text-sm transition';

            toast.textContent = message;

            document.body.appendChild(toast);

            setTimeout(() => {

                toast.style.opacity = '0';

                setTimeout(() => toast.remove(), 300);

            }, 2000);

        }

    });
</script>