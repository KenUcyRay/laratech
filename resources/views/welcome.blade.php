<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LaraTech - Sistem Manajemen</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .hero-section {
            padding: 100px 0;
        }
        .role-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .role-card:hover {
            transform: translateY(-10px);
        }
        .role-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="hero-section">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-12">
                        <h1 class="display-4 text-white mb-3">
                            <i class="fas fa-tools me-3"></i>LaraTech
                        </h1>
                        <p class="lead text-white">Sistem Manajemen Terintegrasi untuk Admin, Operator, dan Mekanik</p>
                    </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="role-card p-4 text-center h-100">
                            <div class="role-icon text-primary">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h3 class="mb-3">Admin Dashboard</h3>
                            <p class="text-muted mb-4">
                                Kelola pengguna, monitor sistem, dan akses laporan lengkap
                            </p>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-tachometer-alt me-2"></i>Masuk Admin
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="role-card p-4 text-center h-100">
                            <div class="role-icon text-success">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <h3 class="mb-3">Operator Dashboard</h3>
                            <p class="text-muted mb-4">
                                Kelola tugas harian, jadwal kerja, dan laporan operasional
                            </p>
                            <a href="{{ route('operator.dashboard') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-tasks me-2"></i>Masuk Operator
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="role-card p-4 text-center h-100">
                            <div class="role-icon text-warning">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <h3 class="mb-3">Mekanik Dashboard</h3>
                            <p class="text-muted mb-4">
                                Kelola work order, maintenance, dan inventori spare part
                            </p>
                            <a href="{{ route('mekanik.dashboard') }}" class="btn btn-warning btn-lg">
                                <i class="fas fa-tools me-2"></i>Masuk Mekanik
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <div class="role-card p-4 d-inline-block">
                            <h5 class="mb-3">Akses Sistem</h5>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>