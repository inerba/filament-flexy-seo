<?php

namespace App\Filament\Resources\Cms\Menus\Widgets;

use App\Filament\Resources\Cms\Menus\MenuTypes;
use App\Models\Cms\Menu;
use App\Models\Cms\Menuitem;
use Filament\Actions\CreateAction as FilamentActionsCreateAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use SolutionForest\FilamentTree\Actions\Action;
use SolutionForest\FilamentTree\Actions\ActionGroup;
use SolutionForest\FilamentTree\Actions\CreateAction;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
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
                ->translatableTabs()->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs']),

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
            Action::make('replicate')
                ->tooltip('Duplica elemento')
                ->modalHeading('Duplica elemento')
                ->modalDescription('Sei sicuro di voler duplicare questo elemento?')
                ->icon(Phosphor::CopyDuotone)
                ->iconButton()
                ->schema([
                    Select::make('menu_id')
                        ->label('Menu di destinazione')
                        ->options(function () {
                            $query = Menu::query();
                            if ($this->record?->id) {
                                $query->where('id', '!=', $this->record->id);
                            }

                            return $query->pluck('title', 'id')->toArray();
                        })
                        ->default($this->record?->id)->required(),
                ])
                ->action(function (array $data): void {
                    // Copia tutto l'albero dei menuitems nel menu di destinazione
                    $sourceMenuId = $this->record?->id;
                    $destMenuId = $data['menu_id'] ?? null;

                    if (! $sourceMenuId || ! $destMenuId) {
                        Notification::make()
                            ->danger()
                            ->title('Menu sorgente o destinazione non valido')
                            ->send();

                        return;
                    }

                    if ($sourceMenuId == $destMenuId) {
                        Notification::make()
                            ->warning()
                            ->title('Hai selezionato lo stesso menu: niente da copiare')
                            ->send();

                        return;
                    }

                    try {
                        DB::transaction(function () use ($sourceMenuId, $destMenuId): void {
                            $this->replicateMenuItems($sourceMenuId, $destMenuId);
                        });

                        Notification::make()
                            ->success()
                            ->title('Elementi replicati con successo')
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->danger()
                            ->title('Errore durante la replica degli elementi')
                            ->body($e->getMessage())
                            ->send();
                    }
                })
                ->requiresConfirmation(),
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
            Action::make('type')
                ->label(fn (?Model $record) => $record ? Str::of($record->type)->replace('_', ' ')->upper()->toString() : '')
                ->tooltip(fn (?Model $record) => $record ? $record->url : false)
                ->icon('heroicon-o-tag')
                ->size('xs')
                ->color('gray')
                ->disabled(),
            EditAction::make()->tooltip('Modifica elemento'),
            Action::make('replicate')
                ->tooltip('Duplica elemento')
                ->modalHeading('Duplica elemento')
                ->modalDescription('Sei sicuro di voler duplicare questo elemento?')
                ->icon(Phosphor::CopyDuotone)
                ->iconButton()
                ->schema([
                    Select::make('menu_id')
                        ->label('Menu di destinazione')
                        ->relationship('menu', 'title')
                        ->default($this->record?->id)->required(),
                ])
                ->action(function (array $data, Menuitem $record): void {
                    $newRecord = $record->replicate();
                    $newRecord->menu_id = $data['menu_id'];
                    $newRecord->push();

                    Notification::make()
                        ->success()
                        ->title('Elemento replicato con successo')
                        ->send();
                })
                ->requiresConfirmation(),
            DeleteAction::make()->tooltip('Elimina elemento'),
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

    /**
     * Replicate all menu items from a source menu to a destination menu preserving hierarchy.
     */
    protected function replicateMenuItems(int $sourceMenuId, int $destMenuId): void
    {
        $roots = Menuitem::query()
            ->where('menu_id', $sourceMenuId)
            ->where('parent_id', -1)
            ->orderBy('order')
            ->get();

        foreach ($roots as $root) {
            $this->replicateItemRecursive($root, null, $destMenuId);
        }
    }

    /**
     * Recursively replicate a Menuitem and its children.
     */
    protected function replicateItemRecursive(Menuitem $item, ?int $newParentId, int $destMenuId): Menuitem
    {
        $new = $item->replicate();
        $new->menu_id = $destMenuId;
        $new->parent_id = $newParentId;
        // Preserve order and other fillable attributes are already copied by replicate()
        $new->save();

        $children = Menuitem::query()
            ->where('parent_id', $item->id)
            ->orderBy('order')
            ->get();

        foreach ($children as $child) {
            $this->replicateItemRecursive($child, $new->id, $destMenuId);
        }

        return $new;
    }
}
