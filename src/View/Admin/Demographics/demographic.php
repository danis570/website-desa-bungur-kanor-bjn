<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
    <div>
        <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">
            Website Desa Bungur
        </p>
        <h1 class="mt-2 text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">
            Manajemen Demografi
        </h1>
        <p class="mt-2 text-slate-500 max-w-2xl text-sm lg:text-base leading-relaxed">
            Kelola seluruh data kependudukan Desa Bungur.
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
DEMOGRAPHIC SUMMARY CARDS
========================================================== -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Penduduk -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Total Penduduk</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">
                    <?php 
                        // Hitung total dari semua kategori
                        $totalPenduduk = 0;
                        foreach ($model['summary']['gender']['data'] as $value) {
                            $totalPenduduk += $value;
                        }
                        echo number_format($totalPenduduk);
                    ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Jenis Kelamin -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Jenis Kelamin</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">
                    <?= count($model['summary']['gender']['data']) ?> Kategori
                </p>
            </div>
        </div>
    </div>

    <!-- Pendidikan -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Pendidikan</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">
                    <?= count($model['summary']['education']['data']) ?> Kategori
                </p>
            </div>
        </div>
    </div>

    <!-- Agama -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Agama</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">
                    <?= count($model['summary']['religion']['data']) ?> Kategori
                </p>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================
DEMOGRAPHIC DATA SECTIONS
========================================================== -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Jenis Kelamin -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                    <iconify-icon icon="solar:user-check-rounded-linear" class="text-blue-600"></iconify-icon>
                    Jenis Kelamin
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Data berdasarkan jenis kelamin</p>
            </div>
            <a href="/admin/demographic/gender/edit" 
               class="px-3 py-1.5 text-xs bg-slate-100 hover:bg-slate-200 rounded-lg transition flex items-center gap-1">
                <iconify-icon icon="solar:pen-2-linear" width="14"></iconify-icon>
                Edit
            </a>
        </div>
        <div class="p-6">
            <?php if (empty($model['summary']['gender']['data'])): ?>
                <div class="text-center py-8 text-slate-400">
                    <iconify-icon icon="solar:user-check-rounded-linear" class="text-4xl mx-auto"></iconify-icon>
                    <p class="mt-2 text-sm">Belum ada data</p>
                    <a href="/admin/demographic/gender/edit" class="text-primary text-sm hover:underline">Tambah data</a>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php 
                    $genderTotal = 0;
                    foreach ($model['summary']['gender']['data'] as $gender => $total) {
                        $genderTotal += $total;
                    }
                    foreach ($model['summary']['gender']['data'] as $gender => $total): 
                    ?>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700"><?= htmlspecialchars($gender) ?></span>
                                <span class="font-semibold text-slate-900"><?= number_format($total) ?></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" 
                                     style="width: <?= ($genderTotal > 0) ? round(($total / $genderTotal) * 100) : 0 ?>%">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between text-sm">
                    <span class="text-slate-500">Total</span>
                    <span class="font-bold text-slate-900"><?= number_format($genderTotal) ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pendidikan -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                    <iconify-icon icon="solar:book-bookmark-linear" class="text-purple-600"></iconify-icon>
                    Pendidikan
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Data berdasarkan tingkat pendidikan</p>
            </div>
            <a href="/admin/demographic/education/edit" 
               class="px-3 py-1.5 text-xs bg-slate-100 hover:bg-slate-200 rounded-lg transition flex items-center gap-1">
                <iconify-icon icon="solar:pen-2-linear" width="14"></iconify-icon>
                Edit
            </a>
        </div>
        <div class="p-6">
            <?php if (empty($model['summary']['education']['data'])): ?>
                <div class="text-center py-8 text-slate-400">
                    <iconify-icon icon="solar:book-bookmark-linear" class="text-4xl mx-auto"></iconify-icon>
                    <p class="mt-2 text-sm">Belum ada data</p>
                    <a href="/admin/demographic/education/edit" class="text-primary text-sm hover:underline">Tambah data</a>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php 
                    $educationTotal = 0;
                    foreach ($model['summary']['education']['data'] as $value) {
                        $educationTotal += $value;
                    }
                    foreach ($model['summary']['education']['data'] as $level => $total): 
                    ?>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700"><?= htmlspecialchars($level) ?></span>
                                <span class="font-semibold text-slate-900"><?= number_format($total) ?></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5">
                                <div class="bg-purple-600 h-2.5 rounded-full" 
                                     style="width: <?= ($educationTotal > 0) ? round(($total / $educationTotal) * 100) : 0 ?>%">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between text-sm">
                    <span class="text-slate-500">Total</span>
                    <span class="font-bold text-slate-900"><?= number_format($educationTotal) ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Agama -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                    <iconify-icon icon="solar:mosque-linear" class="text-green-600"></iconify-icon>
                    Agama
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Data berdasarkan agama</p>
            </div>
            <a href="/admin/demographic/religion/edit" 
               class="px-3 py-1.5 text-xs bg-slate-100 hover:bg-slate-200 rounded-lg transition flex items-center gap-1">
                <iconify-icon icon="solar:pen-2-linear" width="14"></iconify-icon>
                Edit
            </a>
        </div>
        <div class="p-6">
            <?php if (empty($model['summary']['religion']['data'])): ?>
                <div class="text-center py-8 text-slate-400">
                    <iconify-icon icon="solar:mosque-linear" class="text-4xl mx-auto"></iconify-icon>
                    <p class="mt-2 text-sm">Belum ada data</p>
                    <a href="/admin/demographic/religion/edit" class="text-primary text-sm hover:underline">Tambah data</a>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php 
                    $religionTotal = 0;
                    foreach ($model['summary']['religion']['data'] as $value) {
                        $religionTotal += $value;
                    }
                    foreach ($model['summary']['religion']['data'] as $religion => $total): 
                    ?>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700"><?= htmlspecialchars($religion) ?></span>
                                <span class="font-semibold text-slate-900"><?= number_format($total) ?></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5">
                                <div class="bg-green-600 h-2.5 rounded-full" 
                                     style="width: <?= ($religionTotal > 0) ? round(($total / $religionTotal) * 100) : 0 ?>%">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between text-sm">
                    <span class="text-slate-500">Total</span>
                    <span class="font-bold text-slate-900"><?= number_format($religionTotal) ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Kelompok Umur -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                    <iconify-icon icon="solar:calendar-linear" class="text-orange-600"></iconify-icon>
                    Kelompok Umur
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Data berdasarkan kelompok umur</p>
            </div>
            <a href="/admin/demographic/age-group/edit" 
               class="px-3 py-1.5 text-xs bg-slate-100 hover:bg-slate-200 rounded-lg transition flex items-center gap-1">
                <iconify-icon icon="solar:pen-2-linear" width="14"></iconify-icon>
                Edit
            </a>
        </div>
        <div class="p-6">
            <?php if (empty($model['summary']['age_group']['data'])): ?>
                <div class="text-center py-8 text-slate-400">
                    <iconify-icon icon="solar:calendar-linear" class="text-4xl mx-auto"></iconify-icon>
                    <p class="mt-2 text-sm">Belum ada data</p>
                    <a href="/admin/demographic/age-group/edit" class="text-primary text-sm hover:underline">Tambah data</a>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php 
                    $ageTotal = 0;
                    foreach ($model['summary']['age_group']['data'] as $value) {
                        $ageTotal += $value;
                    }
                    foreach ($model['summary']['age_group']['data'] as $ageRange => $total): 
                    ?>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700"><?= htmlspecialchars($ageRange) ?></span>
                                <span class="font-semibold text-slate-900"><?= number_format($total) ?></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5">
                                <div class="bg-orange-500 h-2.5 rounded-full" 
                                     style="width: <?= ($ageTotal > 0) ? round(($total / $ageTotal) * 100) : 0 ?>%">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between text-sm">
                    <span class="text-slate-500">Total</span>
                    <span class="font-bold text-slate-900"><?= number_format($ageTotal) ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>