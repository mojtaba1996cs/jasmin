<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مفوضية العون الإنساني</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            direction: rtl;
            line-height: 1.7;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== شريط التنقل ===== */
        .navbar {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            padding: 12px 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(30, 58, 138, 0.08);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #0f2b5c, #1a4a8a);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon i {
            font-size: 1.4rem;
            color: #fff;
        }

        .logo-text h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f2b5c;
        }

        .logo-text span {
            font-size: 0.65rem;
            color: #64748b;
            display: block;
            margin-top: -2px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .nav-links a {
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.85rem;
            color: #334155;
            transition: 0.25s;
        }

        .nav-links a:hover {
            background: #f1f5f9;
            color: #0f2b5c;
        }

        .nav-links .btn-login {
            background: #0f2b5c;
            color: #fff;
            padding: 7px 20px;
            border-radius: 30px;
            font-weight: 600;
            transition: 0.3s;
        }

        .nav-links .btn-login:hover {
            background: #1a4a8a;
            transform: translateY(-2px);
        }

        /* ===== الهيدر ===== */
        .hero {
            background: linear-gradient(145deg, #0f2b5c 0%, #1a4a8a 70%, #2563eb 100%);
            color: #fff;
            padding: 50px 0 60px;
            border-radius: 0 0 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: "🤝";
            position: absolute;
            font-size: 200px;
            opacity: 0.06;
            bottom: -40px;
            left: -30px;
            pointer-events: none;
        }

        .hero h1 {
            font-size: 2.4rem;
            font-weight: 800;
            margin-bottom: 12px;
            position: relative;
            z-index: 2;
        }

        .hero h1 .highlight {
            color: #93c5fd;
        }
.hero p {
            font-size: 1.05rem;
            max-width: 580px;
            margin: 0 auto 20px;
            opacity: 0.92;
            position: relative;
            z-index: 2;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .hero-stat .number {
            font-size: 1.6rem;
            font-weight: 800;
            color: #93c5fd;
        }

        .hero-stat .label {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        /* ===== الرؤية والرسالة ===== */
        .vm-section {
            padding: 40px 0 25px;
        }

        .vm-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .vm-card {
            background: #fff;
            border-radius: 18px;
            padding: 25px 20px;
            text-align: center;
            box-shadow: 0 8px 25px -10px rgba(0, 0, 0, 0.06);
            border: 1px solid #eef2f6;
            transition: 0.3s;
        }

        .vm-card:hover {
            transform: translateY(-4px);
            border-color: #bfdbfe;
        }

        .vm-card .icon {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .vm-card h3 {
            font-size: 1.2rem;
            color: #0f2b5c;
            margin-bottom: 8px;
        }

        .vm-card p {
            color: #475569;
            font-size: 0.9rem;
        }

        /* ===== الأهداف ===== */
        .goals-section {
            padding: 40px 0;
            background: #f1f5f9;
        }

        .section-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-header .tag {
            display: inline-block;
            background: #dbeafe;
            color: #1a4a8a;
            padding: 4px 16px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .section-header h2 {
            font-size: 1.7rem;
            font-weight: 700;
            color: #0f2b5c;
        }

        .goals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }

        .goal-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px 18px;
            border-right: 4px solid #1a4a8a;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .goal-card:hover {
            transform: translateX(-3px);
            box-shadow: 0 8px 25px -8px rgba(15, 43, 92, 0.12);
        }

        .goal-card .icon {
            font-size: 1.4rem;
            margin-bottom: 8px;
        }

        .goal-card h4 {
            font-size: 1rem;
            color: #0f2b5c;
            margin-bottom: 4px;
        }

        .goal-card p {
            color: #475569;
            font-size: 0.85rem;
        }

        /* ===== الخدمات ===== */
        .services-section {
            padding: 40px 0;
            background: #fff;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-top: 25px;
        }

        .service-item {
            text-align: center;
            padding: 18px 12px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #eef2f6;
            transition: 0.3s;
        }

        .service-item:hover {
            background: #eff6ff;
            border-color: #93c5fd;
        }

        .service-item .icon {
            font-size: 1.5rem;
            margin-bottom: 6px;
        }

        .service-item h5 {
            font-size: 0.95rem;
            color: #0f2b5c;
        }
 .service-item p {
            font-size: 0.8rem;
            color: #64748b;
        }

        /* ===== زر الدخول ===== */
        .cta-section {
            padding: 40px 0;
            text-align: center;
            background: linear-gradient(135deg, #f8fafc, #eef2f7);
        }

        .cta-section h3 {
            font-size: 1.6rem;
            color: #0f2b5c;
            margin-bottom: 8px;
        }

        .cta-section p {
            color: #64748b;
            max-width: 450px;
            margin: 0 auto 20px;
        }

        .btn-cta {
            display: inline-block;
            background: #0f2b5c;
            color: #fff;
            padding: 12px 36px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            transition: 0.3s;
            box-shadow: 0 8px 24px -6px rgba(15, 43, 92, 0.3);
        }

        .btn-cta:hover {
            background: #1a4a8a;
            transform: translateY(-3px);
        }

        /* ===== الفوتر ===== */
        footer {
            background: #0f172a;
            color: #94a3b8;
            text-align: center;
            padding: 20px 0;
            font-size: 0.8rem;
        }

        footer .brand {
            color: #e2e8f0;
            font-weight: 600;
        }

        /* ===== استجابة ===== */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 1.8rem;
            }
            .hero-stats {
                gap: 15px;
            }
            .hero-stat .number {
                font-size: 1.2rem;
            }
            .navbar .container {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            .nav-links {
                justify-content: center;
            }
            .section-header h2 {
                font-size: 1.4rem;
            }
            .vm-grid {
                grid-template-columns: 1fr;
            }
            .goals-grid {
                grid-template-columns: 1fr;
            }
            .services-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 30px 0 40px;
            }
            .hero h1 {
                font-size: 1.4rem;
            }
            .hero p {
                font-size: 0.9rem;
            }
            .services-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- ===== شريط التنقل ===== -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <div class="logo-text">
                    <h2>مفوضية العون الإنساني</h2>
                    <span>Humanitarian Aid Commission</span>
                </div>
            </div>
            <div class="nav-links">
                <a href="#goals">الأهداف</a>
                <a href="#services">الخدمات</a>
                <a href="{{ route('login') }}" class="btn-login">
                    <i class="fas fa-arrow-left"></i> الدخول
                </a>
            </div>
        </div>
    </nav>

    <!-- ===== الهيدر ===== -->
    <section class="hero">
        <div class="container">
            <h1>
                مفوضية العون الإنساني<br>
                <span class="highlight">تنظيم وتنسيق العمل الإنساني</span>
            </h1>
            <p>
                الجهة الحكومية المسؤولة عن تنظيم العمل الإنساني والإشراف على المنظمات الوطنية والأجنبية في السودان.
            </p>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="number">+11.9K</div>
 <div class="label">منظمة مسجلة</div>
                </div>
                <div class="hero-stat">
                    <div class="number">12</div>
                    <div class="label">معبر إنساني</div>
                </div>
                <div class="hero-stat">
                    <div class="number">2006</div>
                    <div class="label">قانون تنظيم العمل الطوعي</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== الرؤية والرسالة ===== -->
    <section class="vm-section">
        <div class="container">
            <div class="vm-grid">
                <div class="vm-card">
                    <div class="icon">🌟</div>
                    <h3>رؤيتنا</h3>
                    <p>"عمل إنساني يقوده المجتمع ليحقق عزة وكرامة الأمة السودانية أمنًا ونماءً."</p>
                </div>
                <div class="vm-card">
                    <div class="icon">📜</div>
                    <h3>رسالتنا</h3>
                    <p>إدارة وتنظيم العمل الطوعي والإنساني، وترسيخ ثقافة التطوع، والمساهمة في إعمار وتنمية المناطق المتأثرة بالأزمات.</p>
                </div>
                <div class="vm-card">
                    <div class="icon"></div>
                    <h3>هدفنا العام</h3>
                    <p>تنظيم العمل الإنساني وتنسيق جهود المنظمات وتسهيل وصول المساعدات للمتضررين.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== الأهداف ===== -->
    <section class="goals-section" id="goals">
        <div class="container">
            <div class="section-header">
                <div class="tag"><i class="fas fa-bullseye"></i> أهدافنا</div>
                <h2>الأهداف الاستراتيجية</h2>
            </div>
            <div class="goals-grid">
                <div class="goal-card">
                    <div class="icon">📋</div>
                    <h4>تنظيم العمل الإنساني</h4>
                    <p>وضع السياسات وتنظيم العمل الإنساني داخل السودان.</p>
                </div>
                <div class="goal-card">
                    <div class="icon">🤝</div>
                    <h4>تنسيق المنظمات</h4>
                    <p>تنسيق جهود المنظمات المحلية والدولية وتوجيه المساعدات.</p>
                </div>
                <div class="goal-card">
                    <div class="icon">🛡️</div>
                    <h4>تسهيل المساعدات</h4>
                    <p>تسهيل دخول المساعدات وإدارة عمليات الطوارئ.</p>
                </div>
                <div class="goal-card">
                    <div class="icon">📊</div>
                    <h4>الإشراف والرقابة</h4>
                    <p>متابعة تنفيذ البرامج وضمان وصول المساعدات لمستحقيها.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== الخدمات ===== -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="section-header">
                <div class="tag"><i class="fas fa-tasks"></i> خدماتنا</div>
                <h2>الاختصاصات والخدمات</h2>
            </div>
            <div class="services-grid">
                <div class="service-item">
                    <div class="icon">📝</div>
                    <h5>تسجيل المنظمات</h5>
                    <p>تسجيل وتجديد المنظمات الوطنية والأجنبية</p>
                </div>
                <div class="service-item">
                    <div class="icon">🪪</div>
                    <h5>تصاريح الحركة</h5>
                    <p>إصدار تصاريح العمل والتأشيرات والإقامات</p>
                </div>
                <div class="service-item">
                    <div class="icon">📋</div>
                    <h5>الموافقات</h5>
                    <p>إصدار موافقات المشروعات الإنسانية</p>
                </div>
                <div class="service-item">
 <div class="icon">🤝</div>
                    <h5>التنسيق</h5>
                    <p>التنسيق مع الوزارات والجهات المانحة</p>
                </div>
                <div class="service-item">
                    <div class="icon">📚</div>
                    <h5>التدريب</h5>
                    <p>رفع الوعي والتدريب على إدارة الكوارث</p>
                </div>
                <div class="service-item">
                    <div class="icon">📊</div>
                    <h5>السياسات</h5>
                    <p>إعداد الخطط الإغاثية والمخزون الاستراتيجي</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== زر الدخول ===== -->
    <section class="cta-section">
        <div class="container">
            <h3> نظام الربط الإداري</h3>
            <p>بوابتك لإدارة العمل الإنساني بفعالية وشفافية</p>
            <a href="{{ route('login') }}" class="btn-cta">
                <i class="fas fa-arrow-left"></i> الدخول إلى النظام
            </a>
        </div>
    </section>

    <!-- ===== الفوتر ===== -->
    <footer>
        <div class="container">
            <p>
                <span class="brand">© 2026 مفوضية العون الإنساني – السودان</span>
                <br>
                نظام إلكتروني لتنظيم وتطوير العمل الإنساني
            </p>
        </div>
    </footer>

</body>
</html>