<!-- ==========================================================
BREADCRUMB
========================================================== -->

<nav class="flex my-16" aria-label="Breadcrumb">
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
                <a href="/kabar"
                    class="ml-1 text-sm font-medium text-gray-500 hover:text-primary hover:underline md:ml-2">
                    Kabar Desa
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-400">/</span>
                <span class="ml-1 text-sm font-medium text-gray-800 md:ml-2 line-clamp-1 max-w-[200px]">
                    <?= htmlspecialchars($model['article']->title) ?>
                </span>
            </div>
        </li>
    </ol>
</nav>

<!-- ==========================================================
ARTICLE DETAIL
========================================================== -->

<article>
    <header class="mb-6 not-format">

        <!-- Author -->
        <address class="flex items-center mb-6 not-italic">
            <div class="inline-flex items-center mr-3 text-sm text-gray-900">

                <!-- Avatar dengan border gradient -->
                <div
                    class="w-16 h-16 rounded-full bg-gradient-to-tr from-primary to-indigo-400 p-[2px] flex-shrink-0 mr-4">
                    <?php if (!empty($model['article']->authorAvatar)): ?>
                        <img class="w-full h-full object-cover border-white border-2 rounded-full"
                            src="/uploads/avatar/<?= htmlspecialchars($model['article']->authorAvatar) ?>"
                            alt="<?= htmlspecialchars($model['article']->authorName ?? 'Admin') ?>"
                            onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($model['article']->authorName ?? 'Admin') ?>&size=64&background=15803d&color=fff'">
                    <?php else: ?>
                        <img class="w-full h-full object-cover border-white border-2 rounded-full"
                            src="https://ui-avatars.com/api/?name=<?= urlencode($model['article']->authorName ?? 'Admin') ?>&size=64&background=15803d&color=fff"
                            alt="<?= htmlspecialchars($model['article']->authorName ?? 'Admin') ?>">
                    <?php endif; ?>
                </div>

                <div>
                    <a href="#" rel="author"
                        class="text-xl font-bold text-gray-900 hover:text-primary transition-colors">
                        <?= htmlspecialchars($model['article']->authorName ?? 'Administrator') ?>
                    </a>

                    <p class="text-base text-gray-500">
                        <?= htmlspecialchars($model['article']->authorPosition ?? 'Pemerintah Desa Bungur') ?>
                    </p>

                    <p class="text-base text-gray-500">
                        <time pubdate
                            datetime="<?= date('Y-m-d H:i:s', strtotime($model['article']->publishedAt ?? $model['article']->createdAt)) ?>">
                            <?= date('d F Y', strtotime($model['article']->publishedAt ?? $model['article']->createdAt)) ?>,
                            <?= date('H:i', strtotime($model['article']->publishedAt ?? $model['article']->createdAt)) ?>
                            WIB
                        </time>
                    </p>
                </div>
            </div>
        </address>

        <span class="inline-block bg-primary text-white text-xs px-3 py-1 rounded-full mb-3">
            <?= htmlspecialchars($model['article']->categoryName ?? 'Berita') ?>
        </span>

        <!-- Judul -->
        <h1 class="mb-6 text-3xl font-extrabold leading-tight text-gray-900 lg:text-4xl">
            <?= htmlspecialchars($model['article']->title) ?>
        </h1>

        <!-- Thumbnail / Hero Image -->
        <figure class="mb-8">
            <img src="/uploads/articles/<?= htmlspecialchars($model['article']->image ?? 'default-news.jpg') ?>"
                class="w-full h-[420px] lg:h-[520px] object-cover rounded-3xl shadow-lg"
                alt="<?= htmlspecialchars($model['article']->imageAlt ?? $model['article']->title) ?>"
                onerror="this.src='https://picsum.photos/seed/article<?= $model['article']->id ?>/1200/500'">

            <figcaption class="mt-3 text-sm text-gray-500 text-center">
                <?= htmlspecialchars($model['article']->imageAlt ?? 'Dokumentasi Pemerintah Desa Bungur') ?>
            </figcaption>
        </figure>

    </header>

    <?php if (!empty($model['article']->excerpt)): ?>
        <p class="lead text-xl text-gray-700 font-medium italic border-l-4 border-primary pl-6 py-2 mb-8">
            <?= htmlspecialchars($model['article']->excerpt) ?>
        </p>
    <?php endif; ?>

    <div
        class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-600 prose-a:text-primary prose-strong:text-gray-800">
        <div
            class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-600 prose-a:text-primary prose-strong:text-gray-800">
            <div class="leading-relaxed">
                <?= htmlspecialchars_decode($model['article']->content) ?>
            </div>
        </div>
    </div>

    <!-- ==========================================================
SHARE ARTICLE
========================================================== -->
    <div class="mt-12 py-8 border-t border-b border-gray-200">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">

            <div>
                <p class="text-sm uppercase tracking-widest text-gray-500">
                    Bagikan Artikel
                </p>

                <h3 class="text-xl font-bold text-gray-900 mt-1">
                    Sebarkan informasi ini.
                </h3>
            </div>

            <div class="flex flex-wrap gap-3">

                <!-- Facebook -->
                <a id="share-facebook" target="_blank"
                    class="w-11 h-11 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:scale-110 transition duration-300">
                    <i class="bi bi-facebook text-xl"></i>
                </a>

                <!-- X -->
                <a id="share-twitter" target="_blank"
                    class="w-11 h-11 rounded-full bg-black text-white flex items-center justify-center hover:scale-110 transition duration-300">
                    <i class="bi bi-twitter-x text-xl"></i>
                </a>

                <!-- WhatsApp -->
                <a id="share-whatsapp" target="_blank"
                    class="w-11 h-11 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition duration-300">
                    <i class="bi bi-whatsapp text-xl"></i>
                </a>

                <!-- Telegram -->
                <a id="share-telegram" target="_blank"
                    class="w-11 h-11 rounded-full bg-[#229ED9] text-white flex items-center justify-center hover:scale-110 transition duration-300">
                    <i class="bi bi-telegram text-xl"></i>
                </a>

                <!-- Copy Link -->
                <button id="copy-link"
                    class="w-11 h-11 rounded-full bg-gray-700 text-white flex items-center justify-center hover:scale-110 transition duration-300">
                    <i class="bi bi-link-45deg text-xl"></i>
                </button>

            </div>

        </div>

    </div>

</article>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pageUrl = encodeURIComponent(window.location.href);
        const pageTitle = encodeURIComponent(document.title);

        // Set share links
        const fbBtn = document.getElementById('share-facebook');
        if (fbBtn) {
            fbBtn.href = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;
        }

        const twBtn = document.getElementById('share-twitter');
        if (twBtn) {
            twBtn.href = `https://twitter.com/intent/tweet?url=${pageUrl}&text=${pageTitle}`;
        }

        const waBtn = document.getElementById('share-whatsapp');
        if (waBtn) {
            waBtn.href = `https://wa.me/?text=${pageTitle}%20${pageUrl}`;
        }

        const tgBtn = document.getElementById('share-telegram');
        if (tgBtn) {
            tgBtn.href = `https://t.me/share/url?url=${pageUrl}&text=${pageTitle}`;
        }

        // Copy link
        const copyBtn = document.getElementById('copy-link');
        if (copyBtn) {
            copyBtn.addEventListener('click', async function () {
                try {
                    await navigator.clipboard.writeText(window.location.href);

                    // Tampilkan feedback
                    this.innerHTML = '<i class="bi bi-check-lg text-xl text-green-400"></i>';

                    setTimeout(() => {
                        this.innerHTML = '<i class="bi bi-link-45deg text-xl"></i>';
                    }, 2000);

                } catch (err) {
                    // Fallback untuk browser yang tidak support clipboard
                    fallbackCopyLink();
                }
            });
        }

        // Fallback copy untuk browser lama
        function fallbackCopyLink() {
            const textarea = document.createElement('textarea');
            textarea.value = window.location.href;
            document.body.appendChild(textarea);
            textarea.select();

            try {
                document.execCommand('copy');
                showToast('✅ Link berhasil disalin!');
            } catch (e) {
                alert('Gagal menyalin link. Silakan copy manual.');
            }

            document.body.removeChild(textarea);
        }

        // Toast notification
        function showToast(message) {
            const oldToast = document.querySelector('.share-toast');
            if (oldToast) oldToast.remove();

            const toast = document.createElement('div');
            toast.className = 'share-toast fixed bottom-6 left-1/2 -translate-x-1/2 z-[99999] px-6 py-3 rounded-2xl shadow-2xl bg-gray-900 text-white text-sm font-medium transition-all duration-300';
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, 10px)';
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }
    });
</script>

<!-- ==========================================================
RELATED ARTICLES
========================================================== -->

<aside aria-label="Related articles" class="py-12 lg:py-24">

    <h2 class="mb-8 text-2xl font-bold text-gray-900">
        Artikel Terkait
    </h2>

    <?php if (!empty($model['relatedArticles'])): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

            <?php foreach ($model['relatedArticles'] as $article): ?>
                <article class="group">

                    <a href="/news/detail/<?= htmlspecialchars($article->slug) ?>" class="block overflow-hidden rounded-2xl">
                        <img src="/uploads/articles/<?= htmlspecialchars($article->image ?? 'default-news.jpg') ?>"
                            class="w-full aspect-[16/10] object-cover transition duration-500 group-hover:scale-105"
                            alt="<?= htmlspecialchars($article->imageAlt ?? $article->title) ?>"
                            onerror="this.src='https://picsum.photos/seed/related<?= $article->id ?>/400/250'">
                    </a>

                    <h3 class="mt-5 mb-2 text-lg lg:text-xl font-bold leading-tight text-gray-900">
                        <a href="/news/detail/<?= htmlspecialchars($article->slug) ?>" class="hover:text-primary transition">
                            <?= htmlspecialchars($article->title) ?>
                        </a>
                    </h3>

                    <p class="text-sm text-gray-500 line-clamp-2">
                        <?= htmlspecialchars(strip_tags($article->excerpt ?? $article->content ?? '')) ?>
                    </p>

                    <div class="mt-4 text-sm font-medium text-primary">
                        <?php if (!empty($article->publishedAt)): ?>
                            <?= date('d M Y', strtotime($article->publishedAt)) ?>
                        <?php else: ?>
                            <?= date('d M Y', strtotime($article->createdAt)) ?>
                        <?php endif; ?>
                    </div>

                </article>
            <?php endforeach; ?>

        </div>
    <?php else: ?>
        <div class="text-center text-gray-400 py-12">
            <iconify-icon icon="solar:document-text-linear" class="text-5xl mx-auto"></iconify-icon>
            <p class="mt-3">Belum ada artikel terkait</p>
        </div>
    <?php endif; ?>

</aside>

<!-- ==========================================================
ARTICLE ARCHIVES
========================================================== -->

<section class="py-12 lg:py-16">

    <div class="max-w-xl">

        <h2 class="mb-8 text-2xl font-bold text-gray-900">
            Arsip Artikel
        </h2>

        <?php if (!empty($model['archives'])): ?>
            <div class="divide-y divide-gray-200">

                <?php foreach ($model['archives'] as $archive): ?>
                    <!-- Archive links -->
                    <a href="/kabar/arsip?month=<?= $archive['month'] ?>&year=<?= $archive['year'] ?>"
                        class="group flex items-center gap-3 py-6 text-xl text-cyan-600 hover:text-primary transition">

                        <span class="text-gray-400 group-hover:text-primary transition">
                            ›
                        </span>

                        <?= htmlspecialchars($archive['month_name']) ?>         <?= $archive['year'] ?>

                        <span class="text-sm text-gray-400 ml-auto">
                            (<?= $archive['count'] ?>)
                        </span>

                    </a>
                <?php endforeach; ?>

            </div>
        <?php else: ?>
            <div class="text-center text-gray-400 py-8">
                <iconify-icon icon="solar:archive-linear" class="text-5xl mx-auto"></iconify-icon>
                <p class="mt-3">Belum ada arsip artikel</p>
            </div>
        <?php endif; ?>

    </div>

</section>