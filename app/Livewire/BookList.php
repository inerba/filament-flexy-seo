<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookList extends Component
{
    public $books;

    public ?int $exclude = null;

    public function mount()
    {
        $query = Book::with(['authors', 'genres', 'media']);

        if (! is_null($this->exclude)) {
            $query->where('id', '!=', $this->exclude);
        }

        $this->books = $query->get();
    }

    public function render()
    {
        return view('livewire.book-list');
    }
}
