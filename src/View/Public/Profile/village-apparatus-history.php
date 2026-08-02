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
                    Riwayat Aparatur
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
        Arsip Pemerintahan
    </span>

    <h1 class="text-4xl font-bold mt-3">
        Riwayat Aparatur Desa Bungur
    </h1>

    <p class="text-gray-600 mt-6 max-w-3xl leading-8">
        Aktif saat ini & yang pernah menjabat
    </p>

</section>

<!-- ==========================================================
KEPALA DESA
========================================================== -->

<section class="py-4">

    <div class="mb-10">
        <h2 class="text-4xl font-bold mt-2">
            Kepala Desa
        </h2>
    </div>

    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-8">

        <?php
        // Filter Kepala Desa
        $kadesList = array_filter($model['officials'], function ($o) {
            return $o->position === 'Kepala Desa';
        });
        $kadesList = array_values($kadesList);
        ?>

        <?php if (!empty($kadesList)): ?>
            <?php foreach ($kadesList as $official): ?>
                <div
                    class="bg-white rounded-3xl shadow-md overflow-hidden hover:-translate-y-2 hover:shadow-xl transition <?= !$official->isActive ? 'opacity-70' : '' ?>">

                    <?php if (!empty($official->photo)): ?>
                        <img src="/uploads/official/<?= htmlspecialchars($official->photo) ?>" class="w-full h-56 object-cover"
                            alt="<?= htmlspecialchars($official->name) ?>"
                            onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=400&background=15803d&color=fff'">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=400&background=15803d&color=fff"
                            class="w-full h-56 object-cover" alt="<?= htmlspecialchars($official->name) ?>">
                    <?php endif; ?>

                    <div class="p-6">

                        <div class="flex justify-between items-start">

                            <div>
                                <h3 class="text-xl font-bold">
                                    <?= htmlspecialchars($official->name) ?>
                                </h3>
                                <p class="text-primary mt-1">
                                    <?= htmlspecialchars($official->position) ?>
                                </p>
                            </div>

                            <?php if ($official->isActive): ?>
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">
                                    Purnatugas
                                </span>
                            <?php endif; ?>

                        </div>

                        <div class="mt-6 space-y-3 text-sm">

                            <div class="flex justify-between">
                                <span class="text-gray-500">Periode</span>
                                <span class="font-semibold"><?= htmlspecialchars($official->period) ?></span>
                            </div>

                            <?php if (!empty($official->address)): ?>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Alamat</span>
                                    <span class="font-semibold"><?= htmlspecialchars($official->address) ?></span>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center text-gray-400 py-8">
                <p>Belum ada data Kepala Desa</p>
            </div>
        <?php endif; ?>

    </div>

</section>

<!-- ==========================================================
PERANGKAT DESA LAINNYA
========================================================== -->

<section class="pb-20">

    <?php
    // Kelompokkan perangkat desa lainnya berdasarkan posisi (bukan Kepala Desa)
    $otherOfficials = array_filter($model['officials'], function ($o) {
        return $o->position !== 'Kepala Desa';
    });

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
        <?php foreach ($groupedOfficials as $position => $officials): ?>

            <h2 class="text-4xl font-bold mb-10 mt-16">
                <?= htmlspecialchars($position) ?>
            </h2>

            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-8">

                <?php foreach ($officials as $official): ?>
                    <div
                        class="bg-white rounded-3xl shadow-md overflow-hidden hover:-translate-y-2 hover:shadow-xl transition <?= !$official->isActive ? 'opacity-70' : '' ?>">

                        <?php if (!empty($official->photo)): ?>
                            <img src="/uploads/official/<?= htmlspecialchars($official->photo) ?>" class="w-full h-56 object-cover"
                                alt="<?= htmlspecialchars($official->name) ?>"
                                onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=400&background=15803d&color=fff'">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=400&background=15803d&color=fff"
                                class="w-full h-56 object-cover" alt="<?= htmlspecialchars($official->name) ?>">
                        <?php endif; ?>

                        <div class="p-6">

                            <div class="flex justify-between items-start">

                                <div>

                                    <h3 class="text-xl font-bold">
                                        <?= htmlspecialchars($official->name) ?>
                                    </h3>

                                    <p class="text-primary mt-1">
                                        <?= htmlspecialchars($official->position) ?>
                                    </p>

                                </div>

                                <?php if ($official->isActive): ?>
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">
                                        Purnatugas
                                    </span>
                                <?php endif; ?>

                            </div>

                            <div class="mt-6 space-y-3 text-sm">

                                <div class="flex justify-between">

                                    <span class="text-gray-500">
                                        Periode
                                    </span>

                                    <span class="font-semibold">
                                        <?= htmlspecialchars($official->period ?: '-') ?>
                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span class="text-gray-500">
                                        Alamat
                                    </span>

                                    <span class="font-semibold text-right">
                                        <?= htmlspecialchars($official->address ?: '-') ?>
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center text-gray-400 py-12">
            <iconify-icon icon="solar:users-group-rounded-linear" class="text-6xl mx-auto"></iconify-icon>
            <p class="mt-4">Belum ada data perangkat desa lainnya</p>
        </div>
    <?php endif; ?>

</section>