<?php include '../Layouts/header.php' ?>


<!-- ==========================================================
BREADCRUMB
========================================================== -->

<nav class="flex my-16" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="#" class="ml-1 inline-flex text-sm font-medium text-gray-800 hover:underline md:ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="mr-4 h-4 w-4">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Beranda
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-800 ">/</span>
                <a href="#" class="ml-1 text-sm font-medium text-gray-800 hover:underline md:ml-2">
                    UMKM Desa
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-800 ">/</span>
                <span class="ml-1 text-sm font-medium text-gray-800 hover:underline md:ml-2">
                    Replication
                </span>
            </div>
        </li>
    </ol>
</nav>

<!-- ==========================================================
DETAIL UMKM
========================================================== -->

<article>


    <header class="mb-10">

        <!-- FOTO PEMILIK / UMKM -->

        <div class="flex items-center gap-5 mb-8">


            <img src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                class="w-20 h-20 rounded-full object-cover shadow" alt="UMKM">


            <div>

                <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900">

                    Keripik Pisang Bungur

                </h1>


                <p class="text-gray-500 mt-2">

                    Kategori: Kuliner

                </p>


                <p class="text-gray-500">

                    Pemilik : Siti Aminah

                </p>


            </div>


        </div>

        <span class="inline-block bg-primary text-white text-xs px-3 py-2 rounded-full mb-8">

            category

        </span>

        <!-- HERO IMAGE -->


        <figure>


            <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-1.png"
                class="w-full h-[420px] lg:h-[550px] object-cover rounded-3xl shadow-lg" alt="Keripik Pisang Bungur">


            <figcaption class="text-center text-sm text-gray-500 mt-3">

                Produk UMKM Desa Bungur

            </figcaption>


        </figure>


    </header>

    <!-- ==========================================================
    INFORMASI UMKM
    ========================================================== -->


    <div class="grid lg:grid-cols-3 gap-8">


        <!-- CONTENT -->

        <div class="lg:col-span-2 prose max-w-none">


            <h3 class="text-xl font-bold mb-5">

                Menu

            </h3>


            <div class="grid sm:grid-cols-2 gap-6 not-prose">


                <div class="border rounded-2xl p-5">


                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-2.png"
                        class="rounded-xl h-40 w-full object-cover">


                    <h3 class="font-bold text-lg mt-4">

                        Keripik Original

                    </h3>


                    <p class="text-gray-500">

                        Rp 10.000

                    </p>


                </div>
                <div class="border rounded-2xl p-5">


                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-3.png"
                        class="rounded-xl h-40 w-full object-cover">


                    <h3 class="font-bold text-lg mt-4">

                        Keripik Coklat

                    </h3>


                    <p class="text-gray-500">

                        Rp 15.000

                    </p>


                </div>
                <div class="border rounded-2xl p-5">


                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-2.png"
                        class="rounded-xl h-40 w-full object-cover">


                    <h3 class="font-bold text-lg mt-4">

                        Keripik Original

                    </h3>


                    <p class="text-gray-500">

                        Rp 10.000

                    </p>


                </div>
                <div class="border rounded-2xl p-5">


                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-3.png"
                        class="rounded-xl h-40 w-full object-cover">


                    <h3 class="font-bold text-lg mt-4">

                        Keripik Coklat

                    </h3>


                    <p class="text-gray-500">

                        Rp 15.000

                    </p>


                </div>

                <div class="border rounded-2xl p-5">


                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-2.png"
                        class="rounded-xl h-40 w-full object-cover">


                    <h3 class="font-bold text-lg mt-4">

                        Keripik Original

                    </h3>


                    <p class="text-gray-500">

                        Rp 10.000

                    </p>


                </div>
                <div class="border rounded-2xl p-5">


                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-3.png"
                        class="rounded-xl h-40 w-full object-cover">


                    <h3 class="font-bold text-lg mt-4">

                        Keripik Coklat

                    </h3>


                    <p class="text-gray-500">

                        Rp 15.000

                    </p>


                </div>

            </div>


        </div>





        <!-- SIDEBAR -->

        <aside>


            <div class="bg-white border rounded-3xl p-6 shadow-sm">


                <h3 class="text-xl font-bold mb-5">

                    Informasi Usaha

                </h3>



                <div class="space-y-5 text-gray-600">


                    <div>

                        <p class="font-semibold text-gray-900">
                            Alamat
                        </p>

                        <p>
                            Dusun Bungur, Kecamatan Kanor
                            Kabupaten Bojonegoro
                        </p>

                    </div>



                    <div>

                        <p class="font-semibold text-gray-900">
                            Jam Operasional
                        </p>

                        <p>
                            08.00 - 17.00 WIB
                        </p>

                    </div>



                    <div>

                        <p class="font-semibold text-gray-900">
                            Kontak
                        </p>


                        <a href="#" class="text-green-600 font-semibold">

                            WhatsApp

                        </a>


                    </div>


                </div>


            </div>





            <!-- BUTTON -->


            <a href="#" class="mt-6 flex items-center justify-center gap-2
bg-green-500 text-white rounded-full py-3 font-semibold
hover:bg-green-600 transition">


                <i class="bi bi-whatsapp"></i>

                Hubungi Pemilik


            </a>



        </aside>


    </div>

</article>


<!-- ==========================================================
LOKASI
========================================================== -->


<section class="mt-16">


    <h2 class="text-2xl font-bold mb-6">

        Lokasi UMKM

    </h2>


    <div class="rounded-3xl overflow-hidden shadow">


        <iframe src="https://maps.google.com/maps?q=Desa%20Bungur%20Bojonegoro&t=&z=15&ie=UTF8&iwloc=&output=embed"
            width="100%" height="400" style="border:0" allowfullscreen="" loading="lazy">

        </iframe>


    </div>


</section>

<!-- ==========================================================
SHARE
========================================================== -->


<section class="mt-16 border-t py-8">


    <h3 class="font-bold text-xl mb-5">

        Bagikan UMKM

    </h3>


    <div class="flex gap-3">


        <a class="w-11 h-11 rounded-full bg-green-500 text-white flex items-center justify-center">

            <i class="bi bi-whatsapp"></i>

        </a>


        <a class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center">

            <i class="bi bi-facebook"></i>

        </a>

        <!-- Copy Link -->
        <button id="copy-link"
            class="w-11 h-11 rounded-full bg-gray-700 text-white flex items-center justify-center hover:scale-110 transition duration-300">

            <i class="bi bi-link-45deg text-xl"></i>

        </button>


    </div>


</section>



<?php include '../Layouts/footer.php' ?>