<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Aplikasi Absensi') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    
    <style>
        /* These variables are for Bootstrap utility classes like border-left-* and text colors */
        :root {
            --primary-color: #4e73df; /* Example primary color (e.g., from SB Admin 2) */
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --gray-300: #dddfeb;
            --gray-800: #5a5c69; /* For h5 text color */
        }

        /* Basic overrides/additions to ensure card styles work */
        .card {
            border: none; /* Override default Bootstrap border */
            border-radius: 0.35rem; /* Standard Bootstrap card radius */
        }
        .card .card-header {
            background-color: #fff; /* Ensure header background is white */
            border-bottom: 1px solid #e3e6f0;
            padding: 0.75rem 1.25rem;
            border-top-left-radius: 0.35rem;
            border-top-right-radius: 0.35rem;
        }

        /* Border Left Utilities */
        .card.border-left-primary { border-left: 0.25rem solid var(--primary-color) !important; }
        .card.border-left-success { border-left: 0.25rem solid var(--success-color) !important; }
        .card.border-left-info { border-left: 0.25rem solid var(--info-color) !important; }
        .card.border-left-warning { border-left: 0.25rem solid var(--warning-color) !important; }
        .card.border-left-danger { border-left: 0.25rem solid var(--danger-color) !important; }

        /* Text Utilities */
        .text-xs { font-size: 0.7rem !important; }
        .h5.mb-0 { font-size: 1.25rem !important; } /* Ensure consistent heading size */
        .text-gray-300 { color: var(--gray-300) !important; } /* Icon color */
        .text-gray-800 { color: var(--gray-800) !important; } /* Heading text color */
        .fw-bold { font-weight: 700 !important; } /* Ensure bold works */

        /* Chart Area specific styles */
        .chart-area {
            position: relative;
        }
        /* Ensure table styling is consistent */
        .table-responsive .table {
            border-collapse: collapse;
        }
        .table-responsive .table thead th {
            border-bottom: 2px solid #e3e6f0;
            background-color: #f8f9fc;
            vertical-align: bottom;
            padding: 0.75rem;
            text-align: inherit;
        }
        .table-responsive .table tbody td {
            vertical-align: middle;
            padding: 0.75rem;
        }
    </style>

</head>
<body>
    <div class="wrapper">
        <?= $this->include('layouts/main_sidebar') ?>
    
        <div class="main-content">
            <header class="content-header">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </header>
            
            <main class="container-fluid p-3 p-md-4">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // REMOVED feather.replace(); as we are no longer using Feather Icons

        // LOGIKA UNTUK TOGGLE SIDEBAR DI MOBILE
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.querySelector(".sidebar");
            const sidebarToggle = document.getElementById("sidebarToggle");

            if (sidebarToggle) {
                sidebarToggle.addEventListener("click", function() {
                    sidebar.classList.toggle("active");
                });
            }

            // =======================================================
            // TAMBAHAN: Sembunyikan sidebar saat link di-klik (di mobile)
            // =======================================================
            const sidebarLinks = document.querySelectorAll(".sidebar-link");
            sidebarLinks.forEach(function(link) {
                link.addEventListener("click", function() {
                    // Hanya jalankan jika layar kecil (lebar di bawah 992px)
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove("active");
                    }
                });
            });
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>