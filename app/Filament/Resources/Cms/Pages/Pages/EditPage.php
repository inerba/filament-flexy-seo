<?php

namespace App\Filament\Resources\Cms\Pages\Pages;

use App\Filament\Resources\Cms\Pages\PageResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class EditPage extends EditRecord
{
    use HasPreviewModal;

    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make()
                ->hidden(fn () => ! view()->exists($this->getPreviewModalView()))
                ->label('Anteprima')
                ->icon(Phosphor::EyeDuotone),
            Action::make('salva')
                ->label('Salva')
                ->icon(Phosphor::FloppyDiskDuotone)
                ->action('save')
                ->color('primary')
                ->button(),
            DeleteAction::make(),
        ];
    }

    protected function getPreviewModalView(): ?string
    {
        return $this->record->getViewName().'_preview';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'page';
    }
}
