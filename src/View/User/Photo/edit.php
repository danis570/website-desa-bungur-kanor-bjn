<div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between mb-10">

    <div>
        <span class="text-sm tracking-[0.25em] uppercase text-primary font-semibold">
            Dashboard
        </span>
        <h1 class="text-4xl font-bold mt-2">
            Edit Foto
        </h1>
        <p class="text-gray-500 mt-2">
            Edit informasi foto yang sudah ada.
        </p>
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

<!-- Form -->
<div class="bg-white rounded-3xl shadow-sm p-8 mb-32 max-w-3xl">
    <?php $photo = $model['photo']; ?>
    <form action="/user/photo/edit/<?= $photo->id ?>" method="POST" enctype="multipart/form-data">

        <!-- Caption -->
        <div class="mb-6">
            <label for="caption" class="block text-sm font-semibold text-gray-700 mb-2">
                Caption / Judul Foto <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="caption" 
                   name="caption" 
                   value="<?= htmlspecialchars($model['old']['caption'] ?? $photo->caption ?? '') ?>"
                   placeholder="Masukkan judul atau caption foto..."
                   class="w-full px-4 py-3 rounded-2xl border <?= isset($model['errors']['caption']) ? 'border-red-500' : 'border-gray-200' ?> focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
            <?php if (isset($model['errors']['caption'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['errors']['caption']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Location -->
        <div class="mb-6">
            <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">
                Lokasi
            </label>
            <input type="text" 
                   id="location" 
                   name="location" 
                   value="<?= htmlspecialchars($model['old']['location'] ?? $photo->location ?? '') ?>"
                   placeholder="Contoh: Lapangan Desa Bungur, Dusun Krajan..."
                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
        </div>

        <!-- Current Image -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Foto Saat Ini
            </label>
            <div class="relative w-full max-w-md rounded-2xl overflow-hidden border border-gray-200">
                <img src="/uploads/photos/<?= htmlspecialchars($photo->image ?? 'default-photo.jpg') ?>" 
                     alt="<?= htmlspecialchars($photo->caption ?? 'Foto') ?>"
                     class="w-full h-auto"
                     onerror="this.src='/uploads/photos/default-photo.jpg'">
            </div>
        </div>

        <!-- Upload New Image -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                Ganti Foto (Opsional)
            </label>
            <div class="relative">
                <input type="file" 
                       id="image" 
                       name="image" 
                       accept="image/*"
                       class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:opacity-90">
            </div>
            <p class="text-gray-400 text-sm mt-2">
                Format: JPG, PNG, WebP, GIF. Maksimal 2MB.
            </p>
            <?php if (isset($model['errors']['image'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($model['errors']['image']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Preview New Image -->
        <div class="mb-6 hidden" id="previewContainer">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Preview Foto Baru
            </label>
            <div class="relative w-full max-w-md rounded-2xl overflow-hidden border border-gray-200">
                <img id="imagePreview" src="#" alt="Preview" class="w-full h-auto">
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <a href="/user/photo" 
               class="px-6 py-3 rounded-2xl border border-gray-300 hover:bg-gray-50 transition font-semibold">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-3 rounded-2xl bg-primary text-white font-semibold hover:opacity-90 transition flex items-center gap-2">
                <iconify-icon icon="solar:check-circle-linear"></iconify-icon>
                Update Foto
            </button>
        </div>

    </form>
</div>

<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
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