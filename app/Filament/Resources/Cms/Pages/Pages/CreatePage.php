<?php

namespace App\Filament\Resources\Cms\Pages\Pages;

use App\Filament\Resources\Cms\Pages\PageResource;
use App\Models\Cms\Page;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class CreatePage extends CreateRecord
{
    use HasPreviewModal;

    protected static string $resource = PageResource::class;

    protected static ?string $title = 'Crea Pagina';

    protected static ?string $breadcrumb = 'Nuova';

    protected function getActions(): array
    {
        return [
            PreviewAction::make()
                ->hidden(fn () => ! view()->exists($this->getPreviewModalView()))
                ->label('Anteprima')
                ->icon(Phosphor::EyeDuotone),
            Action::make('salva')
                ->label('Salva')
                ->icon(Phosphor::FloppyDiskDuotone)
                ->action('create')
                ->color('primary')
                ->button(),
        ];
    }

    protected function getPreviewModalView(): ?string
    {
        $tempPage = (new Page);
        $tempPage->extras = $this->data['extras'];

        return $tempPage->getViewName().'_preview';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'page';
    }
}
