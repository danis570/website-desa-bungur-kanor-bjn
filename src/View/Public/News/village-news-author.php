<!-- ==========================================================
BREADCRUMB
========================================================== -->

<nav class="flex my-16" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="/" class="ml-1 inline-flex text-sm font-medium text-gray-500 hover:text-primary hover:underline md:ml-2">
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
                <a href="/kabar" class="ml-1 text-sm font-medium text-gray-500 hover:text-primary hover:underline md:ml-2">
                    Kabar Desa
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-400">/</span>
                <span class="ml-1 text-sm font-medium text-gray-800 md:ml-2">
                    Penulis: <?= htmlspecialchars(urldecode($model['authorName'])) ?>
                </span>
            </div>
        </li>
    </ol>
</nav>

<!-- ==========================================================
AUTHOR PROFILE
========================================================== -->

<?php if (!empty($model['authorInfo'])): ?>
    <div class="bg-white rounded-3xl shadow-lg p-8 mb-12">
        <div class="flex flex-col sm:flex-row items-center gap-6">

            <!-- Avatar -->
            <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-primary to-indigo-400 p-[2px] flex-shrink-0">
                <?php if (!empty($model['authorInfo']->avatar)): ?>
                    <img class="w-full h-full object-cover border-white border-2 rounded-full"
                        src="/uploads/avatar/<?= htmlspecialchars($model['authorInfo']->avatar) ?>"
                        alt="<?= htmlspecialchars($model['authorInfo']->name) ?>"
                        onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($model['authorInfo']->name) ?>&size=96&background=15803d&color=fff'">
                <?php else: ?>
                    <img class="w-full h-full object-cover border-white border-2 rounded-full"
                        src="https://ui-avatars.com/api/?name=<?= urlencode($model['authorInfo']->name) ?>&size=96&background=15803d&color=fff"
                        alt="<?= htmlspecialchars($model['authorInfo']->name) ?>">
                <?php endif; ?>
            </div>

            <div class="text-center sm:text-left">
                <h1 class="text-3xl font-bold text-gray-900">
                    <?= htmlspecialchars($model['authorInfo']->name) ?>
                </h1>
                <p class="text-gray-500 text-lg">
                    <?= htmlspecialchars($model['authorInfo']->position ?? 'Penulis') ?>
                </p>
                <p class="text-gray-400 text-sm mt-2">
                    <?= count($model['articles']) ?> artikel yang ditulis
                </p>
            </div>

        </div>
    </div>
<?php endif; ?>

<!-- ==========================================================
HEADING
========================================================== -->

<div class="my-16">

    <span class="text-sm tracking-[0.25em] uppercase text-primary font-semibold">
        Artikel
    </span>

    <h2 class="text-3xl font-bold mt-4">
        <?= count($model['articles']) ?> Artikel oleh <?= htmlspecialchars(urldecode($model['authorName'])) ?>
    </h2>

</div>

<!-- ==========================================================
GRID
========================================================== -->

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-32">

    <?php if (!empty($model['articles'])): ?>
        <?php foreach ($model['articles'] as $article): ?>
            <article>
                <a href="/kabar/detail/<?= htmlspecialchars($article->slug) ?>" class="group block" data-aos="fade-up">

                    <div class="relative overflow-hidden rounded-3xl shadow-lg">

                        <img src="/uploads/articles/<?= htmlspecialchars($article->image ?? 'default-news.jpg') ?>"
                            class="w-full h-72 object-cover transition duration-700 group-hover:scale-110"
                            alt="<?= htmlspecialchars($article->imageAlt ?? $article->title) ?>"
                            onerror="this.src='https://picsum.photos/seed/news<?= $article->id ?>/800/500'">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent">
                        </div>

                        <div class="absolute bottom-0 left-0 p-7">

                            <span class="inline-block bg-primary text-white text-xs px-3 py-1 rounded-full mb-3">
                                <?= htmlspecialchars($article->categoryName ?? 'Berita') ?>
                            </span>

                            <h3 class="text-2xl font-bold text-white group-hover:text-green-300 transition line-clamp-2">
                                <?= htmlspecialchars($article->title) ?>
                            </h3>

                            <p class="text-gray-200 text-sm mt-2 line-clamp-2">
                                <?= htmlspecialchars(strip_tags($article->excerpt ?? $article->content ?? '')) ?>
                            </p>

                            <p class="text-gray-300 text-xs mt-2">
                                <?php if (!empty($article->publishedAt)): ?>
                                    Published at
                                    <span class="underline">
                                        <?= date('d M Y', strtotime($article->publishedAt)) ?>
                                    </span>,
                                    <?= date('H:i', strtotime($article->publishedAt)) ?> WIB
                                <?php else: ?>
                                    <?= date('d M Y', strtotime($article->createdAt)) ?>
                                <?php endif; ?>
                            </p>

                        </div>

                    </div>

                </a>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full text-center py-16 text-gray-400">
            <iconify-icon icon="solar:document-text-linear" class="text-6xl mx-auto"></iconify-icon>
            <p class="mt-4 text-lg">Tidak ada artikel dari penulis ini</p>
            <a href="/kabar" class="text-primary hover:underline mt-2 inline-block">Kembali ke semua berita</a>
        </div>
    <?php endif; ?>

</div>

<!-- ==========================================================
BACK TO ALL NEWS
========================================================== -->

<div class="text-center mb-12">
    <a href="/kabar" 
       class="inline-flex items-center gap-2 text-primary hover:underline font-medium">
        <iconify-icon icon="solar:arrow-left-linear" width="18"></iconify-icon>
        Kembali ke semua berita
    </a>
</div>