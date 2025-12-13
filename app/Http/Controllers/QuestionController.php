<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Category;
use App\Support\QuestionShowLoader;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;

use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Questions::with([
            'user',
            'category',
        ])
        ->latest()
        ->paginate(24);

        return view('questions.index', [
            'questions' => $questions
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('questions.create', [
            'categories' => $categories
        ]);
    }

    public function store(StoreQuestionRequest $request)
    {

        $question = Questions::create([
            'user_id'       => auth()->id(),
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'description'   => $request->description,
        ]);

        return redirect()->route('questions.show', $question);
    }

    public function edit(Questions $question)
    {
        $categories = Category::all();

        return view('questions.edit', [
            'question' => $question,
            'categories' => $categories
        ]);
    }

    public function update(UpdateQuestionRequest $request, Questions $question)
    {

        $question->update([
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'description'   => $request->description,
        ]);

        return redirect()->route('questions.show', $question);
    }

    public function show(Questions $question, QuestionShowLoader $loader)
    {
        $loader->load($question);

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
