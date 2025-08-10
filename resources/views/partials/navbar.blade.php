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
    </nav> 