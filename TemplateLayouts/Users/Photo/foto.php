<?php include '../Layouts/header.php' ?>

<!-- ==========================================================
HEADER DASHBOARD
========================================================== -->
<div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between mb-10">

    <div>

        <span class="text-sm tracking-[0.25em] uppercase text-primary font-semibold">
            Dashboard
        </span>

        <h1 class="text-4xl font-bold mt-2">
            Galeri Foto
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola dan lihat momen terbaik Desa Bungur dalam galeri foto.
        </p>

    </div>

    <div class="flex flex-col sm:flex-row gap-3">

        <!-- Search -->
        <div class="relative">

            <iconify-icon icon="solar:magnifer-linear"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl">
            </iconify-icon>

            <input id="searchInput" type="text" placeholder="Cari foto..."
                class="pl-12 pr-4 h-12 w-full sm:w-80 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">

        </div>

        <!-- Add -->
        <button id="addPhotoBtn"
            class="h-12 px-6 rounded-2xl bg-primary text-white font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition">

            Tambah

        </button>

    </div>

</div>

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
        position: relative;
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

    /* Admin overlay pada gallery item */
    .gallery-item .admin-overlay {
        position: absolute;
        top: 12px;
        right: 12px;
        display: flex;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 10;
    }

    .gallery-item:hover .admin-overlay {
        opacity: 1;
    }

    .gallery-item .admin-overlay button {
        width: 36px;
        height: 36px;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.3s ease;
        font-size: 16px;
    }

    .gallery-item .admin-overlay button:hover {
        background: #16a34a;
    }

    .gallery-item .admin-overlay button.delete:hover {
        background: #dc2626;
    }

    /* Hover overlay info */
    .gallery-item .hover-info {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0);
        transition: background 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 24px;
        opacity: 0;
        transition: all 0.3s ease;
        border-radius: 1.75rem;
    }

    .gallery-item:hover .hover-info {
        background: rgba(0, 0, 0, 0.45);
        opacity: 1;
    }

    .gallery-item .hover-info .text-white {
        color: white;
    }

    .gallery-item .hover-info h3 {
        font-weight: 700;
        font-size: 1.125rem;
    }

    .gallery-item .hover-info p {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.9);
    }


    /* ==========================================================
   RESPONSIVE GALLERY
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


    /* ==========================================================
   MODAL EDIT
========================================================== */

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 32px;
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        padding: 40px;
        animation: slideUp 0.3s ease;
        position: relative;
    }

    .modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 40px;
        height: 40px;
        border-radius: 999px;
        border: none;
        background: #f3f4f6;
        color: #1f2937;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s ease;
    }

    .modal-close:hover {
        background: #e5e7eb;
    }

    .modal-content label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .modal-content input,
    .modal-content textarea,
    .modal-content select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        outline: none;
        font-family: inherit;
    }

    .modal-content input:focus,
    .modal-content textarea:focus,
    .modal-content select:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
    }

    .modal-content textarea {
        resize: vertical;
        min-height: 80px;
    }

    .modal-content .form-group {
        margin-bottom: 20px;
    }

    .modal-content .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .modal-content .btn-submit {
        width: 100%;
        padding: 14px;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        margin-top: 8px;
    }

    .modal-content .btn-submit:hover {
        background: #15803d;
    }

    .modal-content .btn-submit.delete-btn {
        background: #dc2626;
    }

    .modal-content .btn-submit.delete-btn:hover {
        background: #b91c1c;
    }

    .modal-content .btn-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 8px;
    }

    .modal-content .btn-group .btn-submit {
        margin-top: 0;
    }

    .modal-content .btn-group .btn-submit.cancel-btn {
        background: #9ca3af;
    }

    .modal-content .btn-group .btn-submit.cancel-btn:hover {
        background: #6b7280;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 640px) {
        .modal-content {
            padding: 24px;
        }

        .modal-content .form-row {
            grid-template-columns: 1fr;
        }

        .modal-content .btn-group {
            grid-template-columns: 1fr;
        }
    }
</style>


<!-- ==========================================================
PINTEREST GALLERY
========================================================== -->

<section class="pb-24">

    <div id="gallery" class="gallery">

        <!-- FOTO 1 : PORTRAIT -->
        <div class="gallery-item group" data-id="1"
            data-image="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=700&auto=format&fit=crop"
            data-caption="Tradisi Sedekah Bumi menjadi bentuk rasa syukur masyarakat Desa Bungur atas hasil panen. Acara ini diikuti seluruh warga dengan doa bersama, kirab budaya, dan makan bersama sebagai simbol kebersamaan."
            data-author="Ahmad Fauzi" data-date="26 Juli 2026 • 08.15 WIB" data-location="Lapangan Desa Bungur"
            data-title="Festival Sedekah Bumi">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Festival Sedekah Bumi">

                <!-- Admin Overlay -->
                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <!-- Hover Info -->
                <div class="hover-info">
                    <div class="text-white">
                        <h3>Festival Sedekah Bumi</h3>
                        <p>Oleh Ahmad Fauzi</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 2 : LANDSCAPE -->
        <div class="gallery-item group" data-id="2"
            data-image="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=700&auto=format&fit=crop"
            data-caption="Musyawarah Desa membahas rencana pembangunan tahun 2027 yang dihadiri Pemerintah Desa, BPD, tokoh masyarakat serta perwakilan warga dari seluruh dusun."
            data-author="KKN-27 UNIROW" data-date="22 Juli 2026 • 19.30 WIB" data-location="Balai Desa Bungur"
            data-title="Musyawarah Desa">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Musyawarah Desa">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Musyawarah Desa</h3>
                        <p>Oleh KKN-27 UNIROW</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 3 : LANDSCAPE -->
        <div class="gallery-item group" data-id="3"
            data-image="https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=700&auto=format&fit=crop"
            data-caption="Suasana panen raya padi di area persawahan Desa Bungur. Hasil panen tahun ini meningkat berkat kerja sama petani dan kondisi cuaca yang mendukung."
            data-author="Danish" data-date="18 Juli 2026 • 06.45 WIB" data-location="Persawahan Dusun Krajan"
            data-title="Panen Raya">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Panen Raya">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Panen Raya</h3>
                        <p>Oleh Danish</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 4 : PORTRAIT -->
        <div class="gallery-item group" data-id="4"
            data-image="https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=700&auto=format&fit=crop"
            data-caption="Warga bersama Karang Taruna melaksanakan kerja bakti membersihkan saluran air, jalan desa, serta lingkungan sekitar untuk menjaga kebersihan dan mencegah banjir."
            data-author="Karang Taruna Desa Bungur" data-date="13 Juli 2026 • 07.20 WIB" data-location="Dusun Krajan"
            data-title="Kerja Bakti">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Kerja Bakti">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Kerja Bakti</h3>
                        <p>Oleh Karang Taruna</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 5 : PORTRAIT -->
        <div class="gallery-item group" data-id="5"
            data-image="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=700&auto=format&fit=crop"
            data-caption="Hamparan persawahan hijau menjadi salah satu potensi utama Desa Bungur. Sektor pertanian masih menjadi mata pencaharian terbesar masyarakat."
            data-author="Admin Website Desa" data-date="10 Juli 2026 • 17.42 WIB" data-location="Persawahan Desa Bungur"
            data-title="Sawah Desa Bungur">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Sawah Desa Bungur">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Sawah Desa Bungur</h3>
                        <p>Oleh Admin Website</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 6 -->
        <div class="gallery-item group" data-id="6"
            data-image="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=700&auto=format&fit=crop"
            data-caption="Kegiatan gotong royong warga membersihkan lingkungan desa sebagai upaya menjaga kebersihan dan mempererat kebersamaan antar masyarakat."
            data-author="Admin Website Desa" data-date="08 Juli 2026 • 07.10 WIB" data-location="Dusun Krajan"
            data-title="Gotong Royong">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Gotong Royong">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Gotong Royong</h3>
                        <p>Oleh Admin Website</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 7 -->
        <div class="gallery-item group" data-id="7"
            data-image="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=700&auto=format&fit=crop"
            data-caption="Suasana pagi di area persawahan Desa Bungur yang menjadi sumber mata pencaharian utama masyarakat."
            data-author="Danish" data-date="06 Juli 2026 • 06.05 WIB" data-location="Persawahan Desa Bungur"
            data-title="Persawahan Hijau">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Persawahan Hijau">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Persawahan Hijau</h3>
                        <p>Oleh Danish</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 8 -->
        <div class="gallery-item group" data-id="8"
            data-image="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=700&auto=format&fit=crop"
            data-caption="Rapat koordinasi Pemerintah Desa bersama perangkat desa dalam rangka persiapan program pembangunan."
            data-author="Sekretariat Desa" data-date="04 Juli 2026 • 09.20 WIB" data-location="Balai Desa Bungur"
            data-title="Rapat Koordinasi">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Rapat Koordinasi">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Rapat Koordinasi</h3>
                        <p>Oleh Sekretariat Desa</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 9 -->
        <div class="gallery-item group" data-id="9"
            data-image="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=700&auto=format&fit=crop"
            data-caption="Panorama sore hari di sekitar area persawahan Desa Bungur dengan pemandangan langit yang indah."
            data-author="Admin Website" data-date="02 Juli 2026 • 17.40 WIB" data-location="Dusun Selatan"
            data-title="Senja Desa">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Senja Desa">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Senja Desa</h3>
                        <p>Oleh Admin Website</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 10 -->
        <div class="gallery-item group" data-id="10"
            data-image="https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=700&auto=format&fit=crop"
            data-caption="Pelatihan digitalisasi UMKM yang diikuti pelaku usaha lokal untuk meningkatkan pemasaran produk."
            data-author="KKN UNIROW" data-date="30 Juni 2026 • 10.00 WIB" data-location="Balai Desa Bungur"
            data-title="Pelatihan UMKM">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Pelatihan UMKM">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Pelatihan UMKM</h3>
                        <p>Oleh KKN UNIROW</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 11 -->
        <div class="gallery-item group" data-id="11"
            data-image="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=700&auto=format&fit=crop"
            data-caption="Suasana pagi yang tenang dengan udara segar di sekitar lingkungan Desa Bungur."
            data-author="Ahmad Fauzi" data-date="28 Juni 2026 • 06.30 WIB" data-location="Jalan Desa Bungur"
            data-title="Pagi Hari">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Pagi Hari">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Pagi Hari</h3>
                        <p>Oleh Ahmad Fauzi</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 12 -->
        <div class="gallery-item group" data-id="12"
            data-image="https://images.unsplash.com/photo-1497366811353-6870744d04b2?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1497366811353-6870744d04b2?q=80&w=700&auto=format&fit=crop"
            data-caption="Pelayanan administrasi desa kepada masyarakat berlangsung dengan tertib dan cepat."
            data-author="Operator Desa" data-date="25 Juni 2026 • 09.45 WIB" data-location="Kantor Desa Bungur"
            data-title="Pelayanan Desa">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Pelayanan Desa">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Pelayanan Desa</h3>
                        <p>Oleh Operator Desa</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 13 -->
        <div class="gallery-item group" data-id="13"
            data-image="https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=700&auto=format&fit=crop"
            data-caption="Keindahan alam Desa Bungur saat musim penghujan menghadirkan suasana yang sejuk dan asri."
            data-author="Admin Website" data-date="23 Juni 2026 • 16.20 WIB" data-location="Area Perbukitan"
            data-title="Alam Desa">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Alam Desa">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Alam Desa</h3>
                        <p>Oleh Admin Website</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 14 -->
        <div class="gallery-item group" data-id="14"
            data-image="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=700&auto=format&fit=crop"
            data-caption="Kegiatan pelatihan bagi pemuda desa untuk meningkatkan keterampilan dan jiwa kewirausahaan."
            data-author="Karang Taruna" data-date="20 Juni 2026 • 14.00 WIB" data-location="Balai Desa Bungur"
            data-title="Pelatihan Pemuda">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Pelatihan Pemuda">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Pelatihan Pemuda</h3>
                        <p>Oleh Karang Taruna</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOTO 15 -->
        <div class="gallery-item group" data-id="15"
            data-image="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?q=80&w=1600&auto=format&fit=crop"
            data-thumb="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?q=80&w=700&auto=format&fit=crop"
            data-caption="Hamparan hijau dan suasana pedesaan yang menjadi daya tarik Desa Bungur bagi para pengunjung."
            data-author="Danish" data-date="18 Juni 2026 • 16.55 WIB" data-location="Desa Bungur"
            data-title="Pemandangan Desa">

            <div class="relative overflow-hidden rounded-[28px]">

                <img src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?q=80&w=700&auto=format&fit=crop"
                    loading="lazy" alt="Pemandangan Desa">

                <div class="admin-overlay">
                    <button class="edit-btn" title="Edit Foto">
                        <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                    </button>
                    <button class="delete-btn" title="Hapus Foto">
                        <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    </button>
                </div>

                <div class="hover-info">
                    <div class="text-white">
                        <h3>Pemandangan Desa</h3>
                        <p>Oleh Danish</p>
                    </div>
                </div>

            </div>

        </div>

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

<!-- ==========================================================
MODAL EDIT / TAMBAH FOTO
========================================================== -->

<div id="photoModal" class="modal-overlay">

    <div class="modal-content">

        <button class="modal-close" id="closeModal">
            <iconify-icon icon="solar:close-circle-linear"></iconify-icon>
        </button>

        <h2 id="modalTitle" class="text-2xl font-bold mb-6">
            Tambah Foto Baru
        </h2>

        <form id="photoForm">

            <input type="hidden" id="photoId" value="">

            <div class="form-group">
                <label>Judul Foto</label>
                <input type="text" id="photoTitle" placeholder="Masukkan judul foto..." required>
            </div>

            <div class="form-group">
                <label>Caption / Deskripsi</label>
                <textarea id="photoCaption" placeholder="Tulis deskripsi foto..." rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Nama Fotografer / Author</label>
                <input type="text" id="photoAuthor" placeholder="Nama fotografer...">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" id="photoDate" placeholder="26 Juli 2026 • 08.15 WIB">
                </div>
                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" id="photoLocation" placeholder="Lokasi foto...">
                </div>
            </div>

            <div class="form-group">
                <label>URL Gambar</label>
                <input type="url" id="photoImage" placeholder="https://images.unsplash.com/...">
            </div>

            <div class="btn-group">
                <button type="button" class="btn-submit cancel-btn" id="cancelModalBtn">
                    Batal
                </button>
                <button type="submit" class="btn-submit" id="savePhotoBtn">
                    <iconify-icon icon="solar:check-circle-linear"></iconify-icon>
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

<!-- ==========================================================
MODAL KONFIRMASI HAPUS
========================================================== -->

<div id="deleteModal" class="modal-overlay">

    <div class="modal-content" style="max-width: 420px;">

        <button class="modal-close" id="closeDeleteModal">
            <iconify-icon icon="solar:close-circle-linear"></iconify-icon>
        </button>

        <div class="text-center">

            <iconify-icon icon="solar:trash-bin-trash-linear"
                style="font-size: 48px; color: #dc2626; margin-bottom: 16px;"></iconify-icon>

            <h3 class="text-2xl font-bold mb-3">
                Hapus Foto?
            </h3>

            <p class="text-gray-500 mb-6">
                Foto yang dihapus tidak dapat dikembalikan. Apakah Anda yakin?
            </p>

            <div class="btn-group">
                <button class="btn-submit cancel-btn" id="cancelDeleteBtn">
                    Batal
                </button>
                <button class="btn-submit delete-btn" id="confirmDeleteBtn">
                    <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                    Hapus
                </button>
            </div>

        </div>

    </div>

</div>

<script>
    /**
     * ============================================================
     * GALERI FOTO - TANPA PHOTOSWIPE (HANYA CRUD)
     * ============================================================
     */

    (function () {
        'use strict';

        // ============================================================
        // 1. DOM REFERENCES
        // ============================================================

        const DOM = {
            gallery: document.getElementById('gallery'),
            searchInput: document.getElementById('searchInput'),
            addPhotoBtn: document.getElementById('addPhotoBtn'),

            // Modal
            photoModal: document.getElementById('photoModal'),
            deleteModal: document.getElementById('deleteModal'),
            closeModal: document.getElementById('closeModal'),
            closeDeleteModal: document.getElementById('closeDeleteModal'),
            cancelModalBtn: document.getElementById('cancelModalBtn'),
            cancelDeleteBtn: document.getElementById('cancelDeleteBtn'),
            confirmDeleteBtn: document.getElementById('confirmDeleteBtn'),

            // Form
            photoForm: document.getElementById('photoForm'),
            photoId: document.getElementById('photoId'),
            photoTitle: document.getElementById('photoTitle'),
            photoCaption: document.getElementById('photoCaption'),
            photoAuthor: document.getElementById('photoAuthor'),
            photoDate: document.getElementById('photoDate'),
            photoLocation: document.getElementById('photoLocation'),
            photoImage: document.getElementById('photoImage'),
            modalTitle: document.getElementById('modalTitle'),
            savePhotoBtn: document.getElementById('savePhotoBtn'),
        };

        // ============================================================
        // 2. STATE
        // ============================================================

        const state = {
            deleteId: null,
            isEditMode: false,
        };

        // ============================================================
        // 3. UTILITY FUNCTIONS
        // ============================================================

        const Utils = {
            getItemData: function (item) {
                const img = item.querySelector('img');
                const hoverInfo = item.querySelector('.hover-info');
                const titleEl = hoverInfo ? hoverInfo.querySelector('h3') : null;
                const authorEl = hoverInfo ? hoverInfo.querySelector('p') : null;

                return {
                    id: item.dataset.id || '',
                    image: item.dataset.image || img?.src || '',
                    thumb: item.dataset.thumb || img?.src || '',
                    caption: item.dataset.caption || '',
                    author: item.dataset.author || '',
                    date: item.dataset.date || '',
                    location: item.dataset.location || '',
                    title: item.dataset.title || titleEl?.textContent || '',
                };
            },

            setItemData: function (item, data) {
                const img = item.querySelector('img');
                const hoverInfo = item.querySelector('.hover-info');
                const titleEl = hoverInfo ? hoverInfo.querySelector('h3') : null;
                const authorEl = hoverInfo ? hoverInfo.querySelector('p') : null;

                if (data.id) item.dataset.id = data.id;
                if (data.image) {
                    item.dataset.image = data.image;
                    if (img) img.src = data.image;
                }
                if (data.thumb) {
                    item.dataset.thumb = data.thumb;
                    if (img) img.src = data.thumb;
                }
                if (data.caption) item.dataset.caption = data.caption;
                if (data.author) {
                    item.dataset.author = data.author;
                    if (authorEl) {
                        const text = authorEl.textContent;
                        const prefix = text.includes('Oleh') ? 'Oleh ' : '';
                        authorEl.textContent = prefix + data.author;
                    }
                }
                if (data.date) item.dataset.date = data.date;
                if (data.location) item.dataset.location = data.location;
                if (data.title) {
                    item.dataset.title = data.title;
                    if (titleEl) titleEl.textContent = data.title;
                }
                if (data.image && img) {
                    img.src = data.image;
                    img.alt = data.title || 'Foto Desa';
                }
            },

            createGalleryItem: function (data) {
                const div = document.createElement('div');
                div.className = 'gallery-item group';
                div.dataset.id = data.id || Date.now().toString();
                div.dataset.image = data.image || '';
                div.dataset.thumb = data.thumb || data.image || '';
                div.dataset.caption = data.caption || '';
                div.dataset.author = data.author || '';
                div.dataset.date = data.date || '';
                div.dataset.location = data.location || '';
                div.dataset.title = data.title || '';

                const imgSrc = data.thumb || data.image || 'https://via.placeholder.com/700x500/16a34a/ffffff?text=Desa+Bungur';

                div.innerHTML = `
                    <div class="relative overflow-hidden rounded-[28px]">
                        <img src="${imgSrc}" loading="lazy" alt="${data.title || 'Foto Desa'}">
                        <div class="admin-overlay">
                            <button class="edit-btn" title="Edit Foto">
                                <iconify-icon icon="solar:pen-2-linear"></iconify-icon>
                            </button>
                            <button class="delete-btn" title="Hapus Foto">
                                <iconify-icon icon="solar:trash-bin-trash-linear"></iconify-icon>
                            </button>
                        </div>
                        <div class="hover-info">
                            <div class="text-white">
                                <h3>${data.title || 'Judul Foto'}</h3>
                                <p>Oleh ${data.author || 'Admin'}</p>
                            </div>
                        </div>
                    </div>
                `;

                return div;
            },

            generateId: function () {
                return Date.now().toString(36) + Math.random().toString(36).substr(2, 5);
            },

            debounce: function (fn, delay = 300) {
                let timeout = null;
                return function (...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        fn.apply(this, args);
                    }, delay);
                };
            }
        };

        // ============================================================
        // 4. MODAL FUNCTIONS
        // ============================================================

        function openModal(data, isEdit = false) {
            state.isEditMode = isEdit;

            if (isEdit) {
                DOM.modalTitle.textContent = 'Edit Foto';
                DOM.savePhotoBtn.innerHTML = '<iconify-icon icon="solar:check-circle-linear"></iconify-icon> Update';
            } else {
                DOM.modalTitle.textContent = 'Tambah Foto Baru';
                DOM.savePhotoBtn.innerHTML = '<iconify-icon icon="solar:check-circle-linear"></iconify-icon> Simpan';
                DOM.photoForm.reset();
                DOM.photoId.value = '';
            }

            if (data) {
                DOM.photoId.value = data.id || '';
                DOM.photoTitle.value = data.title || '';
                DOM.photoCaption.value = data.caption || '';
                DOM.photoAuthor.value = data.author || '';
                DOM.photoDate.value = data.date || '';
                DOM.photoLocation.value = data.location || '';
                DOM.photoImage.value = data.image || '';
            }

            DOM.photoModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            DOM.photoModal.classList.remove('active');
            document.body.style.overflow = '';
            state.isEditMode = false;
        }

        function openDeleteModal(id) {
            state.deleteId = id;
            DOM.deleteModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            DOM.deleteModal.classList.remove('active');
            document.body.style.overflow = '';
            state.deleteId = null;
        }

        // ============================================================
        // 5. CRUD OPERATIONS
        // ============================================================

        function savePhoto(data) {
            if (state.isEditMode) {
                const item = DOM.gallery.querySelector(`.gallery-item[data-id="${data.id}"]`);
                if (item) {
                    Utils.setItemData(item, data);
                }
            } else {
                const newItem = Utils.createGalleryItem(data);
                DOM.gallery.appendChild(newItem);
                attachItemEvents(newItem);
            }

            closeModal();
            showNotification(state.isEditMode ? 'Foto berhasil diupdate!' : 'Foto berhasil ditambahkan!');
        }

        function deletePhoto(id) {
            const item = DOM.gallery.querySelector(`.gallery-item[data-id="${id}"]`);
            if (item) {
                item.remove();
                closeDeleteModal();
                showNotification('Foto berhasil dihapus!');
            }
        }

        function showNotification(message) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: message,
                    timer: 1500,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
            } else {
                alert(message);
            }
        }

        // ============================================================
        // 6. EVENT HANDLERS
        // ============================================================

        function attachItemEvents(item) {
            const editBtn = item.querySelector('.edit-btn');
            const deleteBtn = item.querySelector('.delete-btn');

            if (editBtn) {
                editBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const data = Utils.getItemData(item);
                    openModal(data, true);
                });
            }

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const id = item.dataset.id;
                    if (id) {
                        openDeleteModal(id);
                    }
                });
            }
        }

        // ============================================================
        // 7. SEARCH FUNCTIONALITY
        // ============================================================

        function filterGallery(query) {
            const items = DOM.gallery.querySelectorAll('.gallery-item');
            const q = query.toLowerCase().trim();

            items.forEach(item => {
                const title = item.dataset.title || '';
                const caption = item.dataset.caption || '';
                const author = item.dataset.author || '';
                const location = item.dataset.location || '';

                const match = title.toLowerCase().includes(q) ||
                    caption.toLowerCase().includes(q) ||
                    author.toLowerCase().includes(q) ||
                    location.toLowerCase().includes(q);

                item.style.display = match ? '' : 'none';
            });
        }

        // ============================================================
        // 8. INITIALIZATION
        // ============================================================

        function init() {
            // Attach events to existing items
            const items = DOM.gallery.querySelectorAll('.gallery-item');
            items.forEach(attachItemEvents);

            // Add photo button
            if (DOM.addPhotoBtn) {
                DOM.addPhotoBtn.addEventListener('click', function () {
                    openModal(null, false);
                });
            }

            // Close modal
            if (DOM.closeModal) {
                DOM.closeModal.addEventListener('click', closeModal);
            }
            if (DOM.cancelModalBtn) {
                DOM.cancelModalBtn.addEventListener('click', closeModal);
            }

            // Close delete modal
            if (DOM.closeDeleteModal) {
                DOM.closeDeleteModal.addEventListener('click', closeDeleteModal);
            }
            if (DOM.cancelDeleteBtn) {
                DOM.cancelDeleteBtn.addEventListener('click', closeDeleteModal);
            }

            // Confirm delete
            if (DOM.confirmDeleteBtn) {
                DOM.confirmDeleteBtn.addEventListener('click', function () {
                    if (state.deleteId) {
                        deletePhoto(state.deleteId);
                    }
                });
            }

            // Close modal on overlay click
            DOM.photoModal.addEventListener('click', function (e) {
                if (e.target === this) closeModal();
            });
            DOM.deleteModal.addEventListener('click', function (e) {
                if (e.target === this) closeDeleteModal();
            });

            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    if (DOM.photoModal.classList.contains('active')) closeModal();
                    if (DOM.deleteModal.classList.contains('active')) closeDeleteModal();
                }
            });

            // Form submit
            if (DOM.photoForm) {
                DOM.photoForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const data = {
                        id: DOM.photoId.value || Utils.generateId(),
                        title: DOM.photoTitle.value.trim() || 'Foto Desa',
                        caption: DOM.photoCaption.value.trim() || '',
                        author: DOM.photoAuthor.value.trim() || 'Admin',
                        date: DOM.photoDate.value.trim() || '',
                        location: DOM.photoLocation.value.trim() || '',
                        image: DOM.photoImage.value.trim() || 'https://via.placeholder.com/700x500/16a34a/ffffff?text=Desa+Bungur',
                        thumb: DOM.photoImage.value.trim() || 'https://via.placeholder.com/700x500/16a34a/ffffff?text=Desa+Bungur',
                    };

                    savePhoto(data);
                });
            }

            // Search
            if (DOM.searchInput) {
                const searchHandler = Utils.debounce(function () {
                    filterGallery(this.value);
                }, 300);
                DOM.searchInput.addEventListener('input', searchHandler);
            }

            console.log('✅ Galeri Foto berhasil diinisialisasi (tanpa PhotoSwipe)');
        }

        // ============================================================
        // 9. START
        // ============================================================

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }

    })();
</script>

<?php include '../Layouts/footer.php' ?>