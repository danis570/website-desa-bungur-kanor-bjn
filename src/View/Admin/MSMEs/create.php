<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Tambah UMKM
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Tambahkan UMKM baru untuk ditampilkan di website Desa Bungur.
        </p>
    </div>
</div>

<!-- ==========================================================
FLASH MESSAGES
========================================================== -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="mb-6 px-6 py-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-center justify-between">
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
    <div class="mb-6 px-6 py-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center justify-between">
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

<!-- ==========================================================
FORM
========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <form action="/admin/umkm/add" method="POST" enctype="multipart/form-data">
        <div class="p-6 space-y-6">

            <!-- Nama UMKM -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama UMKM <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="<?= htmlspecialchars($model['old']['name'] ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) ? 'border-red-500' : '' ?>"
                    placeholder="Masukkan nama UMKM..." required>
                <?php if (isset($model['error']) && strpos($model['error'], 'Nama UMKM') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Pemilik -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Pemilik <span class="text-red-500">*</span></label>
                <input type="text" name="owner" value="<?= htmlspecialchars($model['old']['owner'] ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'pemilik') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Masukkan nama pemilik..." required>
                <?php if (isset($model['error']) && strpos($model['error'], 'pemilik') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($model['categories'] as $category): ?>
                        <option value="<?= $category->id ?>" <?= (isset($model['old']['category_id']) && $model['old']['category_id'] == $category->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($model['error']) && strpos($model['error'], 'Kategori') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                <input type="text" name="address" value="<?= htmlspecialchars($model['old']['address'] ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                    placeholder="Masukkan alamat lengkap..." required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                    placeholder="Masukkan deskripsi UMKM..."><?= htmlspecialchars($model['old']['description'] ?? '') ?></textarea>
            </div>

            <hr class="border-slate-200">

            <!-- ==========================================================
            MENU / PRODUK - TAMBAHKAN DI SINI
            ========================================================== -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-slate-700">Menu / Produk</h4>
                    <span class="text-xs text-slate-400">Tambahkan menu atau produk yang dijual</span>
                </div>

                <div id="menuContainer" class="space-y-3">
                    <!-- Default 1 menu -->
                    <div class="menu-item bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Nama Menu <span class="text-red-500">*</span></label>
                                <input type="text" name="menu_name[]" 
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                                    placeholder="Nama menu..." required>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Harga <span class="text-red-500">*</span></label>
                                <input type="text" name="menu_price[]" 
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 price-input"
                                    placeholder="Rp 10.000" required 
                                    oninput="formatRupiah(this)">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="block text-xs font-medium text-slate-500 mb-1">Foto Menu</label>
                            <input type="file" name="menu_image[]" accept="image/*"
                                class="w-full rounded-lg border border-slate-200 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        </div>
                        <button type="button" onclick="removeMenu(this)" 
                            class="mt-3 text-xs text-red-500 hover:text-red-700 transition flex items-center gap-1">
                            <iconify-icon icon="solar:trash-bin-trash-linear" width="14"></iconify-icon>
                            Hapus Menu
                        </button>
                    </div>
                </div>

                <button type="button" onclick="addMenu()" 
                    class="mt-3 px-4 py-2 rounded-lg border border-dashed border-slate-300 text-slate-500 hover:border-slate-900 hover:text-slate-900 transition text-sm flex items-center gap-2">
                    <iconify-icon icon="solar:add-circle-linear" width="18"></iconify-icon>
                    Tambah Menu Lainnya
                </button>
            </div>

            <hr class="border-slate-200">

            <!-- Info Usaha -->
            <div class="bg-slate-50 rounded-xl p-4 space-y-4">
                <h4 class="font-semibold text-slate-700">Info Usaha</h4>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Jam Operasional</label>
                    <input type="text" name="business_hours" value="<?= htmlspecialchars($model['old']['business_hours'] ?? '') ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="08.00 - 17.00 WIB">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp" value="<?= htmlspecialchars($model['old']['whatsapp'] ?? '') ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="6281234567890">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Embed Google Maps</label>
                    <input type="text" name="maps_embed_url" value="<?= htmlspecialchars($model['old']['maps_embed_url'] ?? '') ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="text-xs text-slate-400 mt-1">Copy link embed dari Google Maps</p>
                </div>
            </div>

            <hr class="border-slate-200">

            <!-- Foto -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Foto Utama</label>
                <input type="file" name="featured_image" accept="image/*"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <p class="text-xs text-slate-400 mt-1">Upload foto utama UMKM (JPG, PNG, WEBP, GIF) - Maksimal 2MB</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Foto Pemilik</label>
                <input type="file" name="owner_photo" accept="image/*"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <p class="text-xs text-slate-400 mt-1">Upload foto pemilik UMKM (JPG, PNG, WEBP, GIF) - Maksimal 2MB</p>
            </div>

        </div>

        <!-- Actions -->
        <div class="flex gap-3 p-6 pt-0 border-t border-slate-200">
            <a href="/admin/umkm"
                class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">
                Batal
            </a>
            <button type="submit"
                class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                Simpan UMKM
            </button>
        </div>
    </form>
</div>

<!-- ==========================================================
JAVASCRIPT - UNTUK MENU DINAMIS
========================================================== -->
<script>
    // ==========================================================
    // FORMAT RUPIAH
    // ==========================================================
    function formatRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value) {
            value = parseInt(value);
            input.value = 'Rp ' + value.toLocaleString('id-ID');
        } else {
            input.value = '';
        }
    }

    // Format existing price inputs on load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.price-input').forEach(input => {
            if (input.value && !input.value.startsWith('Rp')) {
                const num = parseFloat(input.value);
                if (!isNaN(num) && num > 0) {
                    input.value = 'Rp ' + num.toLocaleString('id-ID');
                }
            }
        });
    });

    // ==========================================================
    // ADD MENU
    // ==========================================================
    function addMenu() {
        const container = document.getElementById('menuContainer');
        const menuCount = container.children.length;
        
        const div = document.createElement('div');
        div.className = 'menu-item bg-slate-50 rounded-xl p-4 border border-slate-200';
        div.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Nama Menu <span class="text-red-500">*</span></label>
                    <input type="text" name="menu_name[]" 
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="Nama menu..." required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Harga <span class="text-red-500">*</span></label>
                    <input type="text" name="menu_price[]" 
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 price-input"
                        placeholder="Rp 10.000" required 
                        oninput="formatRupiah(this)">
                </div>
            </div>
            <div class="mt-3">
                <label class="block text-xs font-medium text-slate-500 mb-1">Foto Menu</label>
                <input type="file" name="menu_image[]" accept="image/*"
                    class="w-full rounded-lg border border-slate-200 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
            </div>
            <button type="button" onclick="removeMenu(this)" 
                class="mt-3 text-xs text-red-500 hover:text-red-700 transition flex items-center gap-1">
                <iconify-icon icon="solar:trash-bin-trash-linear" width="14"></iconify-icon>
                Hapus Menu
            </button>
        `;
        container.appendChild(div);
        
        // Scroll ke menu baru
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // ==========================================================
    // REMOVE MENU
    // ==========================================================
    function removeMenu(btn) {
        const container = document.getElementById('menuContainer');
        if (container.children.length > 1) {
            btn.closest('.menu-item').remove();
        } else {
            // Tampilkan notifikasi jika hanya 1 menu
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-red-500 text-sm mt-2 flex items-center gap-2';
            errorDiv.innerHTML = `
                <iconify-icon icon="solar:danger-circle-linear" width="16"></iconify-icon>
                Minimal harus ada 1 menu/produk
            `;
            
            const parent = btn.closest('.menu-item');
            const existingError = parent.querySelector('.text-red-500');
            if (!existingError) {
                parent.appendChild(errorDiv);
                setTimeout(() => {
                    if (errorDiv.parentNode) {
                        errorDiv.remove();
                    }
                }, 3000);
            }
        }
    }
</script>