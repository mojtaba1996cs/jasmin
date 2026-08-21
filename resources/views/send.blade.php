@php
    use App\Models\Office;
    $user = auth()->user();
    $offices = Office::where('id', '!=', $user->office_id)->get();
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إرسال مستند - مفوضية العون الإنساني</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f1f5f9;
            direction: rtl;
            display: flex;
            min-height: 100vh;
        }

        /* ========== الشريط الجانبي ========== */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #0b2b40 0%, #0f3448 100%);
            color: white;
            padding: 25px 15px;
            position: fixed;
            right: 0;
            top: 0;
            bottom: 0;
            box-shadow: -2px 0 15px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .sidebar h3 {
            padding: 0 10px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar h3 i {
            color: #eab308;
        }

        .user-profile {
            background: rgba(255,255,255,0.08);
            padding: 18px 15px;
            border-radius: 14px;
            margin-bottom: 25px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: #eab308;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .user-avatar i {
            font-size: 24px;
            color: #0b2b40;
        }

        .user-info h4 {
            font-size: 16px;
            margin-bottom: 6px;
        }

        .user-info p {
            font-size: 13px;
            opacity: 0.85;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 18px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 5px;
            transition: all 0.25s;
            font-weight: 500;
            font-size: 15px;
        }

        .sidebar a i {
            width: 22px;
            text-align: center;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar a.active {
            background: #eab308;
            color: #0b2b40;
            font-weight: 600;
        }

        .sidebar a.logout {
            margin-top: 20px;
            color: #fca5a5;
        }

        .sidebar a.logout:hover {
            background: rgba(220,38,38,0.2);
        }

        /* ========== المحتوى الرئيسي ========== */
        .main-content {
            flex: 1;
            margin-right: 260px;
            padding: 30px 35px;
        }

        /* ========== الهيدر ========== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 28px;
            color: #0b2b40;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h1 i {
            color: #eab308;
            font-size: 30px;
        }

        .breadcrumb {
            color: #64748b;
            font-size: 14px;
        }

        .breadcrumb a {
            color: #0b2b40;
            text-decoration: none;
        }

        /* ========== بطاقة النموذج ========== */
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.03);
            max-width: 750px;
            margin: 0 auto;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 30px;
            padding-bottom: 22px;
            border-bottom: 2px solid #e2e8f0;
        }

        .form-header i {
            font-size: 36px;
            color: #eab308;
            background: #fef9c3;
            padding: 14px;
            border-radius: 16px;
        }

        .form-header h2 {
            font-size: 24px;
            color: #0b2b40;
        }

        .form-header p {
            color: #64748b;
            font-size: 14px;
            margin-top: 5px;
        }

        /* ========== التنبيهات ========== */
        .alert {
            padding: 16px 20px;
            border-radius: 14px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-right: 4px solid #16a34a;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            border-right: 4px solid #dc2626;
        }

        .office-badge {
            background: #e0f2fe;
            color: #0b2b40;
            padding: 14px 20px;
            border-radius: 14px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .office-badge i {
            color: #eab308;
            font-size: 20px;
        }

        /* ========== النموذج ========== */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .form-group {
            margin-bottom: 5px;
        }

        .form-group.full-width {
            grid-column: span 2;
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
            color: #0b2b40;
            width: 18px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 15px;
            transition: all 0.2s;
            background: #fafcfc;
            font-family: inherit;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #0b2b40;
            background: white;
            box-shadow: 0 0 0 4px rgba(11,43,64,0.08);
        }

        /* ========== رفع الملف ========== */
        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 28px;
            text-align: center;
            background: #fafcfc;
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-upload-area:hover {
            border-color: #0b2b40;
            background: #f0f9ff;
        }

        .file-upload-area i {
            font-size: 40px;
            color: #0b2b40;
            margin-bottom: 15px;
        }

        .file-upload-area p {
            color: #64748b;
            margin-bottom: 8px;
        }

        .file-upload-area .file-name {
            color: #0b2b40;
            font-weight: 600;
        }

        .file-upload-area input {
            display: none;
        }

        /* ========== أزرار ========== */
        .btn-submit {
            width: 100%;
            padding: 18px;
            background: #0b2b40;
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-submit i {
            font-size: 18px;
        }

        .btn-submit:hover {
            background: #1a4b6d;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(11,43,64,0.2);
        }

        /* ========== للجوال ========== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                z-index: 1000;
            }
            .main-content {
                margin-right: 0;
                padding: 20px;
            }
            .form-card {
                padding: 25px 20px;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-group.full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>

{{-- ========== الشريط الجانبي ========== --}}
<div class="sidebar">
    <h3>
        <i class="fas fa-hands-helping"></i>
        مفوضية العون الانساني
    </h3>

    <div class="user-profile">
        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-info">
            <h4>{{ $user->name }}</h4>
            <p><i class="fas fa-building"></i> {{ $user->Office->name ?? 'غير محدد' }}</p>
            <p><i class="fas fa-tag"></i> {{ $user->Role->name ?? 'غير محدد' }}</p>
        </div>
    </div>

    <a href="{{ url('/dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        الرئيسية
    </a>
    <a href="{{ url('/incoming') }}">
        <i class="fas fa-inbox"></i>
        الواردة
    </a>
    <a href="{{ url('/send-document') }}" class="active">
        <i class="fas fa-paper-plane"></i>
        إرسال مستند
    </a>
    <a href="{{ url('/archives') }}">
        <i class="fas fa-archive"></i>
        الأرشيف
    </a>
    @if($user->role_id == 1)
    <a href="{{ url('/admin/users') }}">
        <i class="fas fa-users-cog"></i>
        إدارة المستخدمين
    </a>
    @endif
    <a href="{{ url('/logout') }}" class="logout">
        <i class="fas fa-sign-out-alt"></i>
        خروج
    </a>
</div>

{{-- ========== المحتوى الرئيسي ========== --}}
<div class="main-content">
    <div class="page-header">
        <h1>
            <i class="fas fa-paper-plane"></i>
            إرسال مستند
        </h1>
        <div class="breadcrumb">
            <a href="{{ url('/dashboard') }}">الرئيسية</a> /
            <span>إرسال مستند</span>
        </div>
    </div>

    <div class="form-card">
        <div class="form-header">
            <i class="fas fa-file-export"></i>
            <div>
                <h2>إرسال مستند جديد</h2>
                <p>قم بتعبئة البيانات التالية لإرسال المستند إلى مكتب آخر</p>
            </div>
        </div>

        {{-- رسائل التنبيه --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin: 0; padding-right: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- المكتب الحالي --}}
        <div class="office-badge">
            <i class="fas fa-building"></i>
            <span>ترسل من مكتب: <strong>{{ $user->Office->name }}</strong></span>
        </div>

        {{-- نموذج الإرسال --}}
        <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                {{-- عنوان المستند --}}
                <div class="form-group full-width">
                    <label for="title">
                        <i class="fas fa-heading"></i>
                        عنوان المستند <span style="color: #dc2626;">*</span>
                    </label>
                    <input type="text" name="title" id="title" 
                           value="{{ old('title') }}" 
                           placeholder="مثال: تقرير شهري - يناير 2026" 
                           required>
                </div>

                {{-- رقم المستند --}}
                <div class="form-group">
                    <label for="doc_number">
                        <i class="fas fa-hashtag"></i>
                        رقم المستند
                    </label>
                    <input type="text" name="doc_number" id="doc_number" 
                           value="{{ old('doc_number') }}" 
                           placeholder="مثال: DOC-2026-001">
                </div>

                {{-- وصف المستند --}}
                <div class="form-group">
                    <label for="description">
                        <i class="fas fa-align-left"></i>
                        وصف المستند
                    </label>
                    <input type="text" name="description" id="description" 
                           value="{{ old('description') }}" 
                           placeholder="وصف مختصر للمستند">
                </div>

                {{-- إرسال إلى مكتب --}}
                <div class="form-group full-width">
                    <label for="to_office_id">
                        <i class="fas fa-building"></i>
                        إرسال إلى مكتب <span style="color: #dc2626;">*</span>
                    </label>
                    <select name="to_office_id" id="to_office_id" required>
                        <option value="">-- اختر المكتب المرسل إليه --</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" {{ old('to_office_id') == $office->id ? 'selected' : '' }}>
                                {{ $office->name }} ({{ $office->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- إرفاق مستند --}}
                <div class="form-group full-width">
                    <label>
                        <i class="fas fa-file"></i>
                        إرفاق مستند <span style="color: #dc2626;">*</span>
                    </label>
                    <div class="file-upload-area" onclick="document.getElementById('file').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>اضغط لاختيار ملف أو اسحب وأفلت هنا</p>
                        <p class="file-name" id="file-name">لم يتم اختيار ملف</p>
                        <p style="font-size: 12px; margin-top: 12px; opacity: 0.7;">
                            <i class="fas fa-info-circle"></i>
                            الصيغ المدعومة: PDF, DOC, DOCX, JPG, PNG (الحد الأقصى 10MB)
                        </p>
                    </div>
                    <input type="file" name="file" id="file" 
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" 
                           required style="display: none;">
                </div>
            </div>

            {{-- زر الإرسال --}}
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i>
                إرسال المستند
            </button>
        </form>
    </div>
</div>

{{-- JavaScript --}}
<script>
    // عرض اسم الملف المختار
    document.getElementById('file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'لم يتم اختيار ملف';
        document.getElementById('file-name').textContent = fileName;
    });

    // السحب والإفلات
    const dropZone = document.querySelector('.file-upload-area');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.style.borderColor = '#0b2b40');
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.style.borderColor = '#cbd5e1');
    });

    dropZone.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('file').files = files;
            document.getElementById('file-name').textContent = files[0].name;
        }
    });
</script>

</body>
</html>
