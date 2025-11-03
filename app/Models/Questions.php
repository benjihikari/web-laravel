<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHearts;

class Questions extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionsFactory> */
    use HasFactory, HasHearts;

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    protected static function booted()
    {
        static::deleting(function ($question){
            $question->hearts()->delete();

            $question->comments()->get()->each(function ($comment){
                $comment->hearts()->delete();
                $comment->delete();
            });

            $question->answers()->get()->each(function ($answer){
                $answer->hearts()->delete();

                $answer->comments()->get()->each(function ($comment){
                    $comment->hearts()->delete();
                    $comment->delete();
                });


            });
        });
    }
}
