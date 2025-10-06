<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Admin</h1>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Karyawan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($total_karyawan) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Hadir Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($hadir_hari_ini) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Jabatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($total_jabatan) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-bar me-1"></i> Grafik Kehadiran 7 Hari Terakhir
            </h6>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 350px;">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('attendanceChart');

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= $chart_labels ?>,
                    datasets: [{
                        label: 'Jumlah Kehadiran',
                        data: <?= $chart_data ?>,
                        backgroundColor: 'rgba(60, 80, 224, 0.7)', // Slightly darker primary color for bars
                        borderColor: 'rgba(60, 80, 224, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        hoverBackgroundColor: 'rgba(60, 80, 224, 0.9)' // Darker on hover
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        x: {
                            time: {
                                unit: 'day'
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        },
                        y: {
                            ticks: {
                                min: 0,
                                maxTicksLimit: 5,
                                padding: 10,
                                // Only show integer ticks
                                callback: function(value, index, values) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                    return '';
                                }
                            },
                            grid: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        },
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            titleMarginBottom: 10,
                            titleFont: {
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 14
                            },
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    return label + context.raw + ' Hari';
                                }
                            }
                        },
                    }
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>