@php
    use App\Models\Document;
    $user = auth()->user();
    
    // إحصائيات حقيقية من قاعدة البيانات
    $incomingCount = Document::where('to_office_id', $user->office_id)->count();
    $outgoingCount = Document::where('from_office_id', $user->office_id)->count();
    $archivedCount = Document::where('status', 'archived')->count();
    
    // آخر 5 مستندات واردة
    $recentDocuments = Document::with(['fromOffice', 'creator'])
                        ->where('to_office_id', $user->office_id)
                        ->latest()
                        ->take(5)
                        ->get();
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مفوضية العون الإنساني</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            direction: rtl;
            display: flex;
            min-height: 100vh;
        }

        /* ========== الشريط الجانبي ========== */
        .sidebar {
            width: 280px;
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

        .sidebar-header {
            padding: 0 10px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            margin-bottom: 20px;
        }

        .sidebar-header h2 {
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h2 i {
            color: #eab308;
            font-size: 26px;
        }

        .user-profile {
            background: rgba(255,255,255,0.08);
            padding: 18px 15px;
            border-radius: 14px;
            margin-bottom: 25px;
        }

        .user-avatar {
            width: 55px;
            height: 55px;
            background: #eab308;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .user-avatar i {
            font-size: 28px;
            color: #0b2b40;
        }

        .user-info h4 {
            font-size: 17px;
            margin-bottom: 6px;
        }

        .user-info p {
            font-size: 13px;
            opacity: 0.85;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-badge {
            display: inline-block;
            background: #eab308;
            color: #0b2b40;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            margin-top: 8px;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 16px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.25s;
            font-weight: 500;
            font-size: 15px;
        }

        .sidebar nav a i {
            width: 22px;
            font-size: 18px;
            text-align: center;
        }

        .sidebar nav a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar nav a.active {
            background: #eab308;
            color: #0b2b40;
            font-weight: 600;
        }

        .sidebar nav a.logout {
            margin-top: 20px;
            color: #fca5a5;
        }

        .sidebar nav a.logout:hover {
            background: rgba(220,38,38,0.2);
            color: #fecaca;
        }

        /* ========== المحتوى الرئيسي ========== */
        .main-content {
            margin-right: 280px;
            padding: 30px 35px;
            flex: 1;
        }

        /* ========== الهيدر ========== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .page-header h1 {
            font-size: 30px;
            color: #0b2b40;
            font-weight: 700;
        }

        .date-badge {
            background: white;
            padding: 12px 22px;
            border-radius: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            color: #475569;
            font-size: 14px;
        }

        .date-badge i {
            margin-left: 8px;
            color: #eab308;
        }

        /* ========== بطاقات الإحصائيات ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 28px 25px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        .stat-info h3 {
            font-size: 38px;
            font-weight: 800;
            color: #0b2b40;
            margin-bottom: 6px;
        }

        .stat-info p {
            color: #64748b;
            font-size: 15px;
            font-weight: 500;
        }

        .stat-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .stat-icon.incoming {
            background: #e0f2fe;
            color: #0284c7;
        }

        .stat-icon.outgoing {
            background: #dcfce7;
            color: #16a34a;
        }

        .stat-icon.archived {
            background: #f3e8ff;
            color: #9333ea;
        }

        /* ========== قسم المستندات الأخيرة ========== */
        .recent-section {
            background: white;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 {
            font-size: 20px;
            color: #0b2b40;
            font-weight: 700;
        }

        .section-header h2 i {
            margin-left: 10px;
            color: #eab308;
        }

        .section-header a {
            color: #0b2b40;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
        }

        .section-header a:hover {
            color: #eab308;
        }

        .document-table {
            width: 100%;
            border-collapse: collapse;
        }

        .document-table th {
            text-align: right;
            padding: 14px 12px;
            color: #64748b;
            font-weight: 600;
            font-size: 13px;
            border-bottom: 2px solid #e2e8f0;
        }

        .document-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 14px;
        }

        .document-table tr:last-child td {
            border-bottom: none;
        }

        .document-table tr:hover td {
            background: #fafbfc;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-pending {
            background: #fef3c7;
            color: #b45309;
        }

        .status-received {
            background: #d1fae5;
            color: #047857;
        }

        .status-archived {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-view {
            padding: 7px 14px;
            background: #f1f5f9;
            color: #475569;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-view:hover {
            background: #e2e8f0;
        }

        .btn-view i {
            margin-left: 5px;
        }

        .empty-message {
            text-align: center;
            padding: 45px;
            color: #94a3b8;
        }

        .empty-message i {
            font-size: 50px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* ========== أزرار سريعة ========== */
        .quick-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .quick-btn {
            background: white;
            padding: 14px 24px;
            border-radius: 14px;
            color: #0b2b40;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .quick-btn i {
            color: #eab308;
        }

        .quick-btn:hover {
            background: #0b2b40;
            color: white;
        }

        .quick-btn:hover i {
            color: white;
        }

        /* ========== للجوال ========== */
        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                z-index: 1000;
            }
            .main-content {
                margin-right: 0;
                padding: 20px;
            }
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .quick-actions {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>

{{-- ========== الشريط الجانبي ========== --}}
<aside class="sidebar">
    <div class="sidebar-header">
        <h2>
            <i class="fas fa-hands-helping"></i>
         مفوضية العون الانساني
        </h2>
    </div>

    <div class="user-profile">
        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-info">
            <h4>{{ $user->name }}</h4>
            <p><i class="fas fa-building"></i> {{ $user->office->name ?? 'غير محدد' }}</p>

            <p><i class="fas fa-tag"></i> {{ $user->role->name ?? 'غير محدد' }}</p>
            
            <span class="role-badge">{{ $user->office->code ?? 'HAC' }}</span>

        </div>
    </div>

    <nav>
        <a href="{{ url('/dashboard') }}" class="active">
            <i class="fas fa-tachometer-alt"></i>
            لوحة التحكم
        </a>
        <a href="{{ url('/incoming') }}">
            <i class="fas fa-inbox"></i>
            المستندات الواردة
        </a>
        <a href="{{ url('/send-document') }}">
            <i class="fas fa-paper-plane"></i>
            إرسال مستند
        </a>
        <a href="{{ url('/archives') }}">
            <i class="fas fa-archive"></i>
            الأرشيف
        </a>

        {{-- 👇 إدارة المستخدمين (للمدير فقط) --}}
        @if($user->role_id == 1)
        <a href="{{ url('/admin/users') }}" style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.15); padding-top: 20px;">
            <i class="fas fa-users-cog"></i>
            إدارة المستخدمين
        </a>
        @endif
        
        <a href="{{ url('/logout') }}" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            تسجيل الخروج
        </a>
    </nav>
</aside>

{{-- ========== المحتوى الرئيسي ========== --}}
<main class="main-content">
    <div class="page-header">
        <h1>لوحة التحكم</h1>
        <div class="date-badge">
            <i class="fas fa-calendar-alt"></i>
            {{ date('Y-m-d') }}
        </div>
    </div>

    {{-- أزرار سريعة --}}
    <div class="quick-actions">
        <a href="{{ url('/send-document') }}" class="quick-btn">
            <i class="fas fa-paper-plane"></i>
            إرسال مستند جديد
        </a>
        <a href="{{ url('/incoming') }}" class="quick-btn">
            <i class="fas fa-inbox"></i>
            عرض الوارد
        </a>
        @if($user->role_id == 1)
        <a href="{{ url('/admin/users') }}" class="quick-btn">
            <i class="fas fa-user-plus"></i>
            إضافة مستخدم
        </a>
        @endif
    </div>

    {{-- بطاقات الإحصائيات --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $incomingCount }}</h3>
                <p>المستندات الواردة</p>
            </div>
            <div class="stat-icon incoming">
                <i class="fas fa-inbox"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $outgoingCount }}</h3>
                <p>المستندات الصادرة</p>
            </div>
            <div class="stat-icon outgoing">
                <i class="fas fa-paper-plane"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $archivedCount }}</h3>
                <p>في الأرشيف</p>
            </div>
            <div class="stat-icon archived">
                <i class="fas fa-archive"></i>
            </div>
        </div>
    </div>

    {{-- آخر المستندات الواردة --}}
    <div class="recent-section">
        <div class="section-header">
            <h2>
                <i class="fas fa-clock"></i>
                آخر المستندات الواردة
            </h2>
            <a href="{{ url('/incoming') }}">
                عرض الكل <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>
            </a>
        </div>

        @if($recentDocuments->count() > 0)
        <table class="document-table">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>المرسل</th>
                    <th>التاريخ</th>
                    <th>الحالة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentDocuments as $doc)
                <tr>
                    <td>
                        <i class="fas fa-file-pdf" style="color: #dc2626; margin-left: 8px;"></i>
                        {{ $doc->title }}
                    </td>
                    <td>{{ $doc->fromOffice->name ?? 'غير محدد' }}</td>
                    <td>{{ $doc->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if($doc->status == 'pending')
                            <span class="status-badge status-pending">قيد الانتظار</span>
                        @elseif($doc->status == 'received')
                            <span class="status-badge status-received">تم الاستلام</span>
                        @else
                            <span class="status-badge status-archived">مؤرشفة</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('documents.show', $doc->id) }}" class="btn-view">
                            <i class="fas fa-eye"></i> عرض
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-message">
            <i class="fas fa-inbox"></i>
            <p>لا توجد مستندات واردة حالياً</p>
        </div>
        @endif
    </div>
</main>

</body>
</html>