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
                   Sejarah
                </span>
            </div>
        </li>
    </ol>
</nav>


<!-- ==========================================================
    SEJARAH LENGKAP DESA
========================================================== -->

<section id="sejarah" class="py-16">

    <!-- Heading -->
    <div class="max-w-2xl mb-16">

        <span class="uppercase tracking-[0.25em] text-primary font-semibold text-sm">
            Sejarah Lengkap Desa
        </span>

        <h2 class="text-4xl font-bold mt-3">
            Perjalanan Desa Bungur
        </h2>

        <p class="mt-5 text-gray-600 leading-8">
            Sejarah Desa Bungur merupakan perjalanan panjang yang membentuk
            identitas, budaya, serta semangat gotong royong masyarakat hingga
            menjadi desa yang terus berkembang seperti saat ini.
        </p>

    </div>

    <div class="relative max-w-5xl mx-auto overflow-hidden">

        <!-- Garis Timeline -->
        <div class="absolute left-6 lg:left-1/2 top-0 bottom-0 w-[3px] bg-primary/20 -translate-x-1/2"></div>

        <?php if (!empty($model['histories'])): ?>
            <?php $count = count($model['histories']); ?>
            <?php foreach ($model['histories'] as $index => $history): ?>
                <?php $isEven = $index % 2 == 0; ?>

                <div
                    class="relative flex flex-col <?= $isEven ? 'lg:flex-row' : 'lg:flex-row-reverse' ?> items-center <?= $index < $count - 1 ? 'mb-20' : '' ?>">

                    <!-- Gambar (Desktop) -->
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

                    <!-- Icon Timeline -->
                    <div
                        class="absolute left-6 lg:left-1/2 -translate-x-1/2 w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center shadow-xl z-10">
                        <i data-lucide="flag"></i>
                    </div>

                    <!-- Konten -->
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
            <div class="text-center text-gray-400 py-16">
                <iconify-icon icon="solar:book-bookmark-linear" class="text-6xl mx-auto"></iconify-icon>
                <p class="mt-4">Belum ada data sejarah</p>
            </div>
        <?php endif; ?>

    </div>

</section>