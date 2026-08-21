@php
    use App\Models\Office;
    use App\Models\User;
    $user = auth()->user();

    if ($user->role_id != 1) {
        abort(403);
    }

    $offices = Office::all();
    $users = User::with('office')->latest()->get();
    $idup = request('id');
    $type = request('type');
    
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين - مفوضية العون الإنساني</title>
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
            margin: 0;
            display: flex;
            min-height: 100vh;
            direction: rtl;
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
            background: #eab308;
            color: #0b2b40;
        }

        .sidebar a.active {
            background: #eab308;
            color: #0b2b40;
            font-weight: 600;
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

        .page-header h2 {
            font-size: 28px;
            color: #0b2b40;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h2 i {
            color: #eab308;
            font-size: 30px;
        }

        .user-badge {
            background: white;
            padding: 12px 20px;
            border-radius: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            color: #0b2b40;
            font-weight: 600;
            font-size: 14px;
        }

        .user-badge i {
            margin-left: 8px;
            color: #eab308;
        }

        /* ========== البطاقات ========== */
        .card {
            background: white;
            padding: 28px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            padding-bottom: 18px;
            border-bottom: 2px solid #e2e8f0;
        }

        .card-header i {
            font-size: 28px;
            color: #eab308;
            background: #fef9c3;
            padding: 10px;
            border-radius: 12px;
        }

        .card-header h3 {
            font-size: 22px;
            color: #0b2b40;
        }

        /* ========== تنبيهات ========== */
        .alert {
            padding: 16px 20px;
            border-radius: 14px;
            margin-bottom: 25px;
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

        /* ========== النموذج ========== */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 5px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }

        .form-group label i {
            margin-left: 6px;
            color: #0b2b40;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.2s;
            background: #fafcfc;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #0b2b40;
            background: white;
            box-shadow: 0 0 0 3px rgba(11,43,64,0.08);
        }

        .btn-submit {
            padding: 14px 28px;
            background: #0b2b40;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-submit i {
            font-size: 16px;
        }

        .btn-submit:hover {
            background: #1a4b6d;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(11,43,64,0.2);
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

        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-admin {
            background: #eab308;
            color: #0b2b40;
        }

        .badge-employee {
            background: #e2e8f0;
            color: #475569;
        }
    .badge-delete {
            background: #c96969;
            color: #475569;
            width: 80px;
            height: 30px;
            border-width: 3px;
    border-color: black;
    border-style: outset;
        }
        .badge-delete:hover {
            background: #f3eeee;
            color: #475569;
        }
        .badge-updata {
            background: #8fc969;
            color: #475569;
            text-decoration: none;
            border-style: outset;
            margin-bottom: 3px;
        }
        .badge-updata:hover {
            background: #eff3ee;
            color: #475569;
        }
        .stats-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .stats-info span {
            background: #e0f2fe;
            color: #0b2b40;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
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
        مفوضية العون
    </h3>
    
    <a href="{{ url('/dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        الرئيسية
    </a>
    <a href="{{ url('/incoming') }}">
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
    <a href="{{ url('/admin/users') }}" class="active">
        <i class="fas fa-users-cog"></i>
        المستخدمين
    </a>
    <a href="{{ url('/logout') }}" style="margin-top: 20px; color: #fca5a5;">
        <i class="fas fa-sign-out-alt"></i>
        خروج
    </a>
</div>

{{-- ========== المحتوى الرئيسي ========== --}}
<div class="main">
    <div class="page-header">
        <h2>
            <i class="fas fa-users-cog"></i>
            إدارة المستخدمين
        </h2>
        <div class="user-badge">
            <i class="fas fa-user-shield"></i>
            {{ $user->name }} (مدير النظام)
        </div>
    </div>
@if($type == "edit")
@php
$user2 = User::findOrFail($idup);
@endphp

    {{-- بطاقة تعديل مستخدم --}}
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-edit"></i>
            <h3>تعديل مستخدم </h3>
          
        </div>

        {{-- رسائل التنبيه --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin: 5px 20px 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.update' ,$user2->id) }}">
            @csrf
            @method('PUT')
            <div class="form-grid">
                {{-- الاسم --}}
                <div class="form-group">
                    <label><i class="fas fa-user"></i> الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name',$user2->name) }}" placeholder="أدخل الاسم الكامل" required>
                </div>

                {{-- البريد الإلكتروني --}}
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email',$user2->email) }}" placeholder="example@hac.sd" required>
                </div>

                {{-- كلمة المرور --}}
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> كلمة المرور</label>
                    <input type="password"  value="" name="password" placeholder="••••••••" >
                </div>

                {{-- المكتب --}}
                <div class="form-group">
                    <label><i class="fas fa-building"></i> المكتب</label>
                    <select name="office_id" required>
                        <option value="">-- اختر المكتب --</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>
                                {{ $office->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- الدور (مخفي دائماً = موظف) --}}
            <input type="hidden" name="role_id" value="2">

            <button type="submit" class="btn-submit">
                <i class="fas fa-edit"></i>
                تعديل  المستخدم
            </button>
        </form>
    </div>
@else
    {{-- بطاقة إضافة مستخدم --}}
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-plus"></i>
            <h3>إضافة مستخدم جديد</h3>
          
        </div>

        {{-- رسائل التنبيه --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin: 5px 20px 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/admin/users') }}">
            @csrf
            
            <div class="form-grid">
                {{-- الاسم --}}
                <div class="form-group">
                    <label><i class="fas fa-user"></i> الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="أدخل الاسم الكامل" required>
                </div>

                {{-- البريد الإلكتروني --}}
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="example@hac.sd" required>
                </div>

                {{-- كلمة المرور --}}
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> كلمة المرور</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                {{-- المكتب --}}
                <div class="form-group">
                    <label><i class="fas fa-building"></i> المكتب</label>
                    <select name="office_id" required>
                        <option value="">-- اختر المكتب --</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>
                                {{ $office->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- الدور (مخفي دائماً = موظف) --}}
            <input type="hidden" name="role_id" value="2">

            <button type="submit" class="btn-submit">
                <i class="fas fa-plus-circle"></i>
                إضافة المستخدم
            </button>
        </form>
    </div>
@endif
    {{-- بطاقة قائمة المستخدمين --}}
    <div class="card">
        <div class="card-header">
            <i class="fas fa-users"></i>
            <h3>قائمة المستخدمين</h3>
        </div>

        <div class="stats-info">
            <span>
                <i class="fas fa-user-check"></i>
                عدد المستخدمين: {{ $users->count() }}
            </span>
        </div>

        @if($users->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>المكتب</th>
                            <th>الدور</th>
                            <th>اجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <i class="fas fa-user-circle" style="color: #0b2b40; margin-left: 8px;"></i>
                                {{ $u->name }}
                            </td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->office->name ?? '-' }}</td>
                            <td>
                                @if($u->role_id == 1)
                                    <span class="badge badge-admin">
                                        <i class="fas fa-crown"></i> مدير
                                    </span>
                                @else
                                    <span class="badge badge-employee">
                                        <i class="fas fa-user"></i> موظف
                                    </span>
                                @endif
                            </td>
                            <td>
                                 @if($u->role_id == 1)
                                 <center><span class="badge badge-updata">
                                        <i class="fa fa-edit"></i> تعديل
                                    </span> </center>
                                 @else
                                 
                                 <center>
                                  <a href="{{ url('admin/users?type=edit&id=' .$u->id. '') }}" class="badge badge-updata"><i  class="fa fa-edit"></i>  تعديل </a>
                                   
                                    <form action="{{ route('users.destroy' ,$u->id) }}" method="POST" onsubmit="return confirm('هل تريد حذف المستخدم');">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="badge badge-delete"><i  class="fa fa-trash"></i>  حذف </button>
</form></center>
                                    @endif
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #94a3b8; padding: 30px;">
                <i class="fas fa-users-slash" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                لا يوجد مستخدمين حالياً
            </p>
        @endif
    </div>
</div>

</body>
</html>
