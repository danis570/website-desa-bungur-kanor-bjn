<!-- Footer -->
<footer
    class="mt-8 pb-4 text-center sm:text-left flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400">
    <p>© 2023 Aura Dashboard UI. All rights reserved.</p>
    <div class="flex gap-4 mt-2 sm:mt-0">
        <a href="#" class="hover:text-primary">Privacy Policy</a>
        <a href="#" class="hover:text-primary">Terms of Service</a>
    </div>
</footer>

</div>
</main>
</div>

<!-- Scripts -->
<script>
    // --- Sidebar Logic ---
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        // Mobile: Toggle Translate X
        const isClosed = sidebar.classList.contains('-translate-x-full');

        if (isClosed) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            // Small delay to allow display:block to apply before opacity transition
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
            }, 10);
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }
    }

    // --- Charts Configuration ---
    document.addEventListener('DOMContentLoaded', function () {
        Chart.defaults.font.family = "'Montserrat', sans-serif";
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.scale.grid.color = '#f1f5f9';
        Chart.defaults.scale.grid.borderColor = 'transparent';

        // Revenue Chart (Line with Gradient)
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');

        // Gradient
        let gradient = ctxRevenue.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(88, 2, 247, 0.2)');
        gradient.addColorStop(1, 'rgba(88, 2, 247, 0)');

        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                datasets: [{
                    label: 'Revenue',
                    data: [30000, 35000, 32000, 48000, 45000, 60000, 58000, 75000, 72000, 84254],
                    borderColor: '#5802f7',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#5802f7',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'white',
                        titleColor: '#1a1a1a',
                        bodyColor: '#64748b',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function (context) {
                                return '$ ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4] },
                        ticks: { callback: function (value) { return '$' + value / 1000 + 'k'; } }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Device Chart (Doughnut)
        const ctxDevice = document.getElementById('deviceChart').getContext('2d');
        new Chart(ctxDevice, {
            type: 'doughnut',
            data: {
                labels: ['Desktop', 'Mobile', 'Tablet'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: [
                        '#5802f7', // Primary
                        '#2dd4bf', // Teal
                        '#fb923c'  // Orange
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'white',
                        bodyColor: '#1a1a1a',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                    }
                }
            }
        });
    });
</script>

</body>

</html>