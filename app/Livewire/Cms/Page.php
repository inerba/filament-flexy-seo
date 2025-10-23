<?php

namespace App\Livewire\Cms;

use App\Models\Cms\Page as PageModel;
use Livewire\Component;

class Page extends Component
{
    public $page;

    public function mount($slug)
    {
        $slugs = explode('/', $slug);

        $this->page = $this->findPage($slugs);
    }

    public function render()
    {
        // Registra la visita alla pagina https://github.com/awssat/laravel-visits/blob/master/docs/6_retrieve-visits-and-stats.md
        $this->page->vzt()->increment();

        // Restituisci la vista con la pagina trovata
        return view($this->page->getViewName(), ['page' => $this->page]);
    }

    /**
     * Trova la pagina corrispondente agli slug forniti.
     *
     * @param  string[]  $slugs  Un array di slug (stringhe) che rappresentano la gerarchia della pagina.
     * @param  PageModel|null  $parentPage  La pagina padre, se esiste.
     * @return PageModel|null La pagina trovata o null se non esiste.
     */
    private function findPage(array $slugs, ?PageModel $parentPage = null): ?PageModel
    {
        // Prendi il primo slug dall'array
        $slug = array_shift($slugs);

        // Se abbiamo una pagina padre, cerchiamo una sottopagina
        if ($parentPage) {
            /** @var PageModel $page */
            $page = $parentPage->children()->where('slug', $slug)->firstOrFail();
        } else {
            // Altrimenti, cerchiamo una pagina padre
            $page = PageModel::where('slug', $slug)->whereNull('parent_id')->firstOrFail();
        }

        // Se ci sono ancora slug nell'array, cerchiamo la sottopagina corrispondente
        if (! empty($slugs)) {
            return $this->findPage($slugs, $page);
        }

        // Se non ci sono più slug, abbiamo trovato la nostra pagina
        return $page;
    }
}
