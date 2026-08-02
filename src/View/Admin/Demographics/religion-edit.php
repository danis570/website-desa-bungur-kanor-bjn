<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Edit Data Agama
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Perbarui data demografi berdasarkan agama.
        </p>
    </div>
</div>

<!-- ==========================================================
FLASH MESSAGES
========================================================== -->
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

<!-- ==========================================================
FORM
========================================================== -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <form action="/admin/demographic/religion/edit" method="POST">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-slate-700">Data Agama</h3>
                <button type="button" onclick="addReligionRow()"
                    class="px-3 py-1.5 text-sm bg-primary text-white rounded-lg hover:opacity-90 transition flex items-center gap-1">
                    <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                    Tambah
                </button>
            </div>

            <div id="religionContainer" class="space-y-3">
                <?php if (empty($model['religions'])): ?>
                    <!-- Default row jika kosong -->
                    <div
                        class="religion-row grid grid-cols-1 md:grid-cols-2 gap-3 items-end bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Agama</label>
                            <input type="text" name="religion[]"
                                class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                                placeholder="Contoh: Islam, Kristen, Hindu..." required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Jumlah</label>
                            <input type="number" name="religion_total[]"
                                class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                                placeholder="0" min="0" required>
                        </div>
                        <button type="button" onclick="removeReligionRow(this)"
                            class="text-red-500 hover:text-red-700 transition p-1">
                            <iconify-icon icon="solar:trash-bin-trash-linear" width="18"></iconify-icon>
                        </button>
                    </div>
                <?php else: ?>
                    <?php foreach ($model['religions'] as $religion): ?>
                        <div
                            class="religion-row grid grid-cols-1 md:grid-cols-2 gap-3 items-end bg-slate-50 rounded-xl p-4 border border-slate-200">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Agama</label>
                                <input type="text" name="religion[]" value="<?= htmlspecialchars($religion->religion) ?>"
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                                    placeholder="Contoh: Islam, Kristen, Hindu..." required>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Jumlah</label>
                                <input type="number" name="religion_total[]" value="<?= $religion->total ?>"
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                                    placeholder="0" min="0" required>
                            </div>
                            <button type="button" onclick="removeReligionRow(this)"
                                class="text-red-500 hover:text-red-700 transition p-1">
                                <iconify-icon icon="solar:trash-bin-trash-linear" width="18"></iconify-icon>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Total -->
            <div class="mt-6 bg-slate-50 rounded-xl p-4 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-600">Total Agama</span>
                <span class="text-xl font-bold text-slate-900" id="totalReligion">0</span>
            </div>
        </div>

        <div class="flex gap-3 p-6 pt-0 border-t border-slate-200">
            <a href="/admin/demographic"
                class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">
                Batal
            </a>
            <button type="submit"
                class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                <iconify-icon icon="solar:check-circle-linear" width="18" class="inline mr-2"></iconify-icon>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- ==========================================================
JAVASCRIPT
========================================================== -->
<script>
    // ==========================================================
    // ADD RELIGION ROW
    // ==========================================================
    function addReligionRow() {
        const container = document.getElementById('religionContainer');
        const row = document.createElement('div');
        row.className = 'religion-row grid grid-cols-1 md:grid-cols-2 gap-3 items-end bg-slate-50 rounded-xl p-4 border border-slate-200';
        row.innerHTML = `
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Agama</label>
                <input type="text" name="religion[]" 
                       class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                       placeholder="Contoh: Islam, Kristen, Hindu..." required>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Jumlah</label>
                <input type="number" name="religion_total[]" 
                       class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                       placeholder="0" min="0" required>
            </div>
            <button type="button" onclick="removeReligionRow(this)" 
                    class="text-red-500 hover:text-red-700 transition p-1">
                <iconify-icon icon="solar:trash-bin-trash-linear" width="18"></iconify-icon>
            </button>
        `;
        container.appendChild(row);
        updateTotal();
    }

    // ==========================================================
    // REMOVE RELIGION ROW
    // ==========================================================
    function removeReligionRow(btn) {
        const container = document.getElementById('religionContainer');
        if (container.children.length > 1) {
            btn.closest('.religion-row').remove();
            updateTotal();
        } else {
            showToast('⚠️ Minimal harus ada 1 data agama!', 'warning');
        }
    }

    // ==========================================================
    // UPDATE TOTAL
    // ==========================================================
    function updateTotal() {
        const totals = document.querySelectorAll('input[name="religion_total[]"]');
        let sum = 0;
        totals.forEach(input => {
            const val = parseInt(input.value) || 0;
            sum += val;
        });
        document.getElementById('totalReligion').textContent = sum.toLocaleString('id-ID');
    }

    // ==========================================================
    // TOAST NOTIFICATION
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

    // ==========================================================
    // EVENT LISTENERS
    // ==========================================================
    document.addEventListener('DOMContentLoaded', function () {
        // Update total on input change
        document.querySelectorAll('input[name="religion_total[]"]').forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        // Initial total
        updateTotal();
    });

    // Re-attach event listeners after adding new row
    document.addEventListener('input', function (e) {
        if (e.target && e.target.name === 'religion_total[]') {
            updateTotal();
        }
    });
</script>