@php
    use App\Models\Document;

    $user = auth()->user();

    if ($user->role_id == 1) {
        $documents = Document::with(['fromOffice', 'toOffice'])->latest()->get();
        $pageTitle = "جميع المستندات (صلاحية المدير)";
        $pageIcon = "fa-globe";
    } else {
        $documents = Document::with(['fromOffice', 'toOffice'])
                        ->where('to_office_id', $user->office_id)
                        ->latest()
                        ->get();
        $pageTitle = "المستندات الواردة إلى " . ($user->office->name ?? 'المكتب');
        $pageIcon = "fa-inbox";
    }
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المستندات الواردة - مفوضية العون الإنساني</title>
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

        .role-badge {
            display: inline-block;
            background: #eab308;
            color: #0b2b40;
            padding: 3px 10px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            margin-top: 8px;
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
        .main {
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
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .date-badge {
            background: white;
            padding: 12px 20px;
            border-radius: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            color: #475569;
            font-size: 14px;
        }

        .date-badge i {
            margin-left: 8px;
            color: #eab308;
        }

        .btn-primary {
            background: #0b2b40;
            color: white;
            padding: 12px 22px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: #1a4b6d;
            transform: translateY(-2px);
        }

        /* ========== بطاقة الجدول ========== */
        .table-box {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 18px;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-header h2 {
            font-size: 20px;
            color: #0b2b40;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-header h2 i {
            color: #eab308;
        }

        .stats-badge {
            background: #e0f2fe;
            color: #0b2b40;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
        }

        /* ========== التنبيهات ========== */
        .alert {
            padding: 16px 20px;
            border-radius: 14px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-right: 4px solid #16a34a;
        }

        .alert-info {
            background: #e0f2fe;
            color: #0b2b40;
            border-right: 4px solid #0284c7;
        }

        /* ========== الجدول ========== */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: right;
            padding: 16px 14px;
            background: #f8fafc;
            color: #1e293b;
            font-weight: 700;
            font-size: 14px;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 14px;
        }

        tr:hover td {
            background: #fafbfc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* ========== الشارات ========== */
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .pending {
            background: #fef3c7;
            color: #b45309;
        }

        .received {
            background: #d1fae5;
            color: #047857;
        }

        .archived {
            background: #e2e8f0;
            color: #475569;
        }

        /* ========== الأزرار ========== */
        .action-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 7px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-view {
            background: #0b2b40;
            color: white;
        }

        .btn-view:hover {
            background: #1a4b6d;
        }

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .btn-success:hover {
            background: #15803d;
        }

        .btn-warning {
            background: #eab308;
            color: #0b2b40;
        }

        .btn-warning:hover {
            background: #ca8a04;
        }

        /* ========== رسالة فارغة ========== */
        .empty {
            text-align: center;
            padding: 50px 20px;
            color: #94a3b8;
        }

        .empty i {
            font-size: 60px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty p {
            font-size: 18px;
            margin-bottom: 15px;
        }

        /* ========== للجوال ========== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                z-index: 1000;
            }
            .main {
                margin-right: 0;
                padding: 20px;
            }
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .header-actions {
                width: 100%;
                justify-content: space-between;
            }
            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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
            <p><i class="fas fa-building"></i> {{ $user->office->name ?? 'غير محدد' }}</p>
            <p><i class="fas fa-tag"></i> {{ $user->role->name ?? 'غير محدد' }}</p>
            <span class="role-badge">{{ $user->office->code ?? 'HAC' }}</span>
        </div>
    </div>

    <a href="{{ url('/dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        الرئيسية
    </a>
    <a href="{{ url('/incoming') }}" class="active">
        <i class="fas fa-inbox"></i>
        الواردة
    </a>
    <a href="{{ url('/send-document') }}">
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
<div class="main">
    <div class="page-header">
        <h1>
            <i class="fas {{ $pageIcon }}"></i>
            {{ $pageTitle }}
        </h1>
        <div class="header-actions">
            <div class="date-badge">
                <i class="fas fa-calendar-alt"></i>
                {{ date('Y-m-d') }}
            </div>
            <a href="{{ url('/send-document') }}" class="btn-primary">
                <i class="fas fa-plus-circle"></i>
                إرسال مستند
            </a>
        </div>
    </div>

    <div class="table-box">
        <div class="table-header">
            <h2>
                <i class="fas fa-list"></i>
                قائمة المستندات
            </h2>
            <span class="stats-badge">
                <i class="fas fa-file"></i>
                عدد المستندات: {{ $documents->count() }}
            </span>
        </div>

        {{-- رسائل التنبيه --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($user->role_id == 1)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                أنت تشاهد جميع المستندات المرسلة بين كل المكاتب (صلاحية المدير)
            </div>
        @endif

        {{-- جدول المستندات --}}
        @if($documents->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>المرسل</th>
                            @if($user->role_id == 1)
                                <th>المستلم</th>
                            @endif
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $i => $doc)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <i class="fas fa-file-pdf" style="color: #dc2626; margin-left: 8px;"></i>
                                {{ $doc->title }}
                            </td>
                            <td>{{ $doc->fromOffice->name ?? '-' }}</td>
                            @if($user->role_id == 1)
                                <td>{{ $doc->toOffice->name ?? '-' }}</td>
                            @endif
                            <td>{{ $doc->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if($doc->status == 'pending')
                                    <span class="badge pending">
                                        <i class="fas fa-clock"></i> قيد الانتظار
                                    </span>
                                @elseif($doc->status == 'received')
                                    <span class="badge received">
                                        <i class="fas fa-check-circle"></i> تم الاستلام
                                    </span>
                                @else
                                    <span class="badge archived">
                                        <i class="fas fa-archive"></i> مؤرشفة
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    {{-- عرض التفاصيل --}}
                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-view">
                                        <i class="fas fa-eye"></i> عرض
                                    </a>

                                    {{-- تأكيد الاستلام --}}
                                    @if($user->office_id == $doc->to_office_id && $doc->status == 'pending')
                                        <form method="POST" action="{{ route('documents.receive', $doc->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success" onclick="return confirm('هل أنت متأكد من تأكيد استلام هذا المستند؟')">
                                                <i class="fas fa-check"></i> استلام
                                            </button>
                                        </form>
                                    @endif

                                    {{-- أرشفة --}}
                                    @if(($user->office_id == $doc->to_office_id || $user->role_id == 1) && $doc->status != 'archived')
                                        <form method="POST" action="{{ route('documents.archive', $doc->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning" onclick="return confirm('هل تريد نقل هذا المستند إلى الأرشيف؟')">
                                                <i class="fas fa-archive"></i> أرشفة
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty">
                <i class="fas fa-inbox"></i>
                <p>لا توجد مستندات واردة حالياً</p>
                <a href="{{ url('/send-document') }}" class="btn btn-view" style="margin-top: 15px;">
                    <i class="fas fa-paper-plane"></i> إرسال أول مستند
                </a>
            </div>
        @endif
    </div>
</div>

</body>
</html>