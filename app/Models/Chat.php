<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'work_id',
        'is_user',
        'message',
        'created_at',
    ];
    
    public function work(){
        return $this->belongsTo(Work::class);
    }
}
