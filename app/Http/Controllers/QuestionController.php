<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;

class QuestionController extends Controller
{
    public function show(Questions $question)
    {
        $question->load('answers', 'category', 'user');

        return view('questions.show', [
            'questions' => $question,
        ]);
    }
}
