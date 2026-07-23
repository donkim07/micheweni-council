<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Micheweni Waste Portal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .auth-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .auth-header {
            position: relative;
            padding: 2.5rem 1.5rem;
            text-align: center;
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: white;
        }
        .auth-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            right: 0;
            height: 30px;
            background: white;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        }
        .auth-logo {
            height: 70px;
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.2));
        }
        .auth-body {
            padding: 2rem;
        }
        .form-control, .btn {
            border-radius: 8px;
            padding: 10px 15px;
        }
        .btn-primary {
            background: linear-gradient(to right, #43cea2, #185a9d);
            border: none;
            font-weight: 600;
            padding: 12px 20px;
        }
        .link-secondary {
            color: #185a9d;
            text-decoration: none;
        }
        .link-secondary:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card auth-card">
                    <div class="auth-header">
                        <a href="/" class="d-block">
                            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="auth-logo img-fluid">
                        </a>
                        <h3 class="fw-bold mb-0">{{ config('app.name', 'Micheweni Waste Portal') }}</h3>
                    </div>
                    <div class="auth-body">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html> 