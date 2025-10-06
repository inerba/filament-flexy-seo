<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookSection extends Component
{
    public array $genres = [];

    public function render()
    {

        $query = Book::with(['author', 'genres']);

        if (! empty($this->genres)) {
            $query->whereHas('genres', function ($query) {
                $query->whereIn('name', $this->genres);
            });
        }

        $books = $query->take(3)->get();

        return view('livewire.book-section', compact('books'));
    }
}
