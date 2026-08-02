<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Tambah Hero Banner
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Tambahkan banner hero baru untuk ditampilkan di halaman utama website Desa Bungur.
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
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden max-w-3xl">
    <form action="/admin/landing/banners/add" method="POST" enctype="multipart/form-data">
        <div class="p-6 space-y-6">

            <!-- Gambar -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gambar <span class="text-red-500">*</span></label>
                <input type="file" name="image" accept="image/*"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"
                    required>
                <p class="text-xs text-slate-400 mt-1">Upload gambar banner (JPG, PNG, WEBP, GIF) - Maksimal 2MB</p>
                <p class="text-xs text-slate-400">Rekomendasi ukuran: 1920 x 1080 pixel</p>
                <?php if (isset($model['error']) && strpos($model['error'], 'Gambar') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Preview -->
            <div id="previewContainer" class="hidden">
                <label class="block text-sm font-medium text-slate-700 mb-1">Preview Gambar</label>
                <div class="relative w-full rounded-xl overflow-hidden border border-slate-200">
                    <img id="imagePreview" src="#" alt="Preview" class="w-full h-48 object-cover">
                </div>
            </div>

            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="<?= htmlspecialchars($model['old']['title'] ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'Judul') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Masukkan judul banner..." required>
                <?php if (isset($model['error']) && strpos($model['error'], 'Judul') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                    placeholder="Masukkan deskripsi banner..."><?= htmlspecialchars($model['old']['description'] ?? '') ?></textarea>
            </div>

        </div>

        <!-- Actions -->
        <div class="flex gap-3 p-6 pt-0 border-t border-slate-200">
            <a href="/admin/landing/banners"
                class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">
                Batal
            </a>
            <button type="submit"
                class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                <iconify-icon icon="solar:check-circle-linear" width="18" class="inline mr-2"></iconify-icon>
                Simpan Banner
            </button>
        </div>
    </form>
</div>

<script>
    // Image preview
    document.querySelector('input[name="image"]').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('previewContainer');
        const preview = document.getElementById('imagePreview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            previewContainer.classList.add('hidden');
        }
    });
</script>