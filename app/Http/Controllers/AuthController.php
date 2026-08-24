<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller

{
    // عرض صفحة تسجيل الدخول
    public function showLoginForm()
    {
        return view('login');
    }
public function showLogin()
{
    $Offices = Office::all();
    /*return view('auth.login', compact('Offices'));*/
    return view('login',compact('Offices'));
}
    // تسجيل الدخول
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect('/dashboard');
    }

    return back()->withErrors([
        'email' => 'بيانات الدخول خطا',
    ]);
}

    // تسجيل الخروج
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
