<?php include '../Layouts/header.php' ?>

<!-- ==========================================================
CONTENT
========================================================== -->

<!-- Heading -->
<div class="max-w-2xl my-16">

    <span class="uppercase tracking-[0.25em] text-primary font-semibold text-sm">
        Demografi Desa
    </span>

    <h2 class="text-4xl font-bold mt-3">
        Data Kependudukan Desa Bungur
    </h2>

</div>

<section class="py-20">

    <div class="grid lg:grid-cols-2 gap-8">

        <!-- Card -->

        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h3 class="text-xl font-bold mb-8">
                Jenis Kelamin
            </h3>

            <canvas id="genderChart"></canvas>

        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h3 class="text-xl font-bold mb-8">
                Pendidikan
            </h3>

            <canvas id="educationChart"></canvas>

        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h3 class="text-xl font-bold mb-8">
                Agama
            </h3>

            <canvas id="religionChart"></canvas>

        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h3 class="text-xl font-bold mb-8">
                Kelompok Umur
            </h3>

            <canvas id="ageChart"></canvas>

        </div>

    </div>

</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        Chart.defaults.font.family = "'Poppins', sans-serif";
        Chart.defaults.color = "#64748b";
        Chart.defaults.plugins.legend.labels.usePointStyle = true;

        /* ============================================
            JENIS KELAMIN
        ============================================ */

        new Chart(document.getElementById("genderChart"), {

            type: "doughnut",

            data: {

                labels: ["Laki-laki", "Perempuan"],

                datasets: [{
                    data: [2150, 2100],
                    backgroundColor: [
                        "#15803d",
                        "#22c55e"
                    ],
                    borderWidth: 0,
                    hoverOffset: 8
                }]

            },

            options: {

                responsive: true,

                plugins: {

                    legend: {
                        position: "bottom"
                    }

                },

                cutout: "70%"

            }

        });

        /* ============================================
            PENDIDIKAN
        ============================================ */

        new Chart(document.getElementById("educationChart"), {

            type: "bar",

            data: {

                labels: [
                    "SD",
                    "SMP",
                    "SMA",
                    "Diploma",
                    "Sarjana"
                ],

                datasets: [{

                    data: [
                        900,
                        760,
                        1320,
                        280,
                        480
                    ],

                    backgroundColor: [
                        "#15803d",
                        "#22c55e",
                        "#16a34a",
                        "#84cc16",
                        "#f59e0b"
                    ],

                    borderRadius: 10

                }]

            },

            options: {

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        grid: {
                            color: "#e5e7eb"
                        }

                    },

                    x: {

                        grid: {
                            display: false
                        }

                    }

                }

            }

        });

        /* ============================================
            AGAMA
        ============================================ */

        new Chart(document.getElementById("religionChart"), {

            type: "pie",

            data: {

                labels: [
                    "Islam",
                    "Kristen",
                    "Katolik",
                    "Hindu",
                    "Lainnya"
                ],

                datasets: [{

                    data: [
                        4050,
                        35,
                        10,
                        3,
                        2
                    ],

                    backgroundColor: [
                        "#15803d",
                        "#0ea5e9",
                        "#f59e0b",
                        "#ef4444",
                        "#8b5cf6"
                    ],

                    borderWidth: 0

                }]

            },

            options: {

                plugins: {

                    legend: {

                        position: "bottom"

                    }

                }

            }

        });

        /* ============================================
            UMUR
        ============================================ */

        new Chart(document.getElementById("ageChart"), {

            type: "bar",

            data: {

                labels: [
                    "0-5",
                    "6-12",
                    "13-17",
                    "18-30",
                    "31-45",
                    "46-60",
                    ">60"
                ],

                datasets: [{

                    data: [
                        340,
                        480,
                        420,
                        980,
                        760,
                        610,
                        510
                    ],

                    backgroundColor: "#15803d",

                    borderRadius: 10

                }]

            },

            options: {

                plugins: {

                    legend: {

                        display: false

                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        grid: {

                            color: "#e5e7eb"

                        }

                    },

                    x: {

                        grid: {

                            display: false

                        }

                    }

                }

            }

        });

    });
</script>

<?php include '../Layouts/footer.php' ?>