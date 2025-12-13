<?php

namespace App\Support;

use App\Models\Questions;
use Illuminate\Support\Facades\Auth;

class QuestionShowLoader
{
    public function load(Questions $question)
    {
        return $question->load($this->getRelations());
    }

    protected function getRelations()
    {
        $userId = Auth::id();

        return [
            'user',
            'category',
        
            'answers' => fn ($query) => $query->with([
                'user',
                'hearts' => fn ($query) => $query->where(['user_id', $userId]),
                'comments' => fn ($query) => $query->with([
                    'user',
                    'hearts' => fn ($query) => $query->where(['user_id', $userId])
                ]),
            ]),
        
            'comments' => fn ($query) => $query->with([
                'user',
                'hearts' => fn ($query) => $query->where(['user_id', $userId])
            ]),
        
            'hearts' => fn ($query) => $query->where('user_id', $userId),
        ];
    }
}