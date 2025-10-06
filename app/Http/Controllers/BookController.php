<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Book $book): \Illuminate\View\View
    {
        return view('books.show', compact('book'));
    }
}
