<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class BookList extends Component
{
    use WithPagination;

    public int $perPage = 6;

    public ?int $exclude = null;

    public function placeholder(array $params = [])
    {
        $params['num'] = $this->perPage;

        return view('livewire.placeholders.book-list', $params);
    }

    public function render()
    {
        $books = Book::with(['authors', 'genres', 'media'])
            ->when($this->exclude !== null, fn ($q) => $q->where('id', '!=', $this->exclude))
            ->simplePaginate($this->perPage);

        return view('livewire.book-list', [
            'books' => $books,
        ]);
    }
}
