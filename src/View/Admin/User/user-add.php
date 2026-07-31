<!-- ==========================================================
    HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Tambah Pengguna
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Tambahkan pengguna baru ke sistem administrasi Desa Bungur.
        </p>
    </div>
</div>

<?php if(isset($model['error'])): ?>

<div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-red-700">

    <?= $model['error'] ?>

</div>

<?php endif; ?>

<!-- ==========================================================
    FORM
========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
    <div class="p-6">
        <form method="POST" action="/admin/users/add" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="formName" name="name" value="<?= $_POST['name'] ?? '' ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="Masukkan nama lengkap..." required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" id="formEmail" name="email" value="<?= $_POST['email'] ?? '' ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="email@desa.id" required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password <span
                            class="text-red-500">*</span></label>
                    <input type="password" id="formPassword" name="password" value="<?= $_POST['password'] ?? '' ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="Masukkan password..." required>
                    <p class="password-hint">Minimal 8 karakter <span>*</span></p>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Role <span
                            class="text-red-500">*</span></label>
                    <select id="formRole" name="role"  value="<?= $_POST['role'] ?? '' ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Posisi -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Posisi</label>
                    <!-- Menjadi (input text) -->
                    <input type="text" id="formPosition" name="position"  value="<?= $_POST['position'] ?? '' ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="Masukkan posisi...">
                </div>

                <!-- Foto -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Foto</label>
                    <input type="file" id="formPhoto" name="avatar" accept="image/*" 
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    <p class="text-xs text-slate-400 mt-1">Upload foto (JPG, PNG, WEBP)</p>
                </div>
            </div>

            <!-- Preview Foto -->
            <div id="photoPreview" class="mt-4 hidden">
                <img id="previewImage" class="preview-thumb" alt="Preview">
            </div>

            <div class="flex gap-3 mt-8 pt-6 border-t">
                <button type="submit"
                    class="flex-1 px-4 py-3 rounded-xl bg-slate-900 text-white hover:bg-black transition flex items-center justify-center gap-2">
                    Simpan
                </button>
                <a href="/admin/users"
                    class="flex-1 px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-center text-sm font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================================
STYLE
========================================================== -->
<style>
    .preview-thumb {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #E2E8F0;
    }

    .password-hint {
        font-size: 12px;
        color: #94A3B8;
        margin-top: 4px;
    }

    .password-hint span {
        color: #EF4444;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(.96);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

<!-- ==========================================================
JAVASCRIPT
========================================================== -->
<script>
    // ==========================================================
    // DATA REFERENCE (sama dengan data di users.html)
    // ==========================================================
    // Untuk demo, kita gunakan data yang sama dengan users.html
    // Dalam implementasi nyata, data akan diambil dari server

    // ==========================================================
    // PHOTO PREVIEW
    // ==========================================================
    document.getElementById('formPhoto').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('photoPreview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
    // ==========================================================
    // TOAST
    // ==========================================================
    function showToast(message, type = 'info') {
        const oldToast = document.querySelector('.custom-toast');
        if (oldToast) oldToast.remove();

        const toast = document.createElement('div');
        toast.className = 'custom-toast fixed bottom-6 right-6 z-[99999] px-6 py-4 rounded-2xl shadow-2xl text-white text-sm font-medium max-w-md transition-all duration-300';

        const colors = {
            success: 'bg-green-600',
            error: 'bg-red-600',
            info: 'bg-blue-600',
            warning: 'bg-amber-600'
        };

        toast.className += ` ${colors[type] || colors.info}`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>