<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\Category;

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

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

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

    public function update(Request $request, Questions $question)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $question->update([
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'description'   => $request->description,
        ]);

        return redirect()->route('questions.show', $question);
    }

    public function show(Questions $question)
    {
        $userId = auth()->id();
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
