<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'office_id' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'office_id' => $request->office_id,
            'role_id' => 2,
        ]);

        return back()->with('success', 'تمت إضافة المستخدم بنجاح');
    }
    public function update(Request $request , $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'office_id' => 'required',
        ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->office_id = $request->office_id;
    if($request->filled('password')){
        $user->password = hash::make($request->password);
    }
$user->save();
        return redirect(url('/admin/users'))->with('success', 'تم تحديث بيانات المستخدم');
    }
    public function destroy($id){
        $user = User::findOrFail($id);
        $getdocum = $user->documents()->where('status',['pending','received'])->get();
        foreach ($getdocum as $doc) {
            if($doc->file_path && \Storage::disk('supabase')->exists($doc->file_path)){
                \Storage::disk('supabase')->delete($doc->file_path);
            }
            $doc->delete();
        }
        $user->delete();
        return back()->with('success', 'تم حذف المستخدم بنجاح');
    }

}
