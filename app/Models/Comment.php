<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

     protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'attachment'
    ];

    public function user(){
        return $this->belongsTo(user::class);
    }

    public function posts(){
        return $this->belongsTo(post::class)->orderBy('created_at', 'desc');
    }
}
