@php
    use App\Models\User;
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المستند - مفوضية العون الإنساني</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; direction: rtl; display: flex; min-height: 100vh; }

        .sidebar { width: 260px; background: linear-gradient(180deg, #0b2b40 0%, #0f3448 100%); color: white; padding: 25px 15px; position: fixed; right: 0; top: 0; bottom: 0; }
        .sidebar h3 { padding: 0 10px 20px; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.15); font-size: 20px; display: flex; align-items: center; gap: 10px; }
        .sidebar h3 i { color: #eab308; }
        .user-profile { background: rgba(255,255,255,0.08); padding: 15px; border-radius: 14px; margin-bottom: 25px; }
        .user-profile h4 { font-size: 16px; margin-bottom: 6px; }
        .user-profile p { font-size: 13px; opacity: 0.85; display: flex; align-items: center; gap: 8px; }
        .sidebar a { display: flex; align-items: center; gap: 12px; padding: 12px 15px; color: rgba(255,255,255,0.9); text-decoration: none; border-radius: 12px; margin-bottom: 5px; transition: 0.25s; font-size: 15px; }
        .sidebar a i { width: 22px; text-align: center; }
        .sidebar a:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar a.logout { margin-top: 20px; color: #fca5a5; }

        .main { flex: 1; margin-right: 260px; padding: 30px 35px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; color: #0b2b40; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: #eab308; }
        .breadcrumb { color: #64748b; font-size: 14px; }
        .breadcrumb a { color: #0b2b40; text-decoration: none; }

        .details-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); max-width: 800px; margin: 0 auto; }

        .doc-header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 2px solid #e2e8f0; }
        .doc-icon { width: 65px; height: 65px; background: #e0f2fe; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 30px; color: #0b2b40; }
        .doc-title h2 { font-size: 22px; color: #0b2b40; margin-bottom: 8px; }
        .status-badge { display: inline-block; padding: 5px 14px; border-radius: 30px; font-size: 12px; font-weight: 700; }
        .status-pending { background: #fef3c7; color: #b45309; }
        .status-received { background: #d1fae5; color: #047857; }
        .status-archived { background: #e2e8f0; color: #475569; }

        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; margin-bottom: 25px; }
        .info-item { background: #f8fafc; padding: 18px; border-radius: 14px; }
        .info-item label { display: block; font-size: 13px; color: #64748b; margin-bottom: 8px; }
        .info-item label i { margin-left: 6px; color: #0b2b40; width: 16px; }
        .info-item .value { font-size: 17px; font-weight: 700; color: #1e293b; }

        .file-section { background: #f8fafc; padding: 25px; border-radius: 16px; text-align: center; margin-bottom: 25px; }
        .file-section i { font-size: 45px; color: #0b2b40; margin-bottom: 12px; }
        .file-section p { color: #64748b; margin: 10px 0 18px; }

        .btn { padding: 12px 22px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; border: none; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; margin: 0 4px; }
        .btn-primary { background: #0b2b40; color: white; }
        .btn-primary:hover { background: #1a4b6d; }
        .btn-secondary { background: #e2e8f0; color: #475569; }
        .btn-secondary:hover { background: #cbd5e1; }
        .btn-success { background: #16a34a; color: white; }
        .btn-warning { background: #eab308; color: #0b2b40; }
        .action-buttons { display: flex; flex-wrap: wrap; gap: 10px; }

        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; background: #dcfce7; color: #166534; border-right: 4px solid #16a34a; display: flex; align-items: center; gap: 10px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(100%); }
            .main { margin-right: 0; padding: 20px; }
            .info-grid { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3><i class="fas fa-hands-helping"></i> مفوضية العون الإنساني</h3>
    <div class="user-profile">
        <h4>{{ $user->name }}</h4>
        <p><i class="fas fa-building"></i> {{ $user->office->name ?? 'غير محدد' }}</p>
        <p><i class="fas fa-tag"></i> {{ $user->role->name ?? 'غير محدد' }}</p>
    </div>
    <a href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i> الرئيسية</a>
    <a href="{{ url('/incoming') }}"><i class="fas fa-inbox"></i> الواردة</a>
    <a href="{{ url('/send-document') }}"><i class="fas fa-paper-plane"></i> إرسال مستند</a>
    <a href="{{ url('/archives') }}"><i class="fas fa-archive"></i> الأرشيف</a>
    @if($user->role_id == 1)
    <a href="{{ url('/admin/users') }}"><i class="fas fa-users-cog"></i> المستخدمين</a>
    @endif
    <a href="{{ url('/logout') }}" class="logout"><i class="fas fa-sign-out-alt"></i> خروج</a>
</div>

<div class="main">
    <div class="page-header">
        <h1><i class="fas fa-file-alt"></i> تفاصيل المستند</h1>
        <div class="breadcrumb"><a href="{{ url('/dashboard') }}">الرئيسية</a> / <a href="{{ url('/incoming') }}">الواردة</a> / <span>تفاصيل</span></div>
    </div>

    @if(session('success'))
        <div class="alert"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="details-card">
        <div class="doc-header">
            <div class="doc-icon"><i class="fas fa-file-pdf"></i></div>
            <div class="doc-title">
                <h2>{{ $document->title }}</h2>
                <span class="status-badge {{ $document->status == 'pending' ? 'status-pending' : ($document->status == 'received' ? 'status-received' : 'status-archived') }}">
                    @if($document->status == 'pending') <i class="fas fa-clock"></i> قيد الانتظار
                    @elseif($document->status == 'received') <i class="fas fa-check-circle"></i> تم الاستلام
                    @else <i class="fas fa-archive"></i> مؤرشفة
                    @endif
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item"><label><i class="fas fa-building"></i> المرسل</label><div class="value">{{ $document->fromOffice->name ?? '-' }}</div></div>
            <div class="info-item"><label><i class="fas fa-building"></i> المستلم</label><div class="value">{{ $document->toOffice->name ?? '-' }}</div></div>
            <div class="info-item"><label><i class="fas fa-user"></i> المرسل</label><div class="value">{{ $document->creator->name ?? '-' }}</div></div>
            <div class="info-item"><label><i class="fas fa-calendar"></i> التاريخ</label><div class="value">{{ $document->created_at->format('Y-m-d') }}</div></div>
        </div>

        <div class="file-section">
            <i class="fas fa-file-pdf"></i>
            <p>{{ basename($document->file_path) }}</p>
            <div>
                <a href="{{ $document->file_url }}" class="btn btn-primary" target="_blank"><i class="fas fa-download"></i> تحميل</a>
            
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ url('/incoming') }}" class="btn btn-secondary"><i class="fas fa-arrow-right"></i> العودة</a>
            @if($user->office_id == $document->to_office_id && $document->status == 'pending')
                <form method="POST" action="{{ route('documents.receive', $document->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('تأكيد الاستلام؟')"><i class="fas fa-check"></i> تأكيد الاستلام</button>
                </form>
            @endif
            @if(($user->office_id == $document->to_office_id || $user->role_id == 1) && $document->status != 'archived')
                <form method="POST" action="{{ route('documents.archive', $document->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning" onclick="return confirm('نقل إلى الأرشيف؟')"><i class="fas fa-archive"></i> أرشفة</button>
                </form>
            @endif
        </div>
    </div>
</div>

</body>
</html>
