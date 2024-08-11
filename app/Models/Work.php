<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_public',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function likes(){
        return $this->belongsToMany(User::class,'likes');
    }
    public function chats(){
        return $this->hasMany(Chat::class);
    }
    public function note(){
        return $this->hasOne(Note::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
