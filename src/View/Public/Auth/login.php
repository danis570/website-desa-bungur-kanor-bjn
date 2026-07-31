
<?php if(isset($model['error'])) { ?>
<div class="rounded-xl mt-16 border border-red-200 bg-red-50 px-4 py-3 text-red-700">
    <strong>Login gagal.</strong><br>
    <?= $model['error'] ?>
</div>
<?php } ?>


<div class="min-h-screen flex items-center justify-center py-10 px-6">

    <div class="max-w-6xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden grid lg:grid-cols-2">

        <!-- ==========================
             LEFT
        =========================== -->
        <div class="p-10 lg:p-14 flex flex-col justify-center">

            <div class="text-center">

                <!-- Logo Desa -->
                <img src="../assets/logo-bojonegoro.png" alt="Logo Desa Bungur"
                    class="w-24 h-24 mx-auto mb-6 object-contain">

                <h1 class="text-3xl font-bold text-gray-900">
                    Website Desa Bungur
                </h1>

                <p class="mt-2 text-gray-500">
                    Sistem Informasi Desa Bungur
                </p>

            </div>

            <div class="mt-10">
                <form action="/login" method="POST">

                    <!-- Email -->
                    <div class="mb-5">

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Email
                        </label>

                        <input type="email" name="email" placeholder="example@email.com" value="<?= $_POST['email'] ?? '' ?>"
                            class="w-full rounded-xl border border-gray-300 px-5 py-3 focus:ring-2 focus:ring-primary focus:border-primary outline-none">

                    </div>

                    <!-- Password -->
                    <div class="mb-6">

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Password
                        </label>

                        <input type="password" name="password" placeholder="Masukkan password"  value="<?= $_POST['password'] ?? '' ?>"
                            class="w-full rounded-xl border border-gray-300 px-5 py-3 focus:ring-2 focus:ring-primary focus:border-primary outline-none">

                    </div>

                    <button type="submit"
                        class="w-full bg-primary hover:opacity-90 text-white py-3 rounded-xl font-semibold transition">

                        Masuk

                    </button>

                </form>

                <p class="text-center text-sm text-gray-500 mt-8">

                    © <?= date('Y') ?> Website Desa Bungur<br>

                    Kecamatan Kanor • Kabupaten Bojonegoro

                </p>

            </div>

        </div>

        <!-- ==========================
             RIGHT
        =========================== -->
        <div class="hidden lg:block relative">

            <img src="https://i.pinimg.com/1200x/6a/95/e0/6a95e00d1898c07282fcd5b2925bf649.jpg"
                class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-br from-primary/80 to-green-900/80"></div>

            <div class="relative h-full flex items-center">

                <div class="max-w-md px-12 text-white">

                    <span class="uppercase tracking-[0.2em] text-sm font-semibold text-white/80">
                        SELAMAT DATANG
                    </span>

                    <h2 class="mt-4 text-5xl font-bold leading-tight">
                        Website Desa Bungur
                    </h2>

                    <p class="mt-6 text-lg leading-8 text-white/90">
                        Kelola informasi desa, berita, galeri, aparatur,
                        pelayanan masyarakat, dan seluruh konten website
                        secara mudah melalui dashboard administrator.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>