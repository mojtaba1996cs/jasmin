@php
use App\Models\Document;
use App\Models\Office;

$user = auth()->user();

$query = Document::with(['fromOffice', 'toOffice'])
        ->where('status', 'archived');

if(request('office_id')){
    $query->where('to_office_id', request('office_id'));
}

if(request('date_from')){
    $query->whereDate('archived_at', '>=', request('date_from'));
}

if(request('date_to')){
    $query->whereDate('archived_at', '<=', request('date_to'));
}

$documents = $query->latest()->get();
$offices = Office::all();
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>الأرشيف</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body {
    font-family: Arial;
    margin: 0;
    background: #f1f5f9;
    display: flex;
}

/* Sidebar */
.sidebar {
    width: 260px;
    background: #0b2b40;
    color: white;
    padding: 20px;
    min-height: 100vh;
}

.sidebar a {
    display: block;
    padding: 10px;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 5px;
}

.sidebar a:hover,
.sidebar a.active {
    background: #eab308;
    color: black;
}

/* Main */
.main {
    flex: 1;
    padding: 25px;
}

/* Card */
.card {
    background: white;
    padding: 20px;
    border-radius: 15px;
}

/* Filter */
.filter-box {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.filter-box select,
.filter-box input {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

th {
    background: #f8fafc;
}

/* Buttons */
.btn {
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    border: none;
    cursor: pointer;
}

.btn-view {
    background: #0b2b40;
    color: white;
}

.btn-download {
    background: #16a34a;
    color: white;
}

.btn-search {
    background: #0b2b40;
    color: white;
}

.btn-reset {
    background: #e2e8f0;
}

/* Empty */
.empty {
    text-align: center;
    padding: 40px;
    color: gray;
}
</style>
</head>

<body>

<div class="sidebar">
    <h3>📁 النظام</h3>

    <a href="/dashboard">الرئيسية</a>
    <a href="/incoming">الواردة</a>
    <a href="/send-document">إرسال</a>
    <a href="/archives" class="active">الأرشيف</a>
</div>

<div class="main">

<h2>📦 الأرشيف</h2>

<div class="card">

<!-- 🔍 البحث -->
<form method="GET" class="filter-box">

    <select name="office_id">
        <option value="">🏢 كل المكاتب</option>
        @foreach($offices as $office)
            <option value="{{ $office->id }}"
                {{ request('office_id') == $office->id ? 'selected' : '' }}>
                {{ $office->name }}
            </option>
        @endforeach
    </select>

    <input type="date" name="date_from" value="{{ request('date_from') }}">
    <input type="date" name="date_to" value="{{ request('date_to') }}">

    <button type="submit" class="btn btn-search">🔍</button>

    <a href="/archives" class="btn btn-reset">↺</a>

</form>

@if($documents->count() > 0)

<table>
    <tr>
        <th>#</th>
        <th>العنوان</th>
        <th>المرسل</th>
        <th>المستلم</th>
        <th>التاريخ</th>
        <th>عرض</th>
    </tr>

    @foreach($documents as $index => $doc)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $doc->title }}</td>
        <td>{{ $doc->fromOffice->name ?? '-' }}</td>
        <td>{{ $doc->toOffice->name ?? '-' }}</td>
        <td>{{ $doc->archived_at ?? '-' }}</td>

        <td>
            <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-view">
                عرض
            </a>

            <a href="{{ asset('storage/'.$doc->file_path) }}" class="btn btn-download" target="_blank">
                تحميل
            </a>
        </td>
    </tr>
    @endforeach

</table>

@else

<div class="empty">
    <h3>📭 لا توجد مستندات مؤرشفة</h3>
</div>

@endif

</div>

</div>

</body>
</html>