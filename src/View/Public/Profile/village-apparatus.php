<!-- ==========================================================
BREADCRUMB
========================================================== -->

<nav class="flex mt-16" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="/"
                class="ml-1 inline-flex text-sm font-medium text-gray-500 hover:text-primary hover:underline md:ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="mr-4 h-4 w-4">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Home
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-400">/</span>
                <a href="/profil"
                    class="ml-1 text-sm font-medium text-gray-500 hover:text-primary hover:underline md:ml-2">
                    Profile
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-400">/</span>
                <span class="ml-1 text-sm font-medium text-gray-800 md:ml-2">
                    Aparatur Desa
                </span>
            </div>
        </li>
    </ol>
</nav>

<!-- ==========================================================
HEADER
========================================================== -->

<section class="py-16 bg-white">

    <span class="uppercase tracking-[0.25em] text-primary font-semibold text-sm">
        Aparatur Desa
    </span>

    <h1 class="text-4xl font-bold mt-3">
        Pemerintah Desa Bungur
    </h1>

    <p class="text-gray-600 mt-6 max-w-3xl leading-8">
        Aktif saat ini
    </p>

</section>

<!-- ==========================================================
KEPALA DESA
========================================================== -->

<section class="pb-20">

    <h2 class="text-3xl font-bold mb-10">
        Kepala Desa
    </h2>

    <?php
    // Filter Kepala Desa
    $kades = array_filter($model['officials'], function ($o) {
        return $o->position === 'Kepala Desa' && $o->isActive === true;
    });
    $kades = array_values($kades);
    ?>

    <?php if (!empty($kades)): ?>
        <?php foreach ($kades as $official): ?>
            <div class="bg-white rounded-3xl shadow-lg p-10">

                <div class="flex flex-col lg:flex-row items-center gap-10">

                    <?php if (!empty($official->photo)): ?>
                        <img src="/uploads/official/<?= htmlspecialchars($official->photo) ?>"
                            class="w-48 h-48 rounded-full object-cover" alt="<?= htmlspecialchars($official->name) ?>"
                            onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=200&background=15803d&color=fff'">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=200&background=15803d&color=fff"
                            class="w-48 h-48 rounded-full object-cover" alt="<?= htmlspecialchars($official->name) ?>">
                    <?php endif; ?>

                    <div>

                        <span class="text-primary font-semibold">
                            <?= htmlspecialchars($official->position) ?>
                        </span>

                        <h3 class="text-4xl font-bold mt-2">
                            <?= htmlspecialchars($official->name) ?>
                        </h3>

                        <p class="text-gray-500 text-sm mt-1">
                            Periode: <?= htmlspecialchars($official->period) ?>
                        </p>

                        <div class="mt-8 flex items-center gap-4">

                            <?php if (!empty($official->whatsapp)): ?>
                                <a href="https://wa.me/<?= htmlspecialchars($official->whatsapp) ?>" target="_blank"
                                    class="w-11 h-11 rounded-full bg-green-500 text-white flex items-center justify-center hover:scale-110 transition duration-300">
                                    <i class="bi bi-whatsapp text-xl"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($official->facebook)): ?>
                                <a href="<?= htmlspecialchars($official->facebook) ?>" target="_blank"
                                    class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center hover:scale-110 transition duration-300">
                                    <i class="bi bi-facebook text-xl"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($official->email)): ?>
                                <a href="mailto:<?= htmlspecialchars($official->email) ?>"
                                    class="w-11 h-11 rounded-full bg-red-500 text-white flex items-center justify-center hover:scale-110 transition duration-300">
                                    <i class="bi bi-envelope-fill text-xl"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($official->address)): ?>
                                <button type="button" onclick="copyAddress('<?= htmlspecialchars($official->address) ?>')"
                                    class="w-11 h-11 rounded-full bg-gray-700 text-white flex items-center justify-center hover:scale-110 transition duration-300"
                                    title="Salin Alamat">
                                    <i class="bi bi-geo-alt-fill text-xl"></i>
                                </button>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="bg-white rounded-3xl shadow-lg p-10 text-center text-gray-400">
            <p>Belum ada data Kepala Desa</p>
        </div>
    <?php endif; ?>

</section>

<!-- ==========================================================
PERANGKAT DESA LAINNYA
========================================================== -->

<section class="pb-20">

    <?php
    // Filter perangkat desa lainnya (bukan Kepala Desa)
    $otherOfficials = array_filter($model['officials'], function ($o) {
        return $o->position !== 'Kepala Desa' && $o->isActive === true;
    });

    // Kelompokkan berdasarkan posisi
    $groupedOfficials = [];
    foreach ($otherOfficials as $official) {
        $position = $official->position;
        if (!isset($groupedOfficials[$position])) {
            $groupedOfficials[$position] = [];
        }
        $groupedOfficials[$position][] = $official;
    }
    ?>

    <?php if (!empty($groupedOfficials)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">

            <?php foreach ($groupedOfficials as $position => $officials): ?>
                <div>
                    <h2 class="text-3xl font-bold mb-10">
                        <?= htmlspecialchars($position) ?>
                    </h2>

                    <?php foreach ($officials as $official): ?>
                        <div
                            class="bg-white rounded-3xl shadow-md p-8 text-center hover:-translate-y-2 hover:shadow-xl transition duration-300 mb-6">

                            <?php if (!empty($official->photo)): ?>
                                <img src="/uploads/official/<?= htmlspecialchars($official->photo) ?>"
                                    class="w-32 h-32 rounded-full mx-auto object-cover" alt="<?= htmlspecialchars($official->name) ?>"
                                    onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=128&background=15803d&color=fff'">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=128&background=15803d&color=fff"
                                    class="w-32 h-32 rounded-full mx-auto object-cover" alt="<?= htmlspecialchars($official->name) ?>">
                            <?php endif; ?>

                            <h3 class="text-xl font-bold mt-6">
                                <?= htmlspecialchars($official->name) ?>
                            </h3>

                            <p class="text-primary mt-2 font-medium">
                                <?= htmlspecialchars($official->position) ?>
                            </p>

                            <p class="text-gray-500 text-sm mt-1">
                                Periode: <?= htmlspecialchars($official->period) ?>
                            </p>

                            <div class="flex justify-center gap-3 mt-6">

                                <?php if (!empty($official->whatsapp)): ?>
                                    <a href="https://wa.me/<?= htmlspecialchars($official->whatsapp) ?>" target="_blank"
                                        class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center hover:scale-110 transition">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($official->facebook)): ?>
                                    <a href="<?= htmlspecialchars($official->facebook) ?>" target="_blank"
                                        class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:scale-110 transition">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($official->email)): ?>
                                    <a href="mailto:<?= htmlspecialchars($official->email) ?>"
                                        class="w-10 h-10 rounded-full bg-red-500 text-white flex items-center justify-center hover:scale-110 transition">
                                        <i class="bi bi-envelope-fill"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($official->address)): ?>
                                    <button type="button" onclick="copyAddress('<?= htmlspecialchars($official->address) ?>')"
                                        class="w-10 h-10 rounded-full bg-gray-700 text-white flex items-center justify-center hover:scale-110 transition"
                                        title="Salin Alamat">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </button>
                                <?php endif; ?>

                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

        </div>
    <?php else: ?>
        <div class="text-center text-gray-400 py-12">
            <iconify-icon icon="solar:users-group-rounded-linear" class="text-6xl mx-auto"></iconify-icon>
            <p class="mt-4">Belum ada perangkat desa lainnya</p>
        </div>
    <?php endif; ?>

</section>

<!-- ==========================================================
LINK RIWAYAT
========================================================== -->

<div class="mt-20 text-center">

    <p class="text-gray-600 mb-6">
        Ingin melihat daftar Kepala Desa dan perangkat desa yang pernah menjabat?
    </p>

    <a href="/profil/aparatur/semua"
        class="inline-flex items-center gap-3 px-8 py-4 rounded-full border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-white transition duration-300">

        Lihat Riwayat Aparatur Desa

        <i class="bi bi-clock-history"></i>

    </a>

</div>

<script>
    function copyAddress(address) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(address).then(() => {
                showToast('✅ Alamat berhasil disalin!', 'success');
            }).catch(() => {
                fallbackCopyAddress(address);
            });
        } else {
            fallbackCopyAddress(address);
        }
    }

    function fallbackCopyAddress(address) {
        const textarea = document.createElement('textarea');
        textarea.value = address;
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            showToast('✅ Alamat berhasil disalin!', 'success');
        } catch (e) {
            showToast('⚠️ Gagal menyalin alamat', 'error');
        }
        document.body.removeChild(textarea);
    }

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