<?php include '../Layouts/header.php' ?>

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

        <!-- FOTO 1 : PORTRAIT -->
        <a href="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="2400"
            data-caption="Tradisi Sedekah Bumi menjadi bentuk rasa syukur masyarakat Desa Bungur atas hasil panen. Acara ini diikuti seluruh warga dengan doa bersama, kirab budaya, dan makan bersama sebagai simbol kebersamaan."
            data-author="Ahmad Fauzi" data-date="26 Juli 2026 • 08.15 WIB" data-location="Lapangan Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">

                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">

                    <div class="text-white">

                        <h3 class="font-bold text-lg">
                            Festival Sedekah Bumi
                        </h3>

                        <p class="text-sm text-white/90">
                            Oleh Ahmad Fauzi
                        </p>

                    </div>

                </div>

            </div>

        </a>

        <!-- FOTO 2 : LANDSCAPE -->
        <a href="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="1067"
            data-caption="Musyawarah Desa membahas rencana pembangunan tahun 2027 yang dihadiri Pemerintah Desa, BPD, tokoh masyarakat serta perwakilan warga dari seluruh dusun."
            data-author="KKN-27 UNIROW" data-date="22 Juli 2026 • 19.30 WIB" data-location="Balai Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">

                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">

                    <div class="text-white">

                        <h3 class="font-bold">
                            Musyawarah Desa
                        </h3>

                        <p class="text-sm">
                            Oleh KKN UNIROW
                        </p>

                    </div>

                </div>

            </div>

        </a>



        <!-- FOTO 3 : LANDSCAPE -->
        <a href="https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="1067"
            data-caption="Suasana panen raya padi di area persawahan Desa Bungur. Hasil panen tahun ini meningkat berkat kerja sama petani dan kondisi cuaca yang mendukung."
            data-author="Danish" data-date="18 Juli 2026 • 06.45 WIB" data-location="Persawahan Dusun Krajan"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">

                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">

                    <div class="text-white">

                        <h3 class="font-bold">
                            Panen Raya
                        </h3>

                        <p class="text-sm">
                            Oleh Danish
                        </p>

                    </div>

                </div>

            </div>

        </a>



        <!-- FOTO 4 : PORTRAIT -->
        <a href="https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="2400"
            data-caption="Warga bersama Karang Taruna melaksanakan kerja bakti membersihkan saluran air, jalan desa, serta lingkungan sekitar untuk menjaga kebersihan dan mencegah banjir."
            data-author="Karang Taruna Desa Bungur" data-date="13 Juli 2026 • 07.20 WIB" data-location="Dusun Krajan"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">

                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">

                    <div class="text-white">

                        <h3 class="font-bold">
                            Kerja Bakti
                        </h3>

                        <p class="text-sm">
                            Oleh Karang Taruna
                        </p>

                    </div>

                </div>

            </div>

        </a>



        <!-- FOTO 5 : PORTRAIT -->
        <a href="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="2400"
            data-caption="Hamparan persawahan hijau menjadi salah satu potensi utama Desa Bungur. Sektor pertanian masih menjadi mata pencaharian terbesar masyarakat."
            data-author="Admin Website Desa" data-date="10 Juli 2026 • 17.42 WIB" data-location="Persawahan Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">

                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">

                    <div class="text-white">

                        <h3 class="font-bold">
                            Sawah Desa Bungur
                        </h3>

                        <p class="text-sm">
                            Oleh Admin Website
                        </p>

                    </div>

                </div>

            </div>

        </a>

        <!-- FOTO 6 -->
        <a href="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="1067"
            data-caption="Kegiatan gotong royong warga membersihkan lingkungan desa sebagai upaya menjaga kebersihan dan mempererat kebersamaan antar masyarakat."
            data-author="Admin Website Desa" data-date="08 Juli 2026 • 07.10 WIB" data-location="Dusun Krajan"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Gotong Royong</h3>
                        <p class="text-sm">Oleh Admin Website</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- FOTO 7 -->
        <a href="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="2400"
            data-caption="Suasana pagi di area persawahan Desa Bungur yang menjadi sumber mata pencaharian utama masyarakat."
            data-author="Danish" data-date="06 Juli 2026 • 06.05 WIB" data-location="Persawahan Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Persawahan Hijau</h3>
                        <p class="text-sm">Oleh Danish</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- FOTO 8 -->
        <a href="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="1067"
            data-caption="Rapat koordinasi Pemerintah Desa bersama perangkat desa dalam rangka persiapan program pembangunan."
            data-author="Sekretariat Desa" data-date="04 Juli 2026 • 09.20 WIB" data-location="Balai Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Rapat Koordinasi</h3>
                        <p class="text-sm">Oleh Sekretariat Desa</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- FOTO 9 -->
        <a href="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="2400"
            data-caption="Panorama sore hari di sekitar area persawahan Desa Bungur dengan pemandangan langit yang indah."
            data-author="Admin Website" data-date="02 Juli 2026 • 17.40 WIB" data-location="Dusun Selatan"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Senja Desa</h3>
                        <p class="text-sm">Oleh Admin Website</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- FOTO 10 -->
        <a href="https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="1067"
            data-caption="Pelatihan digitalisasi UMKM yang diikuti pelaku usaha lokal untuk meningkatkan pemasaran produk."
            data-author="KKN UNIROW" data-date="30 Juni 2026 • 10.00 WIB" data-location="Balai Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Pelatihan UMKM</h3>
                        <p class="text-sm">Oleh KKN UNIROW</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- FOTO 11 -->
        <a href="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="2400"
            data-caption="Suasana pagi yang tenang dengan udara segar di sekitar lingkungan Desa Bungur."
            data-author="Ahmad Fauzi" data-date="28 Juni 2026 • 06.30 WIB" data-location="Jalan Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Pagi Hari</h3>
                        <p class="text-sm">Oleh Ahmad Fauzi</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- FOTO 12 -->
        <a href="https://images.unsplash.com/photo-1497366811353-6870744d04b2?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="1067"
            data-caption="Pelayanan administrasi desa kepada masyarakat berlangsung dengan tertib dan cepat."
            data-author="Operator Desa" data-date="25 Juni 2026 • 09.45 WIB" data-location="Kantor Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Pelayanan Desa</h3>
                        <p class="text-sm">Oleh Operator Desa</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- FOTO 13 -->
        <a href="https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="2400"
            data-caption="Keindahan alam Desa Bungur saat musim penghujan menghadirkan suasana yang sejuk dan asri."
            data-author="Admin Website" data-date="23 Juni 2026 • 16.20 WIB" data-location="Area Perbukitan"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Alam Desa</h3>
                        <p class="text-sm">Oleh Admin Website</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- FOTO 14 -->
        <a href="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="1067"
            data-caption="Kegiatan pelatihan bagi pemuda desa untuk meningkatkan keterampilan dan jiwa kewirausahaan."
            data-author="Karang Taruna" data-date="20 Juni 2026 • 14.00 WIB" data-location="Balai Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Pelatihan Pemuda</h3>
                        <p class="text-sm">Oleh Karang Taruna</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- FOTO 15 -->
        <a href="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?q=80&w=1600&auto=format&fit=crop"
            data-pswp-width="1600" data-pswp-height="2400"
            data-caption="Hamparan hijau dan suasana pedesaan yang menjadi daya tarik Desa Bungur bagi para pengunjung."
            data-author="Danish" data-date="18 Juni 2026 • 16.55 WIB" data-location="Desa Bungur"
            class="gallery-item group block">

            <div class="relative overflow-hidden rounded-[28px]">
                <img src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?q=80&w=700&auto=format&fit=crop"
                    loading="lazy">
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition duration-300 flex items-end p-6 opacity-0 group-hover:opacity-100">
                    <div class="text-white">
                        <h3 class="font-bold">Pemandangan Desa</h3>
                        <p class="text-sm">Oleh Danish</p>
                    </div>
                </div>
            </div>
        </a>

    </div>

    <!-- LOAD MORE -->

    <div class="mt-20 text-center">

        <p class="text-gray-600 mb-6">
            Ingin melihat sejarah lengkap desa bungur?
        </p>

        <a href="#"
            class="inline-flex items-center gap-3 px-8 py-4 rounded-full border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-white transition duration-300">

          Muat lainnya?

        </a>

    </div>

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

                        <i class="bi bi-person-circle"></i>

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

        document.getElementById("psCaption").textContent = el.dataset.caption;
        document.getElementById("psAuthor").textContent = el.dataset.author;
        document.getElementById("psDate").textContent = el.dataset.date;
        document.getElementById("psLocation").textContent = el.dataset.location;

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

<?php include '../Layouts/footer.php' ?>