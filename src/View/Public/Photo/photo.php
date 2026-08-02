<style>
    /* ==========================================================
   PINTEREST GALLERY
========================================================== */

    .gallery {
        column-count: 5;
        column-gap: 1.5rem;
    }

    .gallery-item {
        break-inside: avoid;
        margin-bottom: 1.5rem;
    }

    .gallery-item img {
        width: 100%;
        display: block;
        border-radius: 1.75rem;
        transition: transform .45s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }


    /* ==========================================================
   PHOTOSWIPE SIDEBAR
========================================================== */

    .pswp__custom-sidebar {

        position: absolute;

        top: 0;
        right: 0;

        width: 380px;
        height: 100%;

        display: flex;
        flex-direction: column;

        background: rgba(255, 255, 255, .97);
        backdrop-filter: blur(20px);

        padding: 36px;

        overflow-y: auto;

        border-left: 1px solid rgba(0, 0, 0, .08);

        z-index: 1000;

        transition: .35s ease;

    }

    .pswp__custom-sidebar.hide {

        transform: translateX(100%);

    }


    /* ==========================================================
   CAPTION
========================================================== */

    #psCaption {

        color: #64748b;

        line-height: 1.9;

        font-size: 15px;

    }

    /* ==========================================================
   AUTHOR AVATAR
========================================================== */

    .pswp__author-avatar {
        margin-bottom: 20px;
    }

    .pswp__author-avatar img {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #16a34a;
    }


    /* ==========================================================
   META
========================================================== */

    .pswp__meta {

        margin-top: 32px;

        display: flex;
        flex-direction: column;

        gap: 18px;

        flex: 1;

    }

    .pswp__meta div {

        display: flex;
        align-items: flex-start;
        gap: 12px;

        color: #111827;

        font-size: 15px;

    }

    .pswp__meta i {

        color: #16a34a;

        font-size: 18px;

        margin-top: 2px;

    }


    /* ==========================================================
   BUTTON HIDE
========================================================== */

    .pswp__hide-sidebar {

        margin-top: auto;

        width: 100%;

        height: 52px;

        border-radius: 14px;

        background: #16a34a;

        color: #fff;

        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;

        cursor: pointer;

        transition: .25s;

    }

    .pswp__hide-sidebar:hover {

        background: #15803d;

    }


    /* ==========================================================
   BUTTON SHOW
========================================================== */
    .pswp__show-sidebar {

        position: absolute;

        right: 20px;

        top: 72%;

        transform: translateY(-50%);

        width: 54px;
        height: 54px;

        border-radius: 999px;

        background: rgba(0, 0, 0, .75);

        color: #fff;

        display: none;

        justify-content: center;
        align-items: center;

        z-index: 1500;

        cursor: pointer;

    }

    .pswp__show-sidebar.show {

        display: flex;

    }

    .pswp__show-sidebar.show {

        display: flex;

    }

    .pswp__show-sidebar:hover {

        background: #16a34a;

    }


    /* ==========================================================
   PHOTOSWIPE
========================================================== */

    .pswp__scroll-wrap {

        background: #111;

    }


    /* ==========================================================
   RESPONSIVE
========================================================== */

    @media (max-width:1280px) {

        .gallery {
            column-count: 4;
        }

    }

    @media (max-width:992px) {

        .gallery {
            column-count: 3;
        }

    }

    @media (max-width:768px) {

        .gallery {
            column-count: 2;
        }

        .pswp__custom-sidebar {

            width: 100%;
            height: 340px;

            left: 0;
            right: 0;
            bottom: 0;
            top: auto;

            padding: 24px;
            padding-bottom: 32px;

            overflow-y: auto;
        }

        .pswp__meta {

            margin-top: 20px;
            gap: 14px;

        }

        .pswp__hide-sidebar {

            margin-top: 20px;
            min-height: 52px;
            flex-shrink: 0;

        }

        .pswp__show-sidebar {

            position: absolute;

            right: 16px;
            bottom: 355px;

            top: auto;

            z-index: 9999;

        }

    }

    @media (max-width:640px) {

        .gallery {

            column-count: 2;
            column-gap: 1rem;

        }

        .gallery-item {

            margin-bottom: 1rem;

        }

    }
</style>

<!-- ==========================================================
    HERO GALERI
========================================================== -->

<section class="py-16">

    <div class="max-w-4xl">

        <span class="uppercase tracking-[0.25em] text-primary font-semibold text-sm">
            Galeri Foto
        </span>

        <h1 class="text-5xl lg:text-6xl font-bold mt-4 leading-tight">

            Momen Terbaik
            <span class="text-primary">
                Desa Bungur
            </span>

        </h1>

</section>

<!-- ==========================================================
    PINTEREST GALLERY
========================================================== -->

<section class="pb-24">

    <div id="gallery" class="gallery">

        <?php if (!empty($model['photos'])): ?>
            <?php foreach ($model['photos'] as $photo): ?>
                <a href="/uploads/photos/<?= htmlspecialchars($photo->image ?? 'default-photo.jpg') ?>" data-pswp-width="1200"
                    data-pswp-height="800" data-caption="<?= htmlspecialchars($photo->caption ?? '') ?>"
                    data-author="<?= htmlspecialchars($photo->userName ?? 'Admin') ?>"
                    data-avatar="<?= htmlspecialchars($photo->userAvatar ?? '') ?>"
                    data-date="<?= $photo->createdAt ? date('d M Y • H.i', strtotime($photo->createdAt)) . ' WIB' : '' ?>"
                    data-location="<?= htmlspecialchars($photo->location ?? '') ?>" class="gallery-item group block">

                    <div class="relative overflow-hidden rounded-[28px]">

                        <img src="/uploads/photos/<?= htmlspecialchars($photo->image ?? 'default-photo.jpg') ?>" loading="lazy"
                            alt="<?= htmlspecialchars($photo->caption ?? 'Foto Desa') ?>"
                            onerror="this.src='https://picsum.photos/seed/photo<?= $photo->id ?>/700/500'">

                        <div
                            class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">

                            <div class="text-white">

                                <h3 class="font-bold text-lg">
                                    <?= htmlspecialchars($photo->caption ?: 'Foto Desa') ?>
                                </h3>

                                <p class="text-sm text-white/90">
                                    Oleh <?= htmlspecialchars($photo->userName ?? 'Admin') ?>
                                </p>

                            </div>

                        </div>

                    </div>

                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-16 text-gray-400" style="column-span: all;">
                <iconify-icon icon="solar:gallery-circle-linear" class="text-6xl mx-auto"></iconify-icon>
                <p class="mt-4">Belum ada foto di galeri</p>
            </div>
        <?php endif; ?>

    </div>

    <!-- LOAD MORE -->
    <?php if (!empty($model['photos']) && count($model['photos']) > 15): ?>
        <div class="mt-20 text-center">
            <p class="text-gray-600 mb-6">
                Ingin melihat lebih banyak momen desa?
            </p>
            <a href="#"
                class="inline-flex items-center gap-3 px-8 py-4 rounded-full border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-white transition duration-300">
                Muat lainnya?
            </a>
        </div>
    <?php endif; ?>

</section>

<script type="module">
    import PhotoSwipeLightbox from 'https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe-lightbox.esm.min.js';

    const lightbox = new PhotoSwipeLightbox({
        gallery: '#gallery',
        children: 'a',
        pswpModule: () => import('https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.esm.min.js')
    });

    lightbox.on('uiRegister', () => {

        lightbox.pswp.ui.registerElement({

            name: 'sidebar',

            order: 9,

            appendTo: 'root',

            isButton: false,

            html: `

        <div class="pswp__show-sidebar">

            <i class="bi bi-info-circle"></i>

        </div>

        <div class="pswp__custom-sidebar">

            <!-- Avatar -->
            <div class="pswp__author-avatar">
                <img id="psAvatar" src="" alt="Author" class="w-12 h-12 rounded-full object-cover border-2 border-primary">
            </div>
            <p>Caption: </p>
            <p id="psCaption"></p>

            <div class="pswp__meta">

                <div>

                    <i class="bi bi-geo-alt"></i>

                    <span id="psLocation"></span>

                </div>

                <div>

                    <i class="bi bi-calendar-event"></i>

                    <span id="psDate"></span>

                </div>

                <div>

                    <span id="psAuthor"></span>

                </div>

            </div>

             <div class="pswp__hide-sidebar">

                <i class="bi bi-chevron-right"></i>

            </div>

        </div>

        `

        });

    });

    lightbox.on("change", () => {

        const slide = lightbox.pswp.currSlide;

        if (!slide) return;

        const el = slide.data.element;

        // Ambil data dari dataset
        const caption = el.dataset.caption || 'Tidak ada caption';
        const author = el.dataset.author || 'Admin';
        const date = el.dataset.date || '';
        const location = el.dataset.location || '';
        const avatar = el.dataset.avatar || '';

        // Set ke element
        document.getElementById("psCaption").textContent = caption;
        document.getElementById("psAuthor").textContent = author;
        document.getElementById("psDate").textContent = date;
        document.getElementById("psLocation").textContent = location;

        // Set avatar - PERBAIKI INI
        // Set avatar - dengan debug
        const avatarImg = document.getElementById("psAvatar");
        console.log('Avatar value:', avatar); // <-- Cek di console browser
        console.log('Author value:', author);
        if (avatar) {
            avatarImg.src = '/uploads/avatar/' + avatar;
            avatarImg.style.display = 'block';
        } else {
            // Fallback ke UI Avatars
            avatarImg.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(author) + '&size=56&background=15803d&color=fff';
            avatarImg.style.display = 'block';
        }

    });

    lightbox.on("afterInit", () => {

        const sidebar = document.querySelector(".pswp__custom-sidebar");
        const hideBtn = document.querySelector(".pswp__hide-sidebar");
        const showBtn = document.querySelector(".pswp__show-sidebar");

        if (!sidebar) return;

        hideBtn.addEventListener("click", () => {

            sidebar.classList.add("hide");
            showBtn.classList.add("show");

        });

        showBtn.addEventListener("click", () => {

            sidebar.classList.remove("hide");
            showBtn.classList.remove("show");

        });

    });

    lightbox.init();
</script>