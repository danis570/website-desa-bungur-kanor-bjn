<?php include '../Layouts/header.php' ?>

<!-- ==========================================================
CONTENT
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
                Documentation
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <span class="mx-2.5 text-gray-800 ">/</span>
                <a href="#" class="ml-1 text-sm font-medium text-gray-800 hover:underline md:ml-2">
                    Database
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

<article>
    <header class="mb-6 not-format">

        <!-- Author -->
        <address class="flex items-center mb-6 not-italic">
            <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                <img class="mr-4 w-16 h-16 rounded-full"
                    src="https://flowbite.com/docs/images/people/profile-picture-2.jpg" alt="Administrator">

                <div>
                    <a href="#" rel="author" class="text-xl font-bold text-gray-900">
                        Administrator
                    </a>

                    <p class="text-base text-gray-500">
                        Pemerintah Desa Bungur
                    </p>

                    <p class="text-base text-gray-500">
                        <time pubdate datetime="2026-07-24">
                            24 Juli 2026
                        </time>
                    </p>
                </div>
            </div>
        </address>

        <span class="inline-block bg-primary text-white text-xs px-3 py-1 rounded-full mb-3">

            category

        </span>



        <!-- Judul -->
        <h1 class="mb-6 text-3xl font-extrabold leading-tight text-gray-900 lg:text-4xl">

            Pembangunan Jalan Lingkungan Dimulai

        </h1>


        <!-- Thumbnail / Hero Image -->
        <figure class="mb-8">

            <img src="https://flowbite.s3.amazonaws.com/typography-plugin/typography-image-1.png"
                class="w-full h-[420px] lg:h-[520px] object-cover rounded-3xl shadow-lg"
                alt="Pembangunan Jalan Lingkungan">

            <figcaption class="mt-3 text-sm text-gray-500 text-center">
                Dokumentasi Pemerintah Desa Bungur
            </figcaption>

        </figure>

    </header>
    <p class="lead">Flowbite is an open-source library of UI components built with the utility-first
        classes from Tailwind CSS. It also includes interactive elements such as dropdowns, modals,
        datepickers.</p>
    <p>Before going digital, you might benefit from scribbling down some ideas in a sketchbook. This way,
        you can think things through before committing to an actual design project.</p>
    <p>But then I found a <a href="https://flowbite.com">component library based on Tailwind CSS called
            Flowbite</a>. It comes with the most commonly used UI components, such as buttons, navigation
        bars, cards, form elements, and more which are conveniently built with the utility classes from
        Tailwind CSS.</p>

    <h2>Getting started with Flowbite</h2>
    <p>First of all you need to understand how Flowbite works. This library is not another framework.
        Rather, it is a set of components based on Tailwind CSS that you can just copy-paste from the
        documentation.</p>
    <p>It also includes a JavaScript file that enables interactive components, such as modals, dropdowns,
        and datepickers which you can optionally include into your project via CDN or NPM.</p>
    <p>You can check out the <a href="https://flowbite.com/docs/getting-started/quickstart/">quickstart
            guide</a> to explore the elements by including the CDN files into your project. But if you want
        to build a project with Flowbite I recommend you to follow the build tools steps so that you can
        purge and minify the generated CSS.</p>
    <p>You'll also receive a lot of useful application UI, marketing UI, and e-commerce pages that can help
        you get started with your projects even faster. You can check out this <a
            href="https://flowbite.com/docs/components/tables/">comparison table</a> to better understand
        the differences between the open-source and pro version of Flowbite.</p>
    <h2>When does design come in handy?</h2>
    <p>While it might seem like extra work at a first glance, here are some key moments in which prototyping
        will come in handy:</p>
    <ol>
        <li><strong>Usability testing</strong>. Does your user know how to exit out of screens? Can they
            follow your intended user journey and buy something from the site you’ve designed? By running a
            usability test, you’ll be able to see how users will interact with your design once it’s live;
        </li>
        <li><strong>Involving stakeholders</strong>. Need to check if your GDPR consent boxes are displaying
            properly? Pass your prototype to your data protection team and they can test it for real;</li>
        <li><strong>Impressing a client</strong>. Prototypes can help explain or even sell your idea by
            providing your client with a hands-on experience;</li>
        <li><strong>Communicating your vision</strong>. By using an interactive medium to preview and test
            design elements, designers and developers can understand each other — and the project — better.
        </li>
    </ol>
    <h3>Laying the groundwork for best design</h3>
    <p>Before going digital, you might benefit from scribbling down some ideas in a sketchbook. This way,
        you can think things through before committing to an actual design project.</p>
    <p>Let's start by including the CSS file inside the <code>head</code> tag of your HTML.</p>
    <h3>Understanding typography</h3>
    <h4>Type properties</h4>
    <p>A typeface is a collection of letters. While each letter is unique, certain shapes are shared across
        letters. A typeface represents shared patterns across a collection of letters.</p>
    <h4>Baseline</h4>
    <p>A typeface is a collection of letters. While each letter is unique, certain shapes are shared across
        letters. A typeface represents shared patterns across a collection of letters.</p>
    <h4>Measurement from the baseline</h4>
    <p>A typeface is a collection of letters. While each letter is unique, certain shapes are shared across
        letters. A typeface represents shared patterns across a collection of letters.</p>
    <h3>Type classification</h3>
    <h4>Serif</h4>
    <p>A serif is a small shape or projection that appears at the beginning or end of a stroke on a letter.
        Typefaces with serifs are called serif typefaces. Serif fonts are classified as one of the
        following:</p>
    <h4>Old-Style serifs</h4>
    <ul>
        <li>Low contrast between thick and thin strokes</li>
        <li>Diagonal stress in the strokes</li>
        <li>Slanted serifs on lower-case ascenders</li>
    </ul><img src="https://flowbite.s3.amazonaws.com/typography-plugin/typography-image-2.png" alt="">
    <ol>
        <li>Low contrast between thick and thin strokes</li>
        <li>Diagonal stress in the strokes</li>
        <li>Slanted serifs on lower-case ascenders</li>
    </ol>
    <h3>Laying the best for successful prototyping</h3>
    <p>A serif is a small shape or projection that appears at the beginning:</p>
    <h4>Table example</h4>
    <p>A serif is a small shape or projection that appears at the beginning or end of a stroke on a letter.
    </p>
    <table>
        <thead>
            <tr>
                <th>Country</th>
                <th>Date &amp; Time</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>United States</td>
                <td>April 21, 2021</td>
                <td><strong>$2,300</strong></td>
            </tr>
            <tr>
                <td>Canada</td>
                <td>May 31, 2021</td>
                <td><strong>$300</strong></td>
            </tr>
            <tr>
                <td>United Kingdom</td>
                <td>June 3, 2021</td>
                <td><strong>$2,500</strong></td>
            </tr>
            <tr>
                <td>Australia</td>
                <td>June 23, 2021</td>
                <td><strong>$3,543</strong></td>
            </tr>
            <tr>
                <td>Germany</td>
                <td>July 6, 2021</td>
                <td><strong>$99</strong></td>
            </tr>
            <tr>
                <td>France</td>
                <td>August 23, 2021</td>
                <td><strong>$2,540</strong></td>
            </tr>
        </tbody>
    </table>
    <h3>Best practices for setting up your prototype</h3>
    <p><strong>Low fidelity or high fidelity?</strong> Fidelity refers to how close a prototype will be to
        the real deal. If you’re simply preparing a quick visual aid for a presentation, a low-fidelity
        prototype — like a wireframe with placeholder images and some basic text — would be more than
        enough. But if you’re going for more intricate usability testing, a high-fidelity prototype — with
        on-brand colors, fonts and imagery — could help get more pointed results.</p>
    <p><strong>Consider your user</strong>. To create an intuitive user flow, try to think as your user
        would when interacting with your product. While you can fine-tune this during beta testing,
        considering your user’s needs and habits early on will save you time by setting you on the right
        path.</p>
    <p><strong>Start from the inside out</strong>. A nice way to both organize your tasks and create more
        user-friendly prototypes is by building your prototypes ‘inside out’. Start by focusing on what will
        be important to your user, like a Buy now button or an image gallery, and list each element by order
        of priority. This way, you’ll be able to create a prototype that puts your users’ needs at the heart
        of your design.</p>
    <p>And there you have it! Everything you need to design and share prototypes — right in Flowbite Figma.
    </p>

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


<aside aria-label="Related articles" class="py-12 lg:py-24">



    <h2 class="mb-8 text-2xl font-bold text-gray-900">
        Artikel Terkait
    </h2>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">


        <article class="group">

            <a href="#" class="block overflow-hidden rounded-2xl">

                <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-1.png"
                    class="w-full aspect-[16/10] object-cover transition duration-500 group-hover:scale-105"
                    alt="Image 1">

            </a>


            <h3 class="mt-5 mb-2 text-lg lg:text-xl font-bold leading-tight text-gray-900">

                <a href="#" class="hover:text-primary transition">

                    Our first office

                </a>

            </h3>


            <p class="text-sm text-gray-500 line-clamp-2">

                Over the past year, Volosoft has undergone many changes.
                After months of preparation.

            </p>


            <div class="mt-4 text-sm font-medium text-primary">

                Read in 2 minutes

            </div>


        </article>



        <article class="group">

            <a href="#" class="block overflow-hidden rounded-2xl">

                <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-2.png"
                    class="w-full aspect-[16/10] object-cover transition duration-500 group-hover:scale-105"
                    alt="Image 2">

            </a>


            <h3 class="mt-5 mb-2 text-lg lg:text-xl font-bold leading-tight text-gray-900">

                <a href="#" class="hover:text-primary transition">

                    Enterprise design tips

                </a>

            </h3>


            <p class="text-sm text-gray-500 line-clamp-2">

                Over the past year, Volosoft has undergone many changes.
                After months of preparation.

            </p>


            <div class="mt-4 text-sm font-medium text-primary">

                Read in 12 minutes

            </div>


        </article>



        <article class="group">

            <a href="#" class="block overflow-hidden rounded-2xl">

                <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-3.png"
                    class="w-full aspect-[16/10] object-cover transition duration-500 group-hover:scale-105"
                    alt="Image 3">

            </a>


            <h3 class="mt-5 mb-2 text-lg lg:text-xl font-bold leading-tight text-gray-900">

                <a href="#" class="hover:text-primary transition">

                    We partnered with Google

                </a>

            </h3>


            <p class="text-sm text-gray-500 line-clamp-2">

                Over the past year, Volosoft has undergone many changes.
                After months of preparation.

            </p>


            <div class="mt-4 text-sm font-medium text-primary">

                Read in 8 minutes

            </div>


        </article>



        <article class="group">

            <a href="#" class="block overflow-hidden rounded-2xl">

                <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/article/blog-4.png"
                    class="w-full aspect-[16/10] object-cover transition duration-500 group-hover:scale-105"
                    alt="Image 4">

            </a>


            <h3 class="mt-5 mb-2 text-lg lg:text-xl font-bold leading-tight text-gray-900">

                <a href="#" class="hover:text-primary transition">

                    Our first project with React

                </a>

            </h3>


            <p class="text-sm text-gray-500 line-clamp-2">

                Over the past year, Volosoft has undergone many changes.
                After months of preparation.

            </p>


            <div class="mt-4 text-sm font-medium text-primary">

                Read in 4 minutes

            </div>


        </article>


    </div>



</aside>

<section class="py-12 lg:py-16">

    <div class="max-w-xl">

        <h2 class="mb-8 text-2xl font-bold text-gray-900">
            Arsip Artikel
        </h2>


        <div class="divide-y divide-gray-200">


            <a href="#" class="group flex items-center gap-3 py-6 text-xl text-cyan-600 hover:text-primary transition">

                <span class="text-gray-400 group-hover:text-primary transition">
                    ›
                </span>

                Juni 2026

            </a>


            <a href="#" class="group flex items-center gap-3 py-6 text-xl text-cyan-600 hover:text-primary transition">

                <span class="text-gray-400 group-hover:text-primary transition">
                    ›
                </span>

                Desember 2025

            </a>


            <a href="#" class="group flex items-center gap-3 py-6 text-xl text-cyan-600 hover:text-primary transition">

                <span class="text-gray-400 group-hover:text-primary transition">
                    ›
                </span>

                April 2025

            </a>


            <a href="#" class="group flex items-center gap-3 py-6 text-xl text-cyan-600 hover:text-primary transition">

                <span class="text-gray-400 group-hover:text-primary transition">
                    ›
                </span>

                September 2024

            </a>


            <a href="#" class="group flex items-center gap-3 py-6 text-xl text-cyan-600 hover:text-primary transition">

                <span class="text-gray-400 group-hover:text-primary transition">
                    ›
                </span>

                Maret 2024

            </a>


            <a href="#" class="group flex items-center gap-3 py-6 text-xl text-cyan-600 hover:text-primary transition">

                <span class="text-gray-400 group-hover:text-primary transition">
                    ›
                </span>

                Januari 2023

            </a>


        </div>

    </div>

</section>

<script>
    const pageUrl = encodeURIComponent(window.location.href);
    const pageTitle = encodeURIComponent(document.title);

    document.getElementById("share-facebook").href =
        `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;

    document.getElementById("share-twitter").href =
        `https://twitter.com/intent/tweet?url=${pageUrl}&text=${pageTitle}`;

    document.getElementById("share-whatsapp").href =
        `https://wa.me/?text=${pageTitle}%20${pageUrl}`;

    document.getElementById("share-telegram").href =
        `https://t.me/share/url?url=${pageUrl}&text=${pageTitle}`;

    document.getElementById("copy-link").addEventListener("click", async () => {

        try {
            await navigator.clipboard.writeText(window.location.href);

            const btn = document.getElementById("copy-link");
            btn.innerHTML = '<i class="bi bi-check-lg text-xl"></i>';

            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-link-45deg text-xl"></i>';
            }, 1500);

        } catch (err) {
            alert("Gagal menyalin link.");
        }

    });
</script>

<?php include '../Layouts/footer.php' ?>