<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = ['name', 'code'];

public function documentsFrom()
{
    return $this->hasMany(\App\Models\Document::class, 'from_office_id');
}

public function documentsTo()
{
    return $this->hasMany(\App\Models\Document::class, 'to_office_id');
}
}
