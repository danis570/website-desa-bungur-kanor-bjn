<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Edit Data Jenis Kelamin
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Perbarui data demografi berdasarkan jenis kelamin.
        </p>
    </div>
</div>

<!-- ==========================================================
FLASH MESSAGES
========================================================== -->
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
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden max-w-2xl">
    <form action="/admin/demographic/gender/edit" method="POST">
        <div class="p-6 space-y-6">
            <?php 
            $genders = [];
            foreach ($model['genders'] as $g) {
                $genders[$g->gender] = $g->total;
            }
            $male = $genders['Laki-laki'] ?? 0;
            $female = $genders['Perempuan'] ?? 0;
            $total = $male + $female;
            ?>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Laki-laki</label>
                <input type="number" name="male" id="maleInput" value="<?= $male ?>" 
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                       placeholder="Jumlah laki-laki..." min="0" required 
                       oninput="updateTotal()">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Perempuan</label>
                <input type="number" name="female" id="femaleInput" value="<?= $female ?>" 
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-900/10"
                       placeholder="Jumlah perempuan..." min="0" required 
                       oninput="updateTotal()">
            </div>

            <div class="bg-slate-50 rounded-xl p-4 flex items-center justify-between">
                <span class="text-sm font-medium text-slate-600">Total Penduduk</span>
                <span class="text-xl font-bold text-slate-900" id="totalDisplay"><?= number_format($total) ?> jiwa</span>
            </div>
        </div>

        <div class="flex gap-3 p-6 pt-0 border-t border-slate-200">
            <a href="/admin/demographic" class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-medium">
                Batal
            </a>
            <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- ==========================================================
JAVASCRIPT
========================================================== -->
<script>
    function updateTotal() {
        const male = parseInt(document.getElementById('maleInput').value) || 0;
        const female = parseInt(document.getElementById('femaleInput').value) || 0;
        const total = male + female;
        document.getElementById('totalDisplay').textContent = total.toLocaleString('id-ID') + ' jiwa';
    }
</script>