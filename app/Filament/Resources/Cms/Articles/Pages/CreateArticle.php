<?php

namespace App\Filament\Resources\Cms\Articles\Pages;

use App\Filament\Resources\Cms\Articles\ArticleResource;
use App\Models\Cms\Article;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class CreateArticle extends CreateRecord
{
    use HasPreviewModal;

    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = $data['user_id'] ?? auth()->id();

        return $data;
    }

    protected function getActions(): array
    {
        return [
            PreviewAction::make()
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
        $tempArticle = (new Article);
        $tempArticle->extras = $this->data['extras'];

        return $tempArticle->getViewName().'_preview';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'article';
    }
}
