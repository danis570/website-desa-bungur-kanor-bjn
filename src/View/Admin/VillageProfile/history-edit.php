<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Edit Sejarah Desa
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Edit timeline sejarah Desa Bungur yang sudah ada.
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
    <?php $history = $model['history']; ?>
    <form action="/admin/profile/histories/edit/<?= $history->id ?>" method="POST" enctype="multipart/form-data">
        <div class="p-6 space-y-6">

            <!-- Tahun -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                <input type="number" name="year" value="<?= htmlspecialchars($model['old']['year'] ?? $history->year ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'Tahun') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Contoh: 1923" min="1900" max="2100" required>
                <?php if (isset($model['error']) && strpos($model['error'], 'Tahun') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="<?= htmlspecialchars($model['old']['title'] ?? $history->title ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'Judul') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Masukkan judul peristiwa..." required>
                <?php if (isset($model['error']) && strpos($model['error'], 'Judul') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="6"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'Deskripsi') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Ceritakan peristiwa sejarah secara lengkap..." required><?= htmlspecialchars($model['old']['description'] ?? $history->description ?? '') ?></textarea>
                <?php if (isset($model['error']) && strpos($model['error'], 'Deskripsi') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <hr class="border-slate-200">

            <!-- Gambar -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gambar</label>
                <?php if (!empty($history->image)): ?>
                    <div class="mb-2">
                        <img src="/uploads/history/<?= htmlspecialchars($history->image) ?>" 
                             class="w-32 h-24 object-cover rounded-xl border border-slate-200" 
                             alt="<?= htmlspecialchars($history->title) ?>"
                             onerror="this.style.display='none'">
                        <p class="text-xs text-slate-400 mt-1">Gambar saat ini</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" accept="image/*"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <p class="text-xs text-slate-400 mt-1">Upload gambar baru untuk mengganti (JPG, PNG, WEBP, GIF) - Maksimal 2MB</p>
                <p class="text-xs text-slate-400">Kosongkan jika tidak ingin mengganti gambar</p>
            </div>

        </div>

        <!-- Actions -->
        <div class="flex gap-3 p-6 pt-0 border-t border-slate-200">
            <a href="/admin/profile/histories"
                class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">
                Batal
            </a>
            <button type="submit"
                class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                <iconify-icon icon="solar:check-circle-linear" width="18" class="inline mr-2"></iconify-icon>
                Update Sejarah
            </button>
        </div>
    </form>
</div>