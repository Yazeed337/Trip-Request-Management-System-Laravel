<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'سَوَّاح - منصة التخطيط السياحي الذكية')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Add your global styles here */
                :root {
            --primary-color: #2a5d67;
            --secondary-color: #5ab1bb;
            --accent-color: #ff7e5f;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
        }
        
        .navbar {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .hero-section {
            background: linear-gradient(rgba(42, 93, 103, 0.8), rgba(42, 93, 103, 0.8)), url('https://images.unsplash.com/photo-1503220317375-aaad61436b1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            height: 80vh;
            color: white;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .feature-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 15px;
            overflow: hidden;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .country-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .country-card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .recommendation-card {
            background: linear-gradient(135deg, #fff, #f8f9fa);
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 16px rgba(0,0,0,0.05);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #1d4a52;
            border-color: #1d4a52;
        }
        
        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
        }
        
        .btn-accent:hover {
            background-color: #e86a4a;
            border-color: #e86a4a;
            color: white;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--secondary-color);
            border-radius: 2px;
        }
        
        .footer {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 50px 0 20px;
        }
        
        .login-modal .modal-content {
            border-radius: 20px;
            overflow: hidden;
        }
        
        .login-modal .modal-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
        }
        
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }
        
        .icon-circle-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        
        .user-info {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 5px 15px;
            display: inline-flex;
            align-items: center;
            margin-left: 15px;
        }
        
        .user-info i {
            margin-left: 8px;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                height: 60vh;
            }
            
            .hero-title {
                font-size: 2rem;
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animated-section {
            animation: fadeIn 0.8s ease-out forwards;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #343a40;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.navbar')
    
    <main class="py-4">
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>