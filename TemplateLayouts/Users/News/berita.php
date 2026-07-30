<?php include '../Layouts/header.php' ?>

<!-- ==========================================================
CONTENT
========================================================== -->
<!-- ==========================================================
HEADER
========================================================== -->
<div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between mb-10">

    <div>

        <span class="text-sm tracking-[0.25em] uppercase text-primary font-semibold">
            Dashboard
        </span>

        <h1 class="text-4xl font-bold mt-2">
            Artikel Saya
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola seluruh artikel yang telah Anda buat.
        </p>

    </div>

    <div class="flex flex-col sm:flex-row gap-3">

        <!-- Search -->
        <div class="relative">

            <iconify-icon icon="solar:magnifer-linear"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl">
            </iconify-icon>

            <input id="searchInput" type="text" placeholder="Cari artikel..."
                class="pl-12 pr-4 h-12 w-full sm:w-80 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">

        </div>

        <!-- Add -->
        <a href="create.php"
            class="h-12 px-6 rounded-2xl bg-primary text-white font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition">

            <iconify-icon icon="solar:add-circle-linear"></iconify-icon>

            Tambah Artikel

        </a>

    </div>

</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-10">

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <p class="text-gray-500 text-sm">
            Total Artikel
        </p>

        <h2 class="text-3xl font-bold mt-2">
            24
        </h2>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <p class="text-gray-500 text-sm">
            Published
        </p>

        <h2 class="text-3xl font-bold text-green-600 mt-2">
            18
        </h2>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <p class="text-gray-500 text-sm">
            Draft
        </p>

        <h2 class="text-3xl font-bold text-amber-500 mt-2">
            4
        </h2>

    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm">

        <p class="text-gray-500 text-sm">
            Ditolak
        </p>

        <h2 class="text-3xl font-bold text-red-500 mt-2">
            2
        </h2>

    </div>

</div>

<div class="flex flex-wrap gap-3 mb-8">

    <button class="px-5 h-11 rounded-full bg-primary text-white">
        Semua
    </button>

    <button class="px-5 h-11 rounded-full border">
        Published
    </button>

    <button class="px-5 h-11 rounded-full border">
        Draft
    </button>

    <button class="px-5 h-11 rounded-full border">
        Ditolak
    </button>

</div>

<!-- Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-32">

    <!-- Card -->
    <article>
        <a href="berita-detail.php" class="group block" data-aos="fade-up">

            <div class="relative overflow-hidden rounded-3xl shadow-lg">

                <img src="https://flowbite.s3.amazonaws.com/typography-plugin/typography-image-1.png"
                    class="w-full h-72 object-cover transition duration-700 group-hover:scale-110">

                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent">
                </div>

                <div class="absolute bottom-0 left-0 p-7">

                    <span class="inline-block bg-primary text-white text-xs px-3 py-1 rounded-full mb-3">

                        Berita

                    </span>

                    <h3 class="text-2xl font-bold text-white group-hover:text-green-300 transition">

                        Pembangunan Jalan Lingkungan Dimulai

                    </h3>

                    <p class="text-gray-200 text-sm mt-2">

                        Published at <span style="text-decoration: underline;">24 Juli 2026</span>, 10:30 WIB by
                        Administrator

                    </p>

                </div>

            </div>

        </a>
    </article>
    <article>
        <a href="#" class="group block" data-aos="fade-up">

            <div class="relative overflow-hidden rounded-3xl shadow-lg">

                <img src="https://flowbite.s3.amazonaws.com/typography-plugin/typography-image-1.png"
                    class="w-full h-72 object-cover transition duration-700 group-hover:scale-110">

                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent">
                </div>

                <div class="absolute bottom-0 left-0 p-7">

                    <span class="inline-block bg-primary text-white text-xs px-3 py-1 rounded-full mb-3">

                        Berita

                    </span>

                    <h3 class="text-2xl font-bold text-white group-hover:text-green-300 transition">

                        Pembangunan Jalan Lingkungan Dimulai

                    </h3>

                    <p class="text-gray-200 text-sm mt-2">

                        Published at <span style="text-decoration: underline;">24 Juli 2026</span>, 10:30 WIB by
                        Administrator

                    </p>

                </div>

            </div>

        </a>
    </article>
    <article>
        <a href="#" class="group block" data-aos="fade-up">

            <div class="relative overflow-hidden rounded-3xl shadow-lg">

                <img src="https://flowbite.s3.amazonaws.com/typography-plugin/typography-image-1.png"
                    class="w-full h-72 object-cover transition duration-700 group-hover:scale-110">

                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent">
                </div>

                <div class="absolute bottom-0 left-0 p-7">

                    <span class="inline-block bg-primary text-white text-xs px-3 py-1 rounded-full mb-3">

                        Berita

                    </span>

                    <h3 class="text-2xl font-bold text-white group-hover:text-green-300 transition">

                        Pembangunan Jalan Lingkungan Dimulai

                    </h3>

                    <p class="text-gray-200 text-sm mt-2">

                        Published at <span style="text-decoration: underline;">24 Juli 2026</span>, 10:30 WIB by
                        Administrator

                    </p>

                </div>

            </div>

        </a>
    </article>
    <article>
        <a href="#" class="group block" data-aos="fade-up">

            <div class="relative overflow-hidden rounded-3xl shadow-lg">

                <img src="https://flowbite.s3.amazonaws.com/typography-plugin/typography-image-1.png"
                    class="w-full h-72 object-cover transition duration-700 group-hover:scale-110">

                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent">
                </div>

                <div class="absolute bottom-0 left-0 p-7">

                    <span class="inline-block bg-primary text-white text-xs px-3 py-1 rounded-full mb-3">

                        Agenda

                    </span>

                    <h3 class="text-2xl font-bold text-white group-hover:text-green-300 transition">

                        Pembangunan Jalan Lingkungan Dimulai

                    </h3>

                    <p class="text-gray-200 text-sm mt-2">

                        Published at <span style="text-decoration: underline;">24 Juli 2026</span>, 10:30 WIB by
                        Administrator

                    </p>

                </div>

            </div>

        </a>
    </article>
</div>

<script>
    const searchInput = document.getElementById("searchInput");

    searchInput.addEventListener("keyup", function () {

        const keyword = this.value.toLowerCase();

        document.querySelectorAll("article").forEach(article => {

            const text = article.innerText.toLowerCase();

            article.style.display = text.includes(keyword)
                ? "block"
                : "none";

        });

    });
</script>

<?php include '../Layouts/footer.php' ?>