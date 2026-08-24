<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function create()
    {
        return view('send');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'file' => 'required|file',
        'to_office_id' => 'required'
    ]);

$path = $request->file('file')->store('uploads', 'supabase');
$url = Storage::disk('supabase')->url($path);


    Document::create([
        'title' => $request->title,
        'file_path' => $url,
        'description' => $request->description,
        'doc_number' => $request->doc_number,

        // 🔥 دي أهم نقطة
        'from_office_id' => Auth::User()->office_id,

        'to_office_id' => $request->to_office_id,
        'created_by' => Auth::id(),
        'status' => 'pending',
    ]);

    return redirect('/dashboard')->with('success', 'تم إرسال المستند بنجاح');
}

public function incoming()
{
    $user = Auth::User();

    if ($user->role_id == 1) {
        // المدير يشوف الكل
        $documents = Document::latest()->get();
    } else {
        // كل مكتب يشوف البجيو ليه
        $documents = Document::where('to_office_id', $user->office_id)
                            ->latest()
                            ->get();
                            
    }

    return view('incoming', compact('documents'));
}
public function show($id)
{
    $document = \App\Models\Document::with(['fromOffice','toOffice','creator'])->findOrFail($id);

    return view('document-show', compact('document'));
}

    public function archive($id)
{
    $document = \App\Models\Document::findOrFail($id);

    $document->status = 'archived';
    $document->archived_at = now();

    $document->save();

    return back()->with('success', 'تمت الأرشفة');
}
    public function receive($id)
{
    $document = \App\Models\Document::findOrFail($id);

    $document->status = 'received';
    $document->archived_at = now();

    $document->save();

    return back()->with('success', 'تم تاكيد الاستلام');
}
}
