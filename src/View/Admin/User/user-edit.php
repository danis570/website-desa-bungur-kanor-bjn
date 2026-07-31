<!-- ==========================================================
    HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Edit Pengguna
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Edit data pengguna di sistem administrasi Desa Bungur.
        </p>
    </div>
</div>

<?php if (isset($model['error'])): ?>
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
        <div class="flex items-start gap-3">
            <iconify-icon icon="solar:danger-circle-bold" width="22" class="text-red-500 mt-0.5">
            </iconify-icon>

            <div>
                <h3 class="font-semibold text-red-700">
                    Gagal memperbarui pengguna
                </h3>

                <p class="text-sm text-red-600 mt-1">
                    <?= htmlspecialchars($model['error']) ?>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- ==========================================================
    FORM
========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
    <div class="p-6">
        <form method="POST" action="/admin/users/update" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="hidden" name="id" value="<?= $model['editUser']->id ?>">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" value="<?= htmlspecialchars($model['editUser']->name) ?>"
                        id="formName"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="Masukkan nama lengkap..." required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" value="<?= htmlspecialchars($model['editUser']->email) ?>"
                        id="formEmail" value="admin@desa.id"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="email@desa.id" required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password <span
                            class="text-xs text-slate-400">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" id="formPassword"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="Kosongkan untuk tetap sama">
                    <p class="password-hint">Minimal 6 karakter <span>*</span></p>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Role <span
                            class="text-red-500">*</span></label>
                    <select name="role" id="formRole"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                        <option value="user" <?= $model['editUser']->role == "user" ? "selected" : "" ?>>
                            User
                        </option>

                        <option value="admin" <?= $model['editUser']->role == "admin" ? "selected" : "" ?>>
                            Admin
                        </option>
                    </select>
                </div>

                <!-- Posisi -->
                <!-- Posisi -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Posisi</label>
                    <!-- Menjadi (input text) -->
                    <input type="text" id="formPosition" name="position"
                        value="<?= htmlspecialchars($model['editUser']->position) ?>"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                        placeholder="Masukkan posisi...">
                </div>

                <!-- Foto -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Foto</label>

                    <div class="mb-3">
                        <img id="previewImage" src="<?= $model['editUser']->avatar
                            ? '/uploads/avatar/' . $model['editUser']->avatar
                            : 'https://ui-avatars.com/api/?name=' . urlencode($model['editUser']->name) ?>"
                            class="preview-thumb" alt="<?= htmlspecialchars($model['editUser']->name) ?>">

                        <p class="text-xs text-slate-400 mt-1">
                            Foto saat ini
                        </p>
                    </div>

                    <input type="file" id="formPhoto" name="avatar" accept="image/*" class="w-full rounded-xl border border-slate-200 px-4 py-2.5
                        focus:outline-none focus:ring-2 focus:ring-slate-900/10
                        file:mr-4 file:py-1.5 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-medium
                        file:bg-slate-100 file:text-slate-700
                        hover:file:bg-slate-200">

                    <p class="text-xs text-slate-400 mt-1">
                        Upload foto baru (JPG, PNG, WEBP)
                    </p>
                </div>
            </div>

            <div class="flex gap-3 mt-8 pt-6 border-t">
                <button type="submit"
                    class="flex-1 px-4 py-3 rounded-xl bg-slate-900 text-white hover:bg-black transition flex items-center justify-center gap-2">
                    Update
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

<script>
    // ==========================================================
    // GET ID FROM URL
    // ==========================================================
    function getParameterByName(name) {
        const url = new URL(window.location.href);
        return url.searchParams.get(name);
    }

    const userId = getParameterByName('id');

    // ==========================================================
    // PHOTO PREVIEW
    // ==========================================================
    document.getElementById("formPhoto").addEventListener("change", function (e) {
        const file = e.target.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (event) {
            document.getElementById("previewImage").src = event.target.result;
        };

        reader.readAsDataURL(file);
    });

    // ==========================================================
    // FORM SUBMIT
    // ==========================================================
    document.getElementById('editUserForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('formName').value.trim();
        const email = document.getElementById('formEmail').value.trim();
        const password = document.getElementById('formPassword').value;
        const role = document.getElementById('formRole').value;
        const position = document.getElementById('formPosition').value;

        // Validasi
        if (!name || !email) {
            showToast('⚠️ Nama dan Email wajib diisi!', 'warning');
            return;
        }

        if (password && password.length < 6) {
            showToast('⚠️ Password minimal 6 karakter!', 'warning');
            return;
        }

        // Proses update data
        // Dalam implementasi nyata, kirim ke server via AJAX
        showToast('✅ Pengguna berhasil diupdate', 'success');

        // Redirect ke halaman users setelah 1 detik
        setTimeout(() => {
            window.location.href = '/users';
        }, 1000);
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