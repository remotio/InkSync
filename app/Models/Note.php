<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'work_id',
        'content',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    public function work(){
        return $this->belongsTo(Work::class);
    }
}
