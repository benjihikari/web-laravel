<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;

class PageController extends Controller
{
    public function index()
    {
        $questions = Questions::with('category', 'user')->latest()->get();

        return view('pages.home', [
            'questions' => $questions,
        ]);
    }
}
