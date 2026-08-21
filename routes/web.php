<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// صفحة الترحيب
Route::get('/', [HomeController::class, 'index'])->name('home');

// تسجيل الدخول
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);


/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/send-document', function () {
        return view('send');
    });

    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');

    Route::get('/incoming', [DocumentController::class, 'incoming']);

    Route::get('/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');

    Route::post('/documents/{id}/receive', [DocumentController::class, 'receive'])->name('documents.receive');

    Route::get('/archives', function () {
        return view('archives');
    });

    Route::post('/documents/{id}/archive', [DocumentController::class, 'archive'])->name('documents.archive');

});

/*
|--------------------------------------------------------------------------
| Protected Routes (لازم تسجيل دخول)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    // إرسال مستند (صفحة)
    Route::get('/send-document', function () {
        return view('send');
    });

    // حفظ مستند
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');

    // الواردة
    Route::get('/incoming', [DocumentController::class, 'incoming']);

    // عرض مستند
    Route::get('/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');

    // استلام
    Route::post('/documents/{id}/receive', [DocumentController::class, 'receive'])->name('documents.receive');

    // أرشفة
    Route::get('/archives', function () {return view('archives');})->middleware('auth');
    Route::post('/documents/{id}/archive', [DocumentController::class, 'archive'])->name('documents.archive');

});
Route::get('/admin/users', function () {
    return view('admin.users');
});


Route::post('/admin/users', [App\Http\Controllers\UserController::class, 'store']);
Route::put('/admin/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('/admin/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
