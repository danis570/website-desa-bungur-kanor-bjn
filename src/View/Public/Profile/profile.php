<style>
    .aparaturSwiper {
        width: 100%;
        overflow: hidden;
    }

    .aparaturSwiper .swiper-slide {
        height: auto;
    }

    .aparaturSwiper .swiper-wrapper {
        align-items: stretch;
    }

    .aparaturSwiper .swiper-button-next,
    .aparaturSwiper .swiper-button-prev {
        color: #16a34a;
    }

    .aparaturSwiper .swiper-pagination-bullet-active {
        background: #16a34a;
    }
</style>

<!-- ==========================================================
    APARATUR DESA
========================================================== -->

<section id="aparatur" class="py-16">

    <!-- Heading -->
    <div class="max-w-2xl mb-16">

        <span class="uppercase tracking-[0.25em] text-primary font-semibold text-sm">
            Aparatur Desa
        </span>

        <h2 class="text-4xl font-bold mt-3">
            Pejabat aktif Desa Bungur
        </h2>

    </div>

    <div class="swiper aparaturSwiper">

        <div class="swiper-wrapper">

            <?php if (!empty($model['activeOfficials'])): ?>
                <?php foreach ($model['activeOfficials'] as $official): ?>
                    <div class="swiper-slide">

                        <div class="bg-white rounded-3xl shadow-lg p-8">

                            <div class="flex flex-col lg:flex-row gap-8 items-center">

                                <?php if (!empty($official->photo)): ?>
                                    <img src="/uploads/official/<?= htmlspecialchars($official->photo) ?>"
                                        class="w-40 h-40 rounded-full object-cover flex-shrink-0"
                                        alt="<?= htmlspecialchars($official->name) ?>"
                                        onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=160&background=15803d&color=fff'">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($official->name) ?>&size=160&background=15803d&color=fff"
                                        class="w-40 h-40 rounded-full object-cover flex-shrink-0"
                                        alt="<?= htmlspecialchars($official->name) ?>">
                                <?php endif; ?>

                                <div class="flex-1">

                                    <span
                                        class="inline-block px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-semibold">
                                        <?= htmlspecialchars($official->position) ?>
                                    </span>

                                    <h3 class="text-3xl font-bold mt-5">
                                        <?= htmlspecialchars($official->name) ?>
                                    </h3>

                                    <p class="text-gray-500 text-sm mt-2">
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
                                            <button type="button"
                                                onclick="copyAddress('<?= htmlspecialchars($official->address) ?>')"
                                                class="w-11 h-11 rounded-full bg-gray-700 text-white flex items-center justify-center hover:scale-110 transition duration-300"
                                                title="Salin Alamat">
                                                <i class="bi bi-geo-alt-fill text-xl"></i>
                                            </button>
                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="swiper-slide">
                    <div class="bg-white rounded-3xl shadow-lg p-8 text-center">
                        <p class="text-gray-500">Belum ada aparatur aktif</p>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <div class="swiper-pagination mt-8"></div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

    </div>

    <div class="mt-20 text-center">

        <p class="text-gray-600 mb-6">
            Ingin melihat daftar aparatur desa lainnya?
        </p>

        <a href="/profil/aparatur"
            class="inline-flex items-center gap-3 px-8 py-4 rounded-full border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-white transition duration-300">

            Aparatur Desa

        </a>

    </div>

</section>

<!-- ==========================================================
    VISI & MISI
========================================================== -->

<section id="visi-misi" class="py-16">

    <!-- Heading -->
    <div class="max-w-2xl mb-16">

        <span class="uppercase tracking-[0.25em] text-primary font-semibold text-sm">
            Visi & Misi
        </span>

        <h2 class="text-4xl font-bold mt-3">
            Arah Pembangunan Desa Bungur
        </h2>

    </div>

    <div class="grid lg:grid-cols-2 gap-8">

        <!-- VISI -->
        <div class="bg-white rounded-3xl shadow-lg p-10">

            <div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                <i data-lucide="eye" class="w-8 h-8"></i>
            </div>

            <h3 class="text-3xl font-bold mt-8">
                Visi
            </h3>

            <?php if (!empty($model['visions'])): ?>
                <?php foreach ($model['visions'] as $vision): ?>
                    <p class="mt-6 text-gray-600 leading-9 italic text-lg">
                        "<?= htmlspecialchars($vision->description) ?>"
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="mt-6 text-gray-400">Belum ada visi</p>
            <?php endif; ?>

        </div>

        <!-- MISI -->
        <div class="bg-white rounded-3xl shadow-lg p-10">

            <div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                <i data-lucide="target" class="w-8 h-8"></i>
            </div>

            <h3 class="text-3xl font-bold mt-8">
                Misi
            </h3>

            <div class="mt-8 space-y-5">

                <?php if (!empty($model['missions'])): ?>
                    <?php foreach ($model['missions'] as $mission): ?>
                        <div class="flex gap-4">

                            <div
                                class="w-9 h-9 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                <i data-lucide="check"></i>
                            </div>

                            <p class="text-gray-600 leading-7">
                                <?= htmlspecialchars($mission->description) ?>
                            </p>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-400">Belum ada misi</p>
                <?php endif; ?>

            </div>

        </div>

    </div>
</section>

<!-- ==========================================================
    SEJARAH DESA
========================================================== -->

<section id="sejarah" class="py-16">

    <!-- Heading -->
    <div class="max-w-2xl mb-16">

        <span class="uppercase tracking-[0.25em] text-primary font-semibold text-sm">
            Sejarah Desa
        </span>

        <h2 class="text-4xl font-bold mt-3">
            Desa Bungur tahun ke tahun
        </h2>

    </div>

    <div class="relative max-w-5xl mx-auto overflow-hidden">

        <!-- Garis Timeline -->
        <div class="absolute left-6 lg:left-1/2 top-0 bottom-0 w-[3px] bg-primary/20 -translate-x-1/2"></div>

        <?php if (!empty($model['latestHistories'])): ?>
            <?php $count = count($model['latestHistories']); ?>
            <?php foreach ($model['latestHistories'] as $index => $history): ?>
                <?php $isEven = $index % 2 == 0; ?>

                <div
                    class="relative flex flex-col <?= $isEven ? 'lg:flex-row' : 'lg:flex-row-reverse' ?> items-center <?= $index < $count - 1 ? 'mb-20' : '' ?>">

                    <div class="hidden lg:block lg:w-1/2 <?= $isEven ? 'pr-16 text-right' : 'pl-16' ?>"
                        data-aos="<?= $isEven ? 'fade-right' : 'fade-left' ?>">

                        <?php if (!empty($history->image)): ?>
                            <img src="/uploads/history/<?= htmlspecialchars($history->image) ?>"
                                class="rounded-3xl shadow-xl h-72 w-full object-cover"
                                alt="<?= htmlspecialchars($history->title) ?>"
                                onerror="this.src='https://picsum.photos/seed/history<?= $history->id ?>/800/500'">
                        <?php else: ?>
                            <img src="https://picsum.photos/seed/history<?= $history->id ?>/800/500"
                                class="rounded-3xl shadow-xl h-72 w-full object-cover"
                                alt="<?= htmlspecialchars($history->title) ?>">
                        <?php endif; ?>

                    </div>

                    <div
                        class="absolute left-6 lg:left-1/2 -translate-x-1/2 w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center shadow-xl z-10">
                        <i data-lucide="flag"></i>
                    </div>

                    <div class="lg:w-1/2 <?= $isEven ? 'lg:pl-16' : 'lg:pr-16' ?> mt-8 lg:mt-0"
                        data-aos="<?= $isEven ? 'fade-left' : 'fade-right' ?>">

                        <div class="bg-white rounded-3xl shadow-lg p-8">

                            <span class="text-primary font-bold text-lg">
                                <?= htmlspecialchars($history->year) ?>
                            </span>

                            <h3 class="text-2xl font-bold mt-3">
                                <?= htmlspecialchars($history->title) ?>
                            </h3>

                            <p class="mt-5 text-gray-600 leading-8">
                                <?= htmlspecialchars($history->description) ?>
                            </p>

                        </div>

                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-gray-400 py-12">
                <p>Belum ada data sejarah</p>
            </div>
        <?php endif; ?>

    </div>

    <div class="mt-20 text-center">

        <p class="text-gray-600 mb-6">
            Ingin melihat sejarah lengkap desa bungur?
        </p>

        <a href="/profil/sejarah"
            class="inline-flex items-center gap-3 px-8 py-4 rounded-full border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-white transition duration-300">

            Sejarah lengkap

        </a>

    </div>

</section>