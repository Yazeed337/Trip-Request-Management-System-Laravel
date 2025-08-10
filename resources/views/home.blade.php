@extends('layouts.app')

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سَوَّاح - منصة التخطيط السياحي الذكية</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @push('styles')
    <style>
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
    </style>
@endpush
</head>
@section('content')
<body>
    <!-- Add this to your home view (welcome.blade.php) -->
<div class="modal fade" id="tripRequestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">طلب رحلة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" id="tripRequestAlert" style="display: none;">
                    <i class="fas fa-info-circle me-2"></i>يجب تسجيل الدخول لطلب رحلة
                </div>
                <form id="tripRequestForm">
                    @csrf
                    <input type="hidden" name="destination_id" id="selectedDestinationId">
                    <div class="mb-3">
                        <label class="form-label">الوجهة</label>
                        <input type="text" class="form-control" id="selectedDestinationName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تاريخ السفر</label>
                        <input type="date" class="form-control" name="travel_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">مدة الرحلة (أيام)</label>
                        <input type="number" class="form-control" name="duration_days" min="1" value="7" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">عدد المسافرين</label>
                        <input type="number" class="form-control" name="travelers_count" min="1" value="2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات إضافية</label>
                        <textarea class="form-control" rows="3" name="notes"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">إرسال الطلب</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- شريط التنقل 
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-compass fa-2x me-2"></i>
                <h1 class="h3 mb-0">سَوَّاح</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#home">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="#destinations">الوجهات</a></li>
                    <li class="nav-item"><a class="nav-link" href="#recommendation">اقترح وجهة</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">اتصل بنا</a></li>
                    <li class="nav-item ms-2">
                        <div id="userAuthSection">
                            <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-user me-2"></i>تسجيل الدخول
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav> -->

    <!-- قسم البطل -->
    <section class="hero-section" id="home">
        <div class="container text-center">
            <h1 class="hero-title display-3 fw-bold mb-4">خطط رحلتك السياحية بذكاء وسهولة</h1>
            <p class="lead mb-5">استكشف العالم مع "سَوَّاح" - منصة السياحة الذكية التي تجعل التخطيط لرحلتك تجربة ممتعة</p>
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <a href="#destinations" class="btn btn-light btn-lg px-4 py-2 fw-bold">
                    <i class="fas fa-globe-asia me-2"></i>اكتشف الوجهات
                </a>
                <button class="btn btn-accent btn-lg px-4 py-2 fw-bold" onclick="scrollToRecommendation()">
                    <i class="fas fa-magic me-2"></i>اقترح لي وجهة
                </button>
            </div>
        </div>
    </section>

    <!-- الميزات الرئيسية -->
    <section class="py-5 bg-light animated-section">
        <div class="container">
            <h2 class="section-title">كيف تعمل منصة "سَوَّاح"؟</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="icon-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-4">
                                <i class="fas fa-search fa-2x"></i>
                            </div>
                            <h3 class="h5 mb-3">اكتشف الوجهات</h3>
                            <p class="text-muted">تصفح مئات الوجهات السياحية حول العالم مع تفاصيل كاملة عن كل مكان</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="icon-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-4">
                                <i class="fas fa-coins fa-2x"></i>
                            </div>
                            <h3 class="h5 mb-3">حاسبة الميزانية</h3>
                            <p class="text-muted">احسب تكاليف رحلتك بدقة مع مراعاة أسعار العملات والخدمات المحلية</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="icon-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-4">
                                <i class="fas fa-lightbulb fa-2x"></i>
                            </div>
                            <h3 class="h5 mb-3">اقتراح ذكي</h3>
                            <p class="text-muted">دع منصتنا الذكية تقترح عليك أفضل الوجهات المناسبة لتفضيلاتك وميزانيتك</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- الوجهات الشعبية -->
    <section id="destinations" class="py-5 animated-section">
        <div class="container">
            <h2 class="section-title">الوجهات السياحية الشعبية</h2>
            <div class="row g-4" id="destinationsContainer">
               @foreach($popularDestinations as $destination)
<div class="col-md-4">
    <div class="country-card card border-0 h-100">
        <img src="{{ $destination->image_url }}" class="card-img-top" alt="{{ $destination->name_ar }}" height="200">
        <div class="card-body">
            <!-- ... existing card content ... -->
            <div class="d-flex justify-content-between">
                <button class="btn btn-sm btn-outline-primary">المعالم السياحية</button>
                <button class="btn btn-sm btn-outline-primary">الفنادق</button>
                
                <!-- Add trip request button -->
                <button class="btn btn-sm btn-primary trip-request-btn" 
                        data-destination-id="{{ $destination->id }}" 
                        data-destination-name="{{ $destination->name_ar }}">
                    طلب رحلة
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach
            </div>
            
            <div class="text-center mt-4">
                <button class="btn btn-primary px-4" id="loadMoreDestinations">
                    <i class="fas fa-globe-americas me-2"></i>اكتشف المزيد من الوجهات
                </button>
            </div>
        </div>
    </section>

    <!-- نظام الاقتراح الذكي -->
    <section id="recommendation" class="py-5 bg-light animated-section">
        <div class="container">
            <h2 class="section-title">اقترح لي وجهة سياحية</h2>
            <p class="text-center text-muted mb-5">أجب على الأسئلة التالية ودع نظامنا الذكي يقترح لك أفضل الوجهات المناسبة لتفضيلاتك</p>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="recommendation-card card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            <form id="recommendationForm">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label fw-bold">ما هي ميزانيتك اليومية المتوقعة؟</label>
                                    <div class="d-flex align-items-center">
                                        <input type="range" class="form-range" min="100" max="1000" step="50" id="budgetSlider" value="500">
                                        <span class="ms-3" id="budgetValue">500 ريال</span>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">في أي شهر تخطط للسفر؟</label>
                                    <select class="form-select" name="travel_month" required>
                                        <option value="">اختر شهر السفر</option>
                                        <option value="يناير">يناير</option>
                                        <option value="فبراير">فبراير</option>
                                        <option value="مارس">مارس</option>
                                        <option value="أبريل">أبريل</option>
                                        <option value="مايو">مايو</option>
                                        <option value="يونيو">يونيو</option>
                                        <option value="يوليو">يوليو</option>
                                        <option value="أغسطس">أغسطس</option>
                                        <option value="سبتمبر">سبتمبر</option>
                                        <option value="أكتوبر">أكتوبر</option>
                                        <option value="نوفمبر">نوفمبر</option>
                                        <option value="ديسمبر">ديسمبر</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">ما هو نوع الطقس المفضل لديك؟</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="weather_preference" id="weather1" value="دافئ ومشمس" required>
                                            <label class="form-check-label" for="weather1">دافئ ومشمس</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="weather_preference" id="weather2" value="بارد وثلجي" required>
                                            <label class="form-check-label" for="weather2">بارد وثلجي</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="weather_preference" id="weather3" value="معتدل" required>
                                            <label class="form-check-label" for="weather3">معتدل</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="weather_preference" id="weather4" value="لا يهمني" required>
                                            <label class="form-check-label" for="weather4">لا يهمني</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">ما هو نوع الرحلة التي تبحث عنها؟</label>
                                    <select class="form-select" name="trip_type" required>
                                        <option value="">اختر نوع الرحلة</option>
                                        <option value="عائلية">عائلية</option>
                                        <option value="رومانسية">رومانسية</option>
                                        <option value="مغامرة">مغامرة</option>
                                        <option value="استجمام">استجمام</option>
                                        <option value="ثقافية">ثقافية</option>
                                        <option value="تسوق">تسوق</option>
                                    </select>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-accent px-5 py-2">
                                        <i class="fas fa-magic me-2"></i>اقترح وجهة
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- نتائج الاقتراحات -->
            <div id="recommendationResults" class="mt-5" style="display: none;">
                <h3 class="text-center mb-4">الوجهات المقترحة لك</h3>
                <div id="recommendedDestinations" class="row g-4"></div>
            </div>
        </div>
    </section>

    <!-- اتصل بنا -->
    <section id="contact" class="py-5 bg-light animated-section">
        <div class="container">
            <h2 class="section-title">تواصل معنا</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="h5 mb-4">أرسل استفسارك</h3>
                            <form id="contactForm" action="/contact" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">الاسم</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">الموضوع</label>
                                    <input type="text" class="form-control" name="subject" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">الرسالة</label>
                                    <textarea class="form-control" rows="4" name="message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">إرسال الرسالة</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="h5 mb-4">معلومات التواصل</h3>
                            <div class="d-flex align-items-start mb-4">
                                <div class="icon-circle-sm bg-primary text-white d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h4 class="h6 mb-1">العنوان</h4>
                                    <p class="text-muted mb-0">الرياض، المملكة العربية السعودية</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-4">
                                <div class="icon-circle-sm bg-primary text-white d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <h4 class="h6 mb-1">الهاتف</h4>
                                    <p class="text-muted mb-0">+966 11 123 4567</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-4">
                                <div class="icon-circle-sm bg-primary text-white d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h4 class="h6 mb-1">البريد الإلكتروني</h4>
                                    <p class="text-muted mb-0">info@sawwah-travel.com</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="icon-circle-sm bg-primary text-white d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h4 class="h6 mb-1">ساعات العمل</h4>
                                    <p class="text-muted mb-0">الأحد - الخميس: 8 صباحاً - 5 مساءً</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- التذييل -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h3 class="text-white mb-4">سَوَّاح</h3>
                    <p>منصة سياحية مبتكرة تساعدك على التخطيط لرحلاتك بسهولة وذكاء. اكتشف العالم مع أفضل الأدوات والمعلومات.</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h4 class="text-white mb-4">روابط سريعة</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home" class="text-white text-decoration-none">الرئيسية</a></li>
                        <li class="mb-2"><a href="#destinations" class="text-white text-decoration-none">الوجهات</a></li>
                        <li class="mb-2"><a href="#recommendation" class="text-white text-decoration-none">اقترح وجهة</a></li>
                        <li><a href="#contact" class="text-white text-decoration-none">اتصل بنا</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="text-white mb-4">الوجهات الشعبية</h4>
                    <ul class="list-unstyled">
                        @foreach($popularDestinations->take(5) as $destination)
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">{{ $destination->name_ar }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="text-white mb-4">النشرة البريدية</h4>
                    <p>اشترك ليصلك كل جديد عن العروض والوجهات السياحية</p>
                    <form id="newsletterForm">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="بريدك الإلكتروني" name="email" required>
                            <button class="btn btn-accent" type="submit">اشتراك</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center py-3">
                <p class="mb-0">© {{ date('Y') }} سَوَّاح. جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>

    <!-- نافذة تسجيل الدخول -->
    <div class="modal fade login-modal" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تسجيل الدخول</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember">تذكرني</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="mb-0">ليس لديك حساب؟ <a href="#" class="text-primary" id="showRegister">سجل الآن</a></p>
                        <p><a href="#" class="text-primary">نسيت كلمة المرور؟</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نافذة التسجيل -->
    <div class="modal fade login-modal" id="registerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إنشاء حساب جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">الاسم الكامل</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">تسجيل حساب جديد</button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="mb-0">لديك حساب بالفعل؟ <a href="#" class="text-primary" id="showLogin">تسجيل الدخول</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نافذة طلب رحلة -->
    <div class="modal fade" id="tripRequestModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">طلب رحلة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" id="tripRequestAlert">
                        <i class="fas fa-info-circle me-2"></i>يجب تسجيل الدخول لطلب رحلة
                    </div>
                    <form id="tripRequestForm" style="display: none;">
                        @csrf
                        <input type="hidden" name="destination_id" id="selectedDestinationId">
                        <div class="mb-3">
                            <label class="form-label">الوجهة</label>
                            <input type="text" class="form-control" id="selectedDestinationName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">تاريخ السفر</label>
                            <input type="date" class="form-control" name="travel_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">مدة الرحلة (أيام)</label>
                            <input type="number" class="form-control" name="duration_days" min="1" value="7" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">عدد المسافرين</label>
                            <input type="number" class="form-control" name="travelers_count" min="1" value="2" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ملاحظات إضافية</label>
                            <textarea class="form-control" rows="3" name="notes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">إرسال الطلب</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Global variables
        let currentUser = null;
        let allDestinations = [];
        
        // DOM Elements
        const userAuthSection = document.getElementById('userAuthSection');
        const budgetSlider = document.getElementById('budgetSlider');
        const budgetValue = document.getElementById('budgetValue');
        
        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            checkAuthStatus();
            setupEventListeners();
        });
        // Add this to your home view's script section
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('trip-request-btn')) {
        const destinationId = e.target.getAttribute('data-destination-id');
        const destinationName = e.target.getAttribute('data-destination-name');
        openTripRequestModal(destinationId, destinationName);
    }
});

function openTripRequestModal(destinationId, destinationName) {
    document.getElementById('selectedDestinationId').value = destinationId;
    document.getElementById('selectedDestinationName').value = destinationName;
    
    const modal = new bootstrap.Modal(document.getElementById('tripRequestModal'));
    
    // Check if user is logged in
    if (!currentUser) {
        document.getElementById('tripRequestForm').style.display = 'none';
        document.getElementById('tripRequestAlert').style.display = 'block';
    } else {
        document.getElementById('tripRequestForm').style.display = 'block';
        document.getElementById('tripRequestAlert').style.display = 'none';
    }
    
    modal.show();
}

// Handle trip request submission
async function handleTripRequest(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
    
    try {
        const response = await fetch('{{ route("trip-requests.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', data.message);
            form.reset();
            bootstrap.Modal.getInstance(document.getElementById('tripRequestModal')).hide();
        } else {
            showAlert('danger', data.message || 'حدث خطأ أثناء إرسال الطلب');
        }
    } catch (error) {
        console.error('Trip request error:', error);
        showAlert('danger', 'حدث خطأ في الاتصال. الرجاء المحاولة مرة أخرى.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
}

// Add event listener for the form
document.getElementById('tripRequestForm').addEventListener('submit', handleTripRequest);
        // Check authentication status
        function checkAuthStatus() {
            fetch('{{ route("user.info") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                credentials: 'include' // Important for session cookies
            })
            .then(response => {
                if (response.status === 401) return null;
                return response.json();
            })
            .then(data => {
                if (data && data.success) {
                    currentUser = data.user;
                    updateUserInterface();
                }
            })
            .catch(error => console.log('User not authenticated'));
        }

        // Setup event listeners
        function setupEventListeners() {
            // Budget slider
            budgetSlider.addEventListener('input', function() {
                budgetValue.textContent = this.value + ' ريال';
            });

            // Login form
            document.getElementById('loginForm').addEventListener('submit', handleLogin);
            
            // Register form
            document.getElementById('registerForm').addEventListener('submit', handleRegister);
            
            // Contact form
            document.getElementById('contactForm').addEventListener('submit', handleContactSubmit);
            
            // Recommendation form
            document.getElementById('recommendationForm').addEventListener('submit', handleRecommendationSubmit);
            
            // Trip request form
            document.getElementById('tripRequestForm')?.addEventListener('submit', handleTripRequest);

            // Modal switching
            document.getElementById('showRegister')?.addEventListener('click', function(e) {
                e.preventDefault();
                bootstrap.Modal.getInstance(document.getElementById('loginModal')).hide();
                new bootstrap.Modal(document.getElementById('registerModal')).show();
            });

            document.getElementById('showLogin')?.addEventListener('click', function(e) {
                e.preventDefault();
                bootstrap.Modal.getInstance(document.getElementById('registerModal')).hide();
                new bootstrap.Modal(document.getElementById('loginModal')).show();
            });

            // Trip request buttons
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('trip-request-btn')) {
                    const destinationId = e.target.getAttribute('data-destination-id');
                    const destinationName = e.target.getAttribute('data-destination-name');
                    openTripRequestModal(destinationId, destinationName);
                }
            });
        }

        // Get CSRF token
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }
       async function handleContactSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    
    try {
        const response = await fetch(form.action, {  // Use form's action attribute
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', data.message);
            form.reset();
        } else {
            let errorMessage = data.message || 'حدث خطأ أثناء إرسال الرسالة';
            if (data.errors) {
                // Format validation errors
                errorMessage = Object.values(data.errors)
                    .flat()
                    .map(error => `<div>${error}</div>`)
                    .join('');
            }
            showAlert('danger', errorMessage);
        }
    } catch (error) {
        console.error('Contact form error:', error);
        showAlert('danger', 'حدث خطأ في الاتصال. الرجاء المحاولة مرة أخرى.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
}
        // Handle trip request submission
async function handleTripRequest(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
    
    try {
        const response = await fetch('{{ route("trip-requests.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            credentials: 'include'
        });
        
        const data = await response.json();
        
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('tripRequestModal')).hide();
            showAlert('success', data.message);
            form.reset();
        } else {
            showAlert('danger', data.message || 'حدث خطأ أثناء إرسال الطلب');
        }
    } catch (error) {
        console.error('Trip request error:', error);
        showAlert('danger', 'حدث خطأ في الاتصال. الرجاء المحاولة مرة أخرى.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
}
        // Handle login
        async function handleLogin(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري المعالجة...';
            
            try {
                const response = await fetch('{{ route("login") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                    credentials: 'include'
                });
                
                const data = await response.json();
                
                if (data.success) {
                    currentUser = data.user;
                    updateUserInterface();
                    bootstrap.Modal.getInstance(document.getElementById('loginModal')).hide();
                    showAlert('success', data.message);
                    
                    // Show admin panel if user is admin
                    if (data.user.is_admin) {
                        setTimeout(() => {
                            window.location.href = '/admin/dashboard';
                        }, 1000);
                    }
                } else {
                    let errorMessage = data.message || 'بيانات الدخول غير صحيحة';
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).join('<br>');
                    }
                    showAlert('danger', errorMessage);
                }
            } catch (error) {
                console.error('Login error:', error);
                showAlert('danger', 'حدث خطأ في الاتصال. الرجاء المحاولة مرة أخرى.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }

        // Handle registration
        async function handleRegister(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التسجيل...';
            
            try {
                const response = await fetch('{{ route("register") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                    credentials: 'include'
                });
                
                const data = await response.json();
                
                if (data.success) {
                    currentUser = data.user;
                    updateUserInterface();
                    bootstrap.Modal.getInstance(document.getElementById('registerModal')).hide();
                    showAlert('success', data.message);
                } else {
                    let errorMessage = data.message || 'حدث خطأ أثناء التسجيل';
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('<br>');
                    }
                    showAlert('danger', errorMessage);
                }
            } catch (error) {
                console.error('Registration error:', error);
                showAlert('danger', 'حدث خطأ في الاتصال. الرجاء المحاولة مرة أخرى.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }

        // Update UI based on authentication state
        function updateUserInterface() {
            if (currentUser) {
                userAuthSection.innerHTML = `
                    <div class="d-flex align-items-center">
                        <span class="user-info">
                            <i class="fas fa-user me-2"></i>${currentUser.name}
                        </span>
                        <button class="btn btn-outline-light" onclick="handleLogout()">
                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                        </button>
                        ${currentUser.is_admin ? 
                        `<a href="/admin/dashboard" class="btn btn-light ms-2">
                            <i class="fas fa-cog me-2"></i>لوحة التحكم
                        </a>` : ''}
                    </div>
                `;
                
                // Enable trip request form
                if (document.getElementById('tripRequestForm')) {
                    document.getElementById('tripRequestForm').style.display = 'block';
                    document.getElementById('tripRequestAlert').style.display = 'none';
                }
            } else {
                userAuthSection.innerHTML = `
                    <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-user me-2"></i>تسجيل الدخول
                    </button>
                `;
                
                // Disable trip request form
                if (document.getElementById('tripRequestForm')) {
                    document.getElementById('tripRequestForm').style.display = 'none';
                    document.getElementById('tripRequestAlert').style.display = 'block';
                }
            }
        }

        // Handle logout
        async function handleLogout() {
            try {
                const response = await fetch('{{ route("logout") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                    credentials: 'include'
                });
                
                const data = await response.json();
                
                if (data.success) {
                    currentUser = null;
                    updateUserInterface();
                    showAlert('success', data.message);
                }
            } catch (error) {
                console.error('Logout error:', error);
                showAlert('danger', 'حدث خطأ أثناء تسجيل الخروج');
            }
        }

        // Show alert message
function showAlert(type, message) {
    // Remove any existing alerts first
    document.querySelectorAll('.global-alert').forEach(el => el.remove());
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show global-alert position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.style.zIndex = '9999';
    alertDiv.style.maxWidth = '90%';
    
    // Check if message contains HTML tags
    const containsHtml = /<[a-z][\s\S]*>/i.test(message);
    
    if (containsHtml) {
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <div>${message}</div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    } else {
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <div>${message}</div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }
    
    document.body.appendChild(alertDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 5000);
}

        // Smooth scroll to recommendation section
        function scrollToRecommendation() {
            document.getElementById('recommendation').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Load more destinations
        document.getElementById('loadMoreDestinations').addEventListener('click', function() {
            // This would typically load more destinations from the server
            showAlert('info', 'سيتم إضافة المزيد من الوجهات قريباً!');
        });
    </script>
    @endpush
</body>
@endsection
</html>