<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;

class QuestionController extends Controller
{
    public function show(Questions $question)
    {
        $userId = 12;
        $question->load([
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
        ]);

        return view('questions.show', [
            'questions' => $question,
        ]);
    }

    public function destroy(Questions $question)
    {
        $question->delete();

        return redirect()->route('home');
    }
}
