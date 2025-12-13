<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Questions;

class QuestionPolicy
{
    public function delete(User $user, Questions $question)
    {
        return $user->id === $question->user_id;
    }

    public function update(User $user, Questions $question)
    {
        $isOwner = $user->id === $question->user_id;

        $isEmpty = $questions->answers()->count() === 0 && $questions->comments()->count();

        return $isOwner && $isEmpty;
    }  
}
