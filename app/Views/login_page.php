<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi & Payroll</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* === General Styles === */
        body {
            background-color: #f4f7f6; /* Latar belakang netral yang lembut */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif; /* Font baru */
        }

        /* === Login Container & Card === */
        .login-container {
            max-width: 900px;
            width: 100%;
            margin: 1rem;
        }
        
        .login-card {
            border-radius: 20px; /* Sudut lebih membulat */
            border: none;
            overflow: hidden; /* Penting untuk layout 2 kolom */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1); /* Shadow lebih halus */
        }

        /* === Kolom Branding (Kiri) === */
        .login-branding {
            background: linear-gradient(45deg, #0d6efd, #0dcaf0); /* Gradien biru profesional */
            color: #ffffff;
            padding: 4rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .login-branding h1 {
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .login-branding p {
            font-weight: 300;
            font-size: 1rem;
            opacity: 0.9;
        }
        
        .branding-logo {
            max-width: 100px;
            margin: 0 auto 1.5rem auto;
            filter: brightness(0) invert(1); /* Membuat logo jadi putih */
        }


        /* === Kolom Form (Kanan) === */
        .login-form-container {
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .card-subtitle {
            color: #6c757d;
            margin-bottom: 2rem;
            font-weight: 400;
        }
        
        /* === Form Elements === */
        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .input-group-text {
            background-color: transparent;
            border-right: 0;
            color: #6c757d;
        }

        .form-control {
            border-radius: 8px !important;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
            border-left: 0;
        }
        
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: none;
        }
        .form-control:focus ~ .input-group-text {
            border-color: #0d6efd;
        }

        .input-group .form-control {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
        
        .input-group .input-group-text {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
        
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
            transform: translateY(-2px); /* Efek tombol terangkat */
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .forgot-password {
            font-size: 0.9rem;
        }

        /* === Alert Styles === */
        .alert {
            border-radius: 8px;
        }

    </style>
</head>
<body>
    
    <div class="login-container">
        <div class="card login-card">
            <div class="row g-0">
                <div class="col-lg-6 d-none d-lg-flex login-branding">
                    <div>
                        <img src="/images/logo.png" alt="Logo" class="branding-logo">
                        <h1 class="mb-3">Sistem Absensi & Payroll</h1>
                        <p class="lead">Manajemen kehadiran karyawan dan penggajian menjadi lebih efisien, akurat, dan terintegrasi.</p>
                    </div>
                </div>

                <div class="col-lg-6 login-form-container">
                    
                    <h3 class="card-title">Selamat Datang Kembali!</h3>
                    <p class="card-subtitle">Silakan masuk untuk melanjutkan.</p>
                    
                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="/login/process" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username Anda" value="<?= old('username') ?>" required autocomplete="username">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                             <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mb-4">
                            <a href="#" class="forgot-password text-decoration-none">Lupa Password?</a>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>