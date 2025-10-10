<?php

namespace App\Livewire;

use App\Models\BookAuthor;
use Livewire\Component;

class BookAuthors extends Component
{
    public $authors;

    public ?int $exclude = null;

    public function mount()
    {
        $this->authors = BookAuthor::query()
            ->when(! is_null($this->exclude), fn ($query) => $query->where('id', '!=', $this->exclude))
            ->orderBy('name')
            ->with('media')
            ->get();
    }

    public function render()
    {
        return view('livewire.book-authors');
    }
}
