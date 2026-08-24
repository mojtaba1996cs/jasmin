<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'from_office_id',
        'to_office_id',
        'status',
        'doc_number',
        'description',
        'created_by'
    ];
public function fromOffice()
{
    return $this->belongsTo(\App\Models\Office::class, 'from_office_id');
}

public function toOffice()
{
    return $this->belongsTo(\App\Models\Office::class, 'to_office_id');
}

public function creator()
{
    return $this->belongsTo(\App\Models\User::class, 'created_by');
}
    public function getFileUrlAttribute()
{
    return rtrim(env('SUPABASE_PROJECT_URL'), '/') . '/storage/v1/object/public/documents/' . $this->file_path;
}
}
