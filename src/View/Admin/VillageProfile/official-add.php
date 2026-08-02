<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Tambah Aparatur Desa
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Tambahkan perangkat desa baru untuk ditampilkan di website Desa Bungur.
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
    <form action="/admin/profile/officials/add" method="POST" enctype="multipart/form-data">
        <div class="p-6 space-y-6">

            <!-- Nama Lengkap (WAJIB) -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="<?= htmlspecialchars($model['old']['name'] ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'Nama') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Masukkan nama lengkap..." required>
                <?php if (isset($model['error']) && strpos($model['error'], 'Nama') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Jabatan (WAJIB) -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                <select name="position"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                    <option value="">Pilih Jabatan</option>
                    <option value="Kepala Desa" <?= (isset($model['old']['position']) && $model['old']['position'] == 'Kepala Desa') ? 'selected' : '' ?>>Kepala Desa</option>
                    <option value="Sekretaris Desa" <?= (isset($model['old']['position']) && $model['old']['position'] == 'Sekretaris Desa') ? 'selected' : '' ?>>Sekretaris Desa</option>
                    <option value="Kaur Keuangan" <?= (isset($model['old']['position']) && $model['old']['position'] == 'Kaur Keuangan') ? 'selected' : '' ?>>Kaur Keuangan</option>
                    <option value="Kaur Umum" <?= (isset($model['old']['position']) && $model['old']['position'] == 'Kaur Umum') ? 'selected' : '' ?>>Kaur Umum</option>
                    <option value="Kaur Perencanaan" <?= (isset($model['old']['position']) && $model['old']['position'] == 'Kaur Perencanaan') ? 'selected' : '' ?>>Kaur Perencanaan</option>
                    <option value="Kasi Pemerintahan" <?= (isset($model['old']['position']) && $model['old']['position'] == 'Kasi Pemerintahan') ? 'selected' : '' ?>>Kasi Pemerintahan</option>
                    <option value="Kasi Kesejahteraan" <?= (isset($model['old']['position']) && $model['old']['position'] == 'Kasi Kesejahteraan') ? 'selected' : '' ?>>Kasi Kesejahteraan</option>
                    <option value="Kasi Pelayanan" <?= (isset($model['old']['position']) && $model['old']['position'] == 'Kasi Pelayanan') ? 'selected' : '' ?>>Kasi Pelayanan</option>
                    <option value="Staf Desa" <?= (isset($model['old']['position']) && $model['old']['position'] == 'Staf Desa') ? 'selected' : '' ?>>Staf Desa</option>
                </select>
                <?php if (isset($model['error']) && strpos($model['error'], 'Jabatan') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Periode (WAJIB) -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Periode <span class="text-red-500">*</span></label>
                <input type="text" name="period" value="<?= htmlspecialchars($model['old']['period'] ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'Periode') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Contoh: 2021-2026" required>
                <?php if (isset($model['error']) && strpos($model['error'], 'Periode') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <hr class="border-slate-200">

            <!-- Foto (OPSIONAL) -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Foto</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <p class="text-xs text-slate-400 mt-1">Upload foto aparatur (JPG, PNG, WEBP, GIF) - Maksimal 2MB</p>
                <p class="text-xs text-slate-400">Kosongkan jika tidak ingin upload, akan menggunakan avatar otomatis</p>
            </div>

            <hr class="border-slate-200">

            <!-- Info Kontak (SEMUA OPSIONAL) -->
            <div class="bg-slate-50 rounded-xl p-4 space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="font-semibold text-slate-700">Kontak & Informasi</h4>
                    <span class="text-xs text-slate-400">(Opsional)</span>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp" value="<?= htmlspecialchars($model['old']['whatsapp'] ?? '') ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="6281234567890">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Facebook</label>
                    <input type="url" name="facebook" value="<?= htmlspecialchars($model['old']['facebook'] ?? '') ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="https://facebook.com/...">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($model['old']['email'] ?? '') ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="email@desa.id">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Alamat</label>
                    <input type="text" name="address" value="<?= htmlspecialchars($model['old']['address'] ?? '') ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="Kantor Desa Bungur">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Embed Google Maps</label>
                    <input type="text" name="maps_embed_url" value="<?= htmlspecialchars($model['old']['maps_embed_url'] ?? '') ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="text-xs text-slate-400 mt-1">Copy link embed dari Google Maps</p>
                </div>
            </div>

            <!-- Status (WAJIB) -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="is_active"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                    <option value="1" <?= (isset($model['old']['is_active']) && $model['old']['is_active'] == 1) ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= (isset($model['old']['is_active']) && $model['old']['is_active'] == 0) ? 'selected' : '' ?>>Nonaktif</option>
                </select>
            </div>

        </div>

        <!-- Actions -->
        <div class="flex gap-3 p-6 pt-0 border-t border-slate-200">
            <a href="/admin/profile/officials"
                class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">
                Batal
            </a>
            <button type="submit"
                class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                Simpan Aparatur
            </button>
        </div>
    </form>
</div>