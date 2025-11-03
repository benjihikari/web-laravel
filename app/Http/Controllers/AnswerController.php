<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, Questions $question)
    {
        $request->validate([
            'content'=>'required|max:255',
        ]);

        $question->answers()->create([
            'content'=>$request->content,
            'user_id'=>12,
        ]);

        return back();
    }
}
