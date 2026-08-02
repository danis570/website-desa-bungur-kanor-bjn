<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Tambah Visi / Misi
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Tambahkan visi atau misi baru untuk Desa Bungur.
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
    <form action="/admin/profile/visions-missions/add" method="POST">
        <div class="p-6 space-y-6">

            <!-- Tipe -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tipe <span class="text-red-500">*</span></label>
                <select name="type"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                    <option value="vision" <?= (isset($model['old']['type']) && $model['old']['type'] == 'vision') ? 'selected' : '' ?>>Visi</option>
                    <option value="mission" <?= (isset($model['old']['type']) && $model['old']['type'] == 'mission') ? 'selected' : '' ?>>Misi</option>
                </select>
                <?php if (isset($model['error']) && strpos($model['error'], 'Tipe') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Deskripsi / Isi -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Isi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="6"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'Deskripsi') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Tulis visi atau misi desa..." required><?= htmlspecialchars($model['old']['description'] ?? '') ?></textarea>
                <?php if (isset($model['error']) && strpos($model['error'], 'Deskripsi') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Urutan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label>
                <input type="number" name="sort_order" value="<?= htmlspecialchars($model['old']['sort_order'] ?? 1) ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                    placeholder="1" min="1">
                <p class="text-xs text-slate-400 mt-1">Semakin kecil angka, semakin atas tampilannya</p>
            </div>

        </div>

        <!-- Actions -->
        <div class="flex gap-3 p-6 pt-0 border-t border-slate-200">
            <a href="/admin/profile/visions-missions"
                class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">
                Batal
            </a>
            <button type="submit"
                class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                <iconify-icon icon="solar:check-circle-linear" width="18" class="inline mr-2"></iconify-icon>
                Simpan
            </button>
        </div>
    </form>
</div>