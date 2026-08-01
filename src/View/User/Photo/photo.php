<!-- ==========================================================
HEADER DASHBOARD
========================================================== -->
<div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between mb-10">

    <div>

        <span class="text-sm tracking-[0.25em] uppercase text-primary font-semibold">
            Dashboard
        </span>

        <h1 class="text-4xl font-bold mt-2">
            Galeri Foto
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola dan lihat momen terbaik Desa Bungur dalam galeri foto.
        </p>

    </div>

    <div class="flex flex-col sm:flex-row gap-3">

        <!-- Search -->
        <div class="relative">

            <iconify-icon icon="solar:magnifer-linear"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl">
            </iconify-icon>

            <input id="searchInput" type="text" placeholder="Cari foto..."
                class="pl-12 pr-4 h-12 w-full sm:w-80 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">

        </div>

        <!-- Add -->
        <a href="/user/photo/add"
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

<!-- Stats -->
<div class="bg-white rounded-3xl shadow-sm p-6 mb-10">
    <div class="flex flex-wrap items-center gap-6">
        <?php
        $total = count($model['photos']);
        ?>
        <div>
            <span class="text-gray-500 text-sm">Total Foto</span>
            <span class="font-bold ml-2 text-2xl"><?= $total ?></span>
        </div>
    </div>
</div>

<style>
    /* ==========================================================
   PINTEREST GALLERY
========================================================== */

    .gallery {
        column-count: 5;
        column-gap: 1.5rem;
    }

    .gallery-item {
        break-inside: avoid;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .gallery-item img {
        width: 100%;
        display: block;
        border-radius: 1.75rem;
        transition: transform .45s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    /* Admin overlay pada gallery item */
    .gallery-item .admin-overlay {
        position: absolute;
        top: 12px;
        right: 12px;
        display: flex;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 10;
    }

    .gallery-item:hover .admin-overlay {
        opacity: 1;
    }

    .gallery-item .admin-overlay a,
    .gallery-item .admin-overlay button {
        width: 36px;
        height: 36px;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.3s ease;
        font-size: 16px;
        text-decoration: none;
    }

    .gallery-item .admin-overlay a:hover,
    .gallery-item .admin-overlay button:hover {
        background: #16a34a;
    }

    .gallery-item .admin-overlay a.delete:hover,
    .gallery-item .admin-overlay button.delete:hover {
        background: #dc2626;
    }

    /* Hover overlay info */
    .gallery-item .hover-info {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0);
        transition: background 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 24px;
        opacity: 0;
        transition: all 0.3s ease;
        border-radius: 1.75rem;
    }

    .gallery-item:hover .hover-info {
        background: rgba(0, 0, 0, 0.45);
        opacity: 1;
    }

    .gallery-item .hover-info .text-white {
        color: white;
    }

    .gallery-item .hover-info h3 {
        font-weight: 700;
        font-size: 1.125rem;
    }

    .gallery-item .hover-info p {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.9);
    }

    /* ==========================================================
   RESPONSIVE GALLERY
========================================================== */

    @media (max-width:1280px) {
        .gallery {
            column-count: 4;
        }
    }

    @media (max-width:992px) {
        .gallery {
            column-count: 3;
        }
    }

    @media (max-width:768px) {
        .gallery {
            column-count: 2;
        }
    }

    @media (max-width:640px) {
        .gallery {
            column-count: 2;
            column-gap: 1rem;
        }

        .gallery-item {
            margin-bottom: 1rem;
        }
    }

    /* ==========================================================
   MODAL KONFIRMASI HAPUS
========================================================== */

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 32px;
        max-width: 420px;
        width: 100%;
        padding: 40px;
        animation: slideUp 0.3s ease;
        position: relative;
    }

    .modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 40px;
        height: 40px;
        border-radius: 999px;
        border: none;
        background: #f3f4f6;
        color: #1f2937;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s ease;
    }

    .modal-close:hover {
        background: #e5e7eb;
    }

    .modal-content .btn-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 8px;
    }

    .modal-content .btn-submit {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 16px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .modal-content .btn-submit.cancel-btn {
        background: #9ca3af;
        color: white;
    }

    .modal-content .btn-submit.cancel-btn:hover {
        background: #6b7280;
    }

    .modal-content .btn-submit.delete-btn {
        background: #dc2626;
        color: white;
    }

    .modal-content .btn-submit.delete-btn:hover {
        background: #b91c1c;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- ==========================================================
PINTEREST GALLERY
========================================================== -->

<section class="pb-24">

    <div id="gallery" class="gallery">

        <?php if (empty($model['photos'])): ?>
            <div class="col-span-full text-center py-16" style="column-span: all;">
                <iconify-icon icon="solar:gallery-circle-linear" class="text-6xl text-gray-300 mx-auto"></iconify-icon>
                <h3 class="text-xl font-semibold text-gray-600 mt-4">Belum ada foto</h3>
                <p class="text-gray-400 mt-2">Mulai tambahkan foto pertama Anda sekarang</p>
                <a href="/user/photo/add"
                    class="inline-block mt-4 px-6 py-3 bg-primary text-white rounded-2xl hover:opacity-90 transition">
                    Tambah Foto
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($model['photos'] as $photo):
                $imageFilename = $photo->image ?? '';
                $hasImage = !empty($imageFilename);
                ?>
                <!-- FOTO -->
                <div class="gallery-item group" data-id="<?= $photo->id ?>"
                    data-caption="<?= htmlspecialchars($photo->caption ?? '') ?>"
                    data-author="<?= htmlspecialchars($photo->userName ?? 'Admin') ?>"
                    data-date="<?= $photo->createdAt ? date('d M Y • H.i', strtotime($photo->createdAt)) . ' WIB' : '' ?>"
                    data-location="<?= htmlspecialchars($photo->location ?? '') ?>"
                    data-title="<?= htmlspecialchars($photo->caption ?: 'Foto Desa') ?>">

                    <div class="relative overflow-hidden rounded-[28px] bg-gray-100">

                        <?php if ($hasImage): ?>
                            <img src="/uploads/photos/<?= htmlspecialchars($imageFilename) ?>" loading="lazy"
                                alt="<?= htmlspecialchars($photo->caption ?: 'Foto Desa') ?>" class="w-full h-auto">
                        <?php else: ?>
                            <div class="flex items-center justify-center" style="min-height: 300px; background: #f3f4f6;">
                                <div class="text-center text-gray-400">
                                    <iconify-icon icon="solar:gallery-circle-linear" class="text-5xl mx-auto"></iconify-icon>
                                    <p class="text-sm mt-2">No Image</p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Admin Overlay -->
                        <div class="admin-overlay">
                            <a href="/user/photo/edit/<?= $photo->id ?>" class="edit-btn" title="Edit Foto">
                                <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                            </a>
                            <button class="delete-btn" title="Hapus Foto" onclick="openDeleteModal(<?= $photo->id ?>)">
                                <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                            </button>
                        </div>

                        <!-- Hover Info -->
                        <div class="hover-info">
                            <div class="text-white">
                                <h3><?= htmlspecialchars($photo->caption ?: 'Foto Desa') ?></h3>
                                <p>Oleh <?= htmlspecialchars($photo->userName ?? 'Admin') ?></p>
                                <?php if (!empty($photo->location)): ?>
                                    <p class="text-xs mt-1 opacity-80">
                                        <iconify-icon icon="solar:map-point-linear" class="inline"></iconify-icon>
                                        <?= htmlspecialchars($photo->location) ?>
                                    </p>
                                <?php endif; ?>
                                <p class="text-xs mt-1 opacity-60">
                                    <?= $photo->createdAt ? date('d M Y', strtotime($photo->createdAt)) : '' ?>
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <!-- LOAD MORE -->
    <div class="mt-20 text-center">

        <p class="text-gray-600 mb-6">
            Ingin melihat sejarah lengkap desa bungur?
        </p>

        <a href="#"
            class="inline-flex items-center gap-3 px-8 py-4 rounded-full border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-white transition duration-300">

            Muat lainnya?

        </a>

    </div>

</section>

<!-- ==========================================================
MODAL KONFIRMASI HAPUS
========================================================== -->

<div id="deleteModal" class="modal-overlay">

    <div class="modal-content">

        <button class="modal-close" id="closeDeleteModal">
            <iconify-icon icon="solar:close-circle-linear"></iconify-icon>
        </button>

        <div class="text-center">

            <iconify-icon icon="solar:trash-bin-trash-linear"
                style="font-size: 48px; color: #dc2626; margin-bottom: 16px;"></iconify-icon>

            <h3 class="text-2xl font-bold mb-3">
                Hapus Foto?
            </h3>

            <p class="text-gray-500 mb-6">
                Foto yang dihapus tidak dapat dikembalikan. Apakah Anda yakin?
            </p>

            <div class="btn-group">
                <button class="btn-submit cancel-btn" id="cancelDeleteBtn">
                    Batal
                </button>
                <form id="deleteForm" action="" method="POST" style="width:100%;">
                    <button type="submit" class="btn-submit delete-btn">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                        Hapus
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>

<script>
    (function () {
        'use strict';

        // ============================================================
        // 1. DOM REFERENCES
        // ============================================================

        const DOM = {
            gallery: document.getElementById('gallery'),
            searchInput: document.getElementById('searchInput'),
            deleteModal: document.getElementById('deleteModal'),
            closeDeleteModal: document.getElementById('closeDeleteModal'),
            cancelDeleteBtn: document.getElementById('cancelDeleteBtn'),
            deleteForm: document.getElementById('deleteForm'),
        };

        // ============================================================
        // 2. SEARCH FUNCTIONALITY
        // ============================================================

        function filterGallery(query) {
            const items = DOM.gallery.querySelectorAll('.gallery-item');
            const q = query.toLowerCase().trim();

            items.forEach(item => {
                const title = item.dataset.title || '';
                const caption = item.dataset.caption || '';
                const author = item.dataset.author || '';
                const location = item.dataset.location || '';

                const match = title.toLowerCase().includes(q) ||
                    caption.toLowerCase().includes(q) ||
                    author.toLowerCase().includes(q) ||
                    location.toLowerCase().includes(q);

                item.style.display = match ? '' : 'none';
            });
        }

        function debounce(fn, delay = 300) {
            let timeout = null;
            return function (...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    fn.apply(this, args);
                }, delay);
            };
        }

        // ============================================================
        // 3. DELETE MODAL FUNCTIONS
        // ============================================================

        window.openDeleteModal = function (id) {
            DOM.deleteForm.action = '/user/photo/delete/' + id;
            DOM.deleteModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        function closeDeleteModal() {
            DOM.deleteModal.classList.remove('active');
            document.body.style.overflow = '';
        }

        // ============================================================
        // 4. INITIALIZATION
        // ============================================================

        function init() {
            // Close delete modal
            if (DOM.closeDeleteModal) {
                DOM.closeDeleteModal.addEventListener('click', closeDeleteModal);
            }
            if (DOM.cancelDeleteBtn) {
                DOM.cancelDeleteBtn.addEventListener('click', closeDeleteModal);
            }

            // Close modal on overlay click
            DOM.deleteModal.addEventListener('click', function (e) {
                if (e.target === this) closeDeleteModal();
            });

            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    if (DOM.deleteModal.classList.contains('active')) closeDeleteModal();
                }
            });

            // Search
            if (DOM.searchInput) {
                const searchHandler = debounce(function () {
                    const q = this.value;
                    const items = DOM.gallery.querySelectorAll('.gallery-item');
                    items.forEach(item => {
                        const title = item.dataset.title || '';
                        const caption = item.dataset.caption || '';
                        const author = item.dataset.author || '';
                        const location = item.dataset.location || '';
                        const match = title.toLowerCase().includes(q) ||
                            caption.toLowerCase().includes(q) ||
                            author.toLowerCase().includes(q) ||
                            location.toLowerCase().includes(q);
                        item.style.display = match ? '' : 'none';
                    });
                }, 300);
                DOM.searchInput.addEventListener('input', searchHandler);
            }

            // Animation on load
            const items = DOM.gallery.querySelectorAll('.gallery-item');
            if (items.length > 0) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }, index * 50);
                        }
                    });
                });

                items.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    item.style.transition = 'all 0.6s ease';
                    observer.observe(item);
                });
            }

            console.log('✅ Galeri Foto berhasil diinisialisasi');
        }

        // ============================================================
        // 5. START
        // ============================================================

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }

    })();
</script>