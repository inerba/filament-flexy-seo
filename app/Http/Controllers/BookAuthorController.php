<?php

namespace App\Http\Controllers;

use App\Models\BookAuthor;

class BookAuthorController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(BookAuthor $bookAuthor): \Illuminate\View\View
    {
        $author = $bookAuthor->load(['books', 'media']);

        return view('book-authors.show', compact('author'));
    }
}
