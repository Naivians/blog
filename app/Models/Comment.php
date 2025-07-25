<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

     protected $fillable = [
        'post_id',
        'comment',
        'attachment'
    ];

    public function posts(){
        return $this->belongsTo(post::class)->orderBy('created_at', 'desc');
    }
}
