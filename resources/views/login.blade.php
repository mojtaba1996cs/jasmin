<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - مفوضية العون الإنساني</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            direction: rtl;
            position: relative;
            overflow: hidden;
        }

        /* خلفية متحركة */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0b2b40 0%, #1a4b6d 50%, #0f3448 100%);
            z-index: -2;
        }

        .bg-animation::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 70%, rgba(234, 179, 8, 0.15) 0%, transparent 50%);
            animation: pulse 15s ease-in-out infinite;
        }

        .bg-animation::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 70% 30%, rgba(11, 43, 64, 0.3) 0%, transparent 50%);
            animation: pulse 18s ease-in-out infinite reverse;
        }

        @keyframes pulse {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.5; }
            50% { transform: translate(-5%, -5%) scale(1.1); opacity: 0.8; }
        }

        /* حاوية تسجيل الدخول */
        .login-wrapper {
            width: 100%;
            max-width: 480px;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* البطاقة الزجاجية */
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(234, 179, 8, 0.1);
            overflow: hidden;
        }

        /* هيدر البطاقة */
        .login-header {
            padding: 40px 35px 25px;
            text-align: center;
            background: linear-gradient(180deg, rgba(11, 43, 64, 0.03) 0%, transparent 100%);
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #0b2b40 0%, #1a4b6d 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 15px 30px rgba(11, 43, 64, 0.3);
            transform: rotate(0deg);
            transition: transform 0.3s;
        }

        .logo-icon:hover {
            transform: rotate(5deg) scale(1.02);
        }

        .logo-icon i {
            font-size: 42px;
            color: #eab308;
        }

        .login-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: #0b2b40;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: #64748b;
            font-size: 15px;
            font-weight: 500;
        }

        /* جسم البطاقة */
        .login-body {
            padding: 10px 35px 40px;
        }

        /* رسائل الخطأ */
        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            border-right: 4px solid #dc2626;
        }

        /* مجموعات الحقول */
        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #1e293b;
            font-size: 15px;
        }

        .form-group label i {
            margin-left: 8px;
            color: #eab308;
            width: 18px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            transition: color 0.2s;
            pointer-events: none;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 16px 45px 16px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            font-size: 15px;
            transition: all 0.2s;
            background: #fafcfc;
            color: #1e293b;
        }

        .form-group select {
            padding: 16px 18px;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%230b2b40' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: left 18px center;
            background-size: 16px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #0b2b40;
            background: white;
            box-shadow: 0 0 0 4px rgba(11, 43, 64, 0.08);
        }

        .form-group input:focus + i,
        .form-group select:focus + i {
            color: #0b2b40;
        }

        /* زر الدخول */
        .btn-login {
            width: 100%;
            padding: 17px;
            background: linear-gradient(135deg, #0b2b40 0%, #1a4b6d 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(11, 43, 64, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(11, 43, 64, 0.4);
        }

        .btn-login:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-login i {
            position: relative;
            z-index: 1;
        }

        .btn-login span {
            position: relative;
            z-index: 1;
        }

        /* تذييل البطاقة */
        .login-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .login-footer i {
            color: #eab308;
        }

        /* تأثيرات إضافية */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .shape {
            position: absolute;
            background: rgba(234, 179, 8, 0.08);
            border-radius: 50%;
            animation: float 20s infinite;
        }

        .shape:nth-child(1) { width: 300px; height: 300px; top: -100px; right: -100px; }
        .shape:nth-child(2) { width: 200px; height: 200px; bottom: -50px; left: -50px; animation-delay: -5s; }
        .shape:nth-child(3) { width: 150px; height: 150px; top: 50%; left: 10%; animation-delay: -10s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        /* تجاوب مع الجوال */
        @media (max-width: 500px) {
            .login-header { padding: 30px 25px 20px; }
            .login-body { padding: 5px 25px 30px; }
            .logo-icon { width: 70px; height: 70px; }
            .logo-icon i { font-size: 36px; }
            .login-header h2 { font-size: 24px; }
        }
    </style>
</head>
<body>

{{-- خلفية متحركة --}}
<div class="bg-animation"></div>

{{-- أشكال عائمة --}}
<div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
</div>

{{-- حاوية تسجيل الدخول --}}
<div class="login-wrapper">
    <div class="login-card">
        
        {{-- هيدر البطاقة --}}
        <div class="login-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="fas fa-hands-helping"></i>
                </div>
            </div>
            <h2>مفوضية العون الإنساني</h2>
            <p>نظام إدارة المستندات والمكاتب</p>
        </div>

        {{-- جسم البطاقة --}}
        <div class="login-body">
            
            {{-- رسائل الخطأ --}}
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- نموذج تسجيل الدخول --}}
            <form method="POST" action="{{ url('/login') }}">
                @csrf

                {{-- البريد الإلكتروني --}}
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        البريد الإلكتروني
                    </label>
                    <div class="input-wrapper">
                        <input type="email" name="email" id="email" 
                               value="{{ old('email') }}" 
                               placeholder="example@hac.sd" 
                               required autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                {{-- كلمة المرور --}}
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                        كلمة المرور
                    </label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" 
                               placeholder="••••••••" 
                               required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                {{-- اختيار المكتب --}}
                <div class="form-group">
                    <label for="office_id">
                        <i class="fas fa-building"></i>
                     
                {{-- زر الدخول --}}
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>دخول</span>
                </button>
            </form>

            {{-- تذييل البطاقة --}}
            <div class="login-footer">
                <i class="fas fa-shield-alt"></i>
                <span>نظام مؤمن - مفوضية العون الإنساني</span>
                <i class="fas fa-lock"></i>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript للتأثيرات الإضافية --}}
<script>
    // تأثير تركيز على أول حقل
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.focus();
        }
    });
</script>

</body>
</html>