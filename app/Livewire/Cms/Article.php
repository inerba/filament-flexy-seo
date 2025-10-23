<?php

namespace App\Livewire\Cms;

use App\Models\Cms\Article as ArticleModel;
use Livewire\Component;

class Article extends Component
{
    public $article;

    public $category;

    public function mount(string $category, ArticleModel $article)
    {
        $this->category = $category;
        $this->article = $article;
    }

    public function render()
    {
        // Verifica se l'articolo è pubblicato
        if ($this->article->published_at < now() && $this->article->published_at !== null) {

            // Registra la visita all'articolo
            $this->article->vzt()->increment();

            // Restituisci la vista con l'articolo trovato
            return view($this->article->getViewName());
        }

        // Se l'articolo non è pubblicato, mostra una pagina di errore 404
        return abort(404);
    }
}
