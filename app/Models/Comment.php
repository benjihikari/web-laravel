<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHearts;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory, HasHearts;

    protected $fillable = [
        'content',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
