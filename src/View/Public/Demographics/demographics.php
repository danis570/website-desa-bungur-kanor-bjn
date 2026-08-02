
<!-- ==========================================================
HEADING
========================================================== -->

<div class="max-w-2xl my-16">

    <span class="uppercase tracking-[0.25em] text-primary font-semibold text-sm">
        Demografi Desa
    </span>

    <h2 class="text-4xl font-bold mt-3">
        Data Kependudukan Desa Bungur
    </h2>

</div>

<!-- ==========================================================
CHARTS
========================================================== -->

<section class="py-20">

    <div class="grid lg:grid-cols-2 gap-8">

        <!-- Jenis Kelamin -->
        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h3 class="text-xl font-bold mb-8">
                Jenis Kelamin
            </h3>

            <?php if (!empty($model['genderData']['values'])): ?>
                <canvas id="genderChart"></canvas>
            <?php else: ?>
                <div class="text-center text-gray-400 py-12">
                    <p>Belum ada data</p>
                </div>
            <?php endif; ?>

        </div>

        <!-- Pendidikan -->
        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h3 class="text-xl font-bold mb-8">
                Pendidikan
            </h3>

            <?php if (!empty($model['educationData']['values'])): ?>
                <canvas id="educationChart"></canvas>
            <?php else: ?>
                <div class="text-center text-gray-400 py-12">
                    <p>Belum ada data</p>
                </div>
            <?php endif; ?>

        </div>

        <!-- Agama -->
        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h3 class="text-xl font-bold mb-8">
                Agama
            </h3>

            <?php if (!empty($model['religionData']['values'])): ?>
                <canvas id="religionChart"></canvas>
            <?php else: ?>
                <div class="text-center text-gray-400 py-12">
                    <p>Belum ada data</p>
                </div>
            <?php endif; ?>

        </div>

        <!-- Kelompok Umur -->
        <div class="bg-white rounded-3xl shadow-xl p-8">

            <h3 class="text-xl font-bold mb-8">
                Kelompok Umur
            </h3>

            <?php if (!empty($model['ageData']['values'])): ?>
                <canvas id="ageChart"></canvas>
            <?php else: ?>
                <div class="text-center text-gray-400 py-12">
                    <p>Belum ada data</p>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>

<!-- ==========================================================
SCRIPT
========================================================== -->

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js">
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        Chart.defaults.font.family = "'Poppins', sans-serif";
        Chart.defaults.color = "#64748b";
        Chart.defaults.plugins.legend.labels.usePointStyle = true;

        <?php if (!empty($model['genderData']['values'])): ?>
            /* ============================================
                JENIS KELAMIN
            ============================================ */

            new Chart(document.getElementById("genderChart"), {

                type: "doughnut",

                data: {

                    labels: <?= json_encode($model['genderData']['labels']) ?>,

                    datasets: [{
                        data: <?= json_encode($model['genderData']['values']) ?>,
                        backgroundColor: <?= json_encode($model['genderData']['colors']) ?>,
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
        <?php endif; ?>

        <?php if (!empty($model['educationData']['values'])): ?>
            /* ============================================
                PENDIDIKAN
            ============================================ */

            new Chart(document.getElementById("educationChart"), {

                type: "bar",

                data: {

                    labels: <?= json_encode($model['educationData']['labels']) ?>,

                    datasets: [{

                        data: <?= json_encode($model['educationData']['values']) ?>,

                        backgroundColor: <?= json_encode($model['educationData']['colors']) ?>,

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
        <?php endif; ?>

        <?php if (!empty($model['religionData']['values'])): ?>
            /* ============================================
                AGAMA
            ============================================ */

            new Chart(document.getElementById("religionChart"), {

                type: "pie",

                data: {

                    labels: <?= json_encode($model['religionData']['labels']) ?>,

                    datasets: [{

                        data: <?= json_encode($model['religionData']['values']) ?>,

                        backgroundColor: <?= json_encode($model['religionData']['colors']) ?>,

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
        <?php endif; ?>

        <?php if (!empty($model['ageData']['values'])): ?>
            /* ============================================
                KELOMPOK UMUR
            ============================================ */

            new Chart(document.getElementById("ageChart"), {

                type: "bar",

                data: {

                    labels: <?= json_encode($model['ageData']['labels']) ?>,

                    datasets: [{

                        data: <?= json_encode($model['ageData']['values']) ?>,

                        backgroundColor: <?= json_encode($model['ageData']['colors']) ?>,

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
        <?php endif; ?>

    });
</script>