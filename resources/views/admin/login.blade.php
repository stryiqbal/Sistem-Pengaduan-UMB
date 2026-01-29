<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Pengaduan Sarpras UMB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --umb-blue: #0B4EA2;
            --umb-blue-dark: #062e61;
            --soft-bg: #f8fafc;
        }

        body {
            background: radial-gradient(circle at top right, #1e40af, transparent),
                        radial-gradient(circle at bottom left, #0B4EA2, #062e61);
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
        }

        /* LOGIN CARD STYLING */
        .login-card {
            border: none;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .card-body { padding: 3rem 2.5rem; }

        /* LOGO BOX */
        .logo-wrapper {
            width: 90px;
            height: 90px;
            background: #fff;
            padding: 12px;
            border-radius: 24px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo-umb { width: 100%; object-fit: contain; }

        /* FORM INPUTS */
        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #94a3b8;
            border-radius: 12px 0 0 12px;
            padding-left: 1.2rem;
        }

        .form-control {
            border-left: none;
            height: 54px;
            border-radius: 0 12px 12px 0;
            font-size: 0.95rem;
            font-weight: 500;
            background-color: transparent;
        }

        .form-control:focus {
            border-color: #dee2e6;
            box-shadow: none;
            background-color: #fff;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 4px rgba(11, 78, 162, 0.1);
            border-radius: 12px;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control,
        .input-group:focus-within .btn-outline-secondary {
            border-color: var(--umb-blue);
        }

        /* BUTTONS */
        .btn-login {
            height: 54px;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            background: linear-gradient(to right, var(--umb-blue), var(--umb-blue-dark));
            border: none;
            box-shadow: 0 10px 15px -3px rgba(11, 78, 162, 0.3);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(11, 78, 162, 0.4);
            filter: brightness(1.1);
        }

        /* TOGGLE PASSWORD BTN */
        #togglePassword {
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #94a3b8;
        }

        /* DECORATION */
        .bg-pattern {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: -1;
        }

        /* RESPONSIVE */
        @media (max-width: 576px) {
            body { background: #fff; align-items: flex-start; }
            .login-card { box-shadow: none; border-radius: 0; background: transparent; }
            .card-body { padding: 4rem 1.5rem; }
            .bg-pattern { display: none; }
        }
    </style>
</head>

<body>
<div class="bg-pattern"></div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4 px-3">

            <div class="card login-card animate__animated animate__zoomIn">
                <div class="card-body">

                    <div class="text-center mb-5">
                        <div class="logo-wrapper animate__animated animate__bounceIn">
                            <img src="{{ asset('images/logoumb.jpg') }}" alt="Logo UMB" class="logo-umb">
                        </div>
                        <h3 class="fw-800 text-dark mb-1" style="letter-spacing: -1px;">Admin Panel</h3>
                        <p class="text-muted small">Sistem Pengaduan Sarpras UMB</p>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-4 small d-flex align-items-center animate__animated animate__shakeX">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                    @endif

                    <form method="POST" action="/admin/login">
                        @csrf

                        <div class="mb-3">
                            <label class="small fw-bold text-muted ms-1 mb-1">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold text-muted ms-1 mb-1">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                                <button type="button" class="btn btn-outline-secondary border-start-0" id="togglePassword">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login w-100 text-white mb-4">
                            Masuk Ke Dashboard <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>

                        <div class="text-center">
                            <a href="/" class="text-decoration-none small text-muted hover-primary">
                                <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </form>

                </div>
            </div>

            <div class="text-center mt-4 text-white-50 small animate__animated animate__fadeInUp">
                &copy; {{ date('Y') }} Universitas Muhammadiyah Bandung<br>
                <span style="font-size: 10px; opacity: 0.6;">Dukungan Teknis: IT Support UMB</span>
            </div>

        </div>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle icon
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>