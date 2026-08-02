<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Edit Sambutan Kepala Desa
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Edit sambutan dan profil Kepala Desa yang sudah ada.
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
    <?php $greeting = $model['greeting']; ?>
    <form action="/admin/landing/greetings/edit/<?= $greeting->id ?>" method="POST" enctype="multipart/form-data">
        <div class="p-6 space-y-6">

            <!-- Nama -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kepala Desa <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="<?= htmlspecialchars($model['old']['name'] ?? $greeting->name ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'Nama') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Masukkan nama Kepala Desa..." required>
                <?php if (isset($model['error']) && strpos($model['error'], 'Nama') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Opening -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Salam Pembuka <span class="text-red-500">*</span></label>
                <input type="text" name="opening" value="<?= htmlspecialchars($model['old']['opening'] ?? $greeting->opening ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                    placeholder="Salam pembuka..." required>
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Isi Sambutan <span class="text-red-500">*</span></label>
                <textarea name="content" rows="8"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 <?= isset($model['error']) && strpos($model['error'], 'Isi') !== false ? 'border-red-500' : '' ?>"
                    placeholder="Tulis sambutan Kepala Desa..." required><?= htmlspecialchars($model['old']['content'] ?? $greeting->content ?? '') ?></textarea>
                <?php if (isset($model['error']) && strpos($model['error'], 'Isi') !== false): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['error']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Closing -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Salam Penutup <span class="text-red-500">*</span></label>
                <input type="text" name="closing" value="<?= htmlspecialchars($model['old']['closing'] ?? $greeting->closing ?? '') ?>"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                    placeholder="Salam penutup..." required>
            </div>

            <hr class="border-slate-200">

            <!-- Foto Saat Ini -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Foto Saat Ini</label>
                <?php if (!empty($greeting->image)): ?>
                    <div class="mb-2">
                        <img src="/uploads/greeting/<?= htmlspecialchars($greeting->image) ?>" 
                             class="w-24 h-24 rounded-full object-cover border-2 border-slate-200" 
                             alt="<?= htmlspecialchars($greeting->name) ?>"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($greeting->name) ?>&size=80&background=15803d&color=fff'">
                        <p class="text-xs text-slate-400 mt-1">Gambar saat ini</p>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-slate-400">Belum ada foto</p>
                <?php endif; ?>
            </div>

            <!-- Upload Foto Baru -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ganti Foto</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <p class="text-xs text-slate-400 mt-1">Upload foto baru untuk mengganti (JPG, PNG, WEBP, GIF) - Maksimal 2MB</p>
                <p class="text-xs text-slate-400">Kosongkan jika tidak ingin mengganti</p>
            </div>

            <!-- Preview Foto Baru -->
            <div id="previewContainer" class="hidden">
                <label class="block text-sm font-medium text-slate-700 mb-1">Preview Foto Baru</label>
                <div class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-slate-200">
                    <img id="imagePreview" src="#" alt="Preview" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Tanda Tangan Saat Ini -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanda Tangan Saat Ini</label>
                <?php if (!empty($greeting->signatureImage)): ?>
                    <div class="mb-2">
                        <img src="/uploads/signature/<?= htmlspecialchars($greeting->signatureImage) ?>" 
                             class="w-48 h-16 object-contain border border-slate-200 rounded-lg p-2" 
                             alt="Tanda Tangan">
                        <p class="text-xs text-slate-400 mt-1">Tanda tangan saat ini</p>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-slate-400">Belum ada tanda tangan</p>
                <?php endif; ?>
            </div>

            <!-- Upload Tanda Tangan Baru -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ganti Tanda Tangan</label>
                <input type="file" name="signature_image" accept="image/*"
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <p class="text-xs text-slate-400 mt-1">Upload tanda tangan baru (JPG, PNG, WEBP, GIF) - Maksimal 2MB</p>
                <p class="text-xs text-slate-400">Kosongkan jika tidak ingin mengganti</p>
            </div>

            <!-- Preview Tanda Tangan Baru -->
            <div id="signaturePreviewContainer" class="hidden">
                <label class="block text-sm font-medium text-slate-700 mb-1">Preview Tanda Tangan Baru</label>
                <div class="relative w-48 h-16 border border-slate-200 rounded-lg overflow-hidden">
                    <img id="signaturePreview" src="#" alt="Preview Signature" class="w-full h-full object-contain">
                </div>
            </div>

        </div>

        <!-- Actions -->
        <div class="flex gap-3 p-6 pt-0 border-t border-slate-200">
            <a href="/admin/landing/greetings"
                class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">
                Batal
            </a>
            <button type="submit"
                class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                <iconify-icon icon="solar:check-circle-linear" width="18" class="inline mr-2"></iconify-icon>
                Update Sambutan
            </button>
        </div>
    </form>
</div>

<script>
    // Preview Foto
    document.querySelector('input[name="image"]').addEventListener('change', function(e) {
        const container = document.getElementById('previewContainer');
        const preview = document.getElementById('imagePreview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            container.classList.add('hidden');
        }
    });

    // Preview Tanda Tangan
    document.querySelector('input[name="signature_image"]').addEventListener('change', function(e) {
        const container = document.getElementById('signaturePreviewContainer');
        const preview = document.getElementById('signaturePreview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            container.classList.add('hidden');
        }
    });
</script>