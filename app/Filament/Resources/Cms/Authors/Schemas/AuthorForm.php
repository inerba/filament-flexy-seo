<?php

namespace App\Filament\Resources\Cms\Authors\Schemas;

use App\Models\User;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(4)
            ->components([
                Group::make()
                    ->columns(2)
                    ->schema([

                        Select::make('user_id')
                            ->label('Utente associato')
                            ->hidden(fn () => ! auth()->user()->isAdmin())
                            ->searchable()
                            ->getSearchResultsUsing(function (?string $search = null): array {
                                $record = request()->route('record');
                                $assignedUserId = null;

                                if ($record instanceof \App\Models\Cms\Author) {
                                    $assignedUserId = $record->user_id;
                                } elseif (filled($record)) {
                                    $author = \App\Models\Cms\Author::find($record);
                                    $assignedUserId = $author?->user_id;
                                }

                                $query = User::query()->where(function ($q) use ($assignedUserId) {
                                    $q->whereDoesntHave('author');

                                    if ($assignedUserId) {
                                        $q->orWhere('id', $assignedUserId);
                                    }
                                });

                                if (filled($search)) {
                                    $query->where('name', 'like', "%{$search}%");
                                }

                                return $query->orderBy('name')->limit(50)->pluck('name', 'id')->all();
                            })
                            ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name)
                            ->nullable()
                            ->preload()
                            ->afterStateUpdated(fn (callable $set, $state) => $set('full_name', $state ? User::find($state)?->name : ''))
                            ->helperText('Collega questo autore a un utente del sistema.'),

                        TextInput::make('full_name')
                            ->label('Nome completo')
                            ->default(function (string $context) {
                                if (auth()->user()->isAdmin()) {
                                    return null;
                                }

                                return $context === 'create' ? auth()->user()->name : null;
                            })
                            ->required(),

                        RichEditor::make('bio')
                            ->label('Biografia')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'bulletList',
                                'orderedList',
                                'link',
                                'blockquote',
                            ])
                            ->columnSpanFull(),
                    ])->columnSpan(3),
                Group::make()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('avatar')
                            ->avatar()
                            ->hiddenLabel()
                            ->collection('avatars')
                            ->directory('authors')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor(),
                    ]),
            ]);
    }
}
