<?php

namespace App\Filament\Resources\Cms\Menus\Widgets;

use App\Filament\Resources\Cms\Menus\MenuTypes;
use App\Models\Cms\Menuitem;
use Filament\Actions\CreateAction as FilamentActionsCreateAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use SolutionForest\FilamentTree\Actions\Action;
use SolutionForest\FilamentTree\Actions\ActionGroup;
use SolutionForest\FilamentTree\Actions\CreateAction;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Widgets\Tree;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class MenuItemsTree extends Tree
{
    protected static string $model = Menuitem::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = 'Elementi del menu';

    protected bool $enableTreeTitle = true;

    // Accessing the current record in the widget
    public ?Model $record = null;

    protected function getTreeQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Filter by the current menu ID
        // @phpstan-ignore property.notFound
        return MenuItem::query()->where('menu_id', $this->record->id);
    }

    protected function getFormSchema(): array
    {
        $is_multilingual = count(get_supported_locales()) > 1;

        return [
            Hidden::make('menu_id')
                // @phpstan-ignore property.notFound
                ->default($this->record?->id)->required(),
            Select::make('type')
                ->label('Tipo')
                ->inlineLabel()
                ->live()
                ->options(MenuTypes::getTypes())
                ->default('link')
                ->required(),

            TextInput::make('title')
                ->label('Etichetta')
                ->live(true)
                ->required()
                ->translatableTabs()->extraAttributes(fn () => $is_multilingual ? [] : ['class' => 'hide-tabs']),

            // Link
            Grid::make()
                ->hidden(fn (Get $get) => $get('type') == null)
                ->reactive()
                ->columns(2)
                ->schema(function (Get $get) {
                    return MenuTypes::getFieldsByType($get('type'));
                }),
        ];

    }

    protected function getViewFormSchema(): array
    {
        return [
            // INFOLIST, CAN DELETE
        ];
    }

    protected function getTreeToolbarActions(): array
    {
        return [
            \SolutionForest\FilamentTree\Actions\CreateAction::make(),
        ];
    }

    public function getTreeRecordTitle(?\Illuminate\Database\Eloquent\Model $record = null): string
    {
        if (! $record) {
            return '';
        }

        // Se non fa parte del menu, non mostrare nulla
        if ($record->menu_id != $this->record?->id) {
            return '';
        }

        // return $record->title[app()->getLocale()] ?? 'No title';

        return new HtmlString('<div class="text-base">'.$record->title[app()->getLocale()].'</div>' ?? 'No title');
    }

    protected function configureEditAction(EditAction $action): EditAction
    {
        return $action
            ->slideOver()
            ->schema($this->getFormSchema())
            ->hiddenLabel()
            ->link()
            ->icon(Phosphor::PencilSimple)
            ->modalHeading('Modifica elemento')
            ->modalSubmitActionLabel('Salva');
    }

    protected function configureCreateAction(FilamentActionsCreateAction|CreateAction $action): CreateAction
    {
        $schema = $this->getCreateFormSchema();

        if (empty($schema)) {
            $schema = $this->getFormSchema();
        }

        $action->schema($schema);

        $action->model($this->getModel());

        $this->afterConfiguredCreateAction($action);

        return $action
            ->label('Nuova voce')
            ->slideOver()
            ->schema($this->getFormSchema())
            // ->hiddenLabel()
            // ->link()
            ->color('primary')
            ->icon(Phosphor::Plus)
            ->modalHeading('Crea nuovo elemento')
            ->modalSubmitActionLabel('Crea');
    }

    // Delete action configuration
    protected function configureDeleteAction(DeleteAction $action): DeleteAction
    {
        return $action
            ->hiddenLabel()
            ->modalHeading('Elimina elemento')
            ->modalDescription('Sei sicuro di voler eliminare questo elemento? Questa azione è irreversibile.')
            ->successNotificationTitle('Elemento eliminato con successo')
            ->link()
            ->icon(Phosphor::Backspace);
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    // public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    // {
    //     return null;
    // }

    // CUSTOMIZE ACTION OF EACH RECORD, CAN DELETE
    protected function getTreeActions(): array
    {
        return [
            // Action::make('helloWorld')
            //     ->action(function () {
            //         Notification::make()->success()->title('Hello World')->send();
            //     }),
            // ViewAction::make(),
            Action::make('type')
                ->label(fn (?Model $record) => $record ? Str::of($record->type)->replace('_', ' ')->upper()->toString() : '')
                ->icon('heroicon-o-tag')
                ->size('xs')
                ->color('gray')
                ->disabled(),
            EditAction::make(),
            DeleteAction::make(),
            // ActionGroup::make([
            // ]),
        ];
    }

    // OR OVERRIDE FOLLOWING METHODS
    // protected function hasDeleteAction(): bool
    // {
    //     return true;
    // }

    // protected function hasEditAction(): bool
    // {
    //     return true;
    // }

    // protected function hasViewAction(): bool
    // {
    //    return true;
    // }
}
