<?php

namespace App\Filament\Resources\BookAuthors\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BookAuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(5)
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, callable $get, ?string $state) {
                                if ($get('lock_slug')) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),

                        Hidden::make('lock_slug')
                            ->live(false, 500)
                            ->dehydrated(false)
                            ->afterStateHydrated(fn (callable $set, $context) => $set('lock_slug', $context === 'edit')),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->disabled(fn (callable $get) => $get('lock_slug'))
                            ->hintActions(
                                [
                                    Action::make('toggle_lock_slug')
                                        ->tooltip(fn (callable $get) => $get('lock_slug') ? 'Sblocca' : 'Blocca')
                                        ->icon(fn (callable $get) => $get('lock_slug') ? 'heroicon-s-lock-closed' : 'heroicon-s-lock-open')
                                        ->iconButton()
                                        ->action(fn (callable $set, callable $get) => $set('lock_slug', ! $get('lock_slug'))),
                                    Action::make('permalink')
                                        ->hidden(fn ($context) => $context === 'create')
                                        ->link()
                                        ->icon('heroicon-m-link')
                                        ->iconButton()
                                        ->color('gray')
                                        ->url(fn ($record) => $record?->permalink, true)
                                        ->tooltip('Vai alla pagina'),
                                ]
                            )
                            ->rules(['alpha_dash'])
                            ->unique(ignoreRecord: true)
                            ->required(),

                        RichEditor::make('bio')
                            ->label('Biografia')
                            ->required()
                            ->columnSpanFull(),
                    ])->columnSpan(4),

                SpatieMediaLibraryFileUpload::make('avatar')
                    ->label('Avatar')
                    ->directory('book/authors')
                    ->disk('public')
                    ->visibility('public')
                    ->collection('avatars')
                    ->avatar()
                    ->imageEditor()
                    ->hiddenLabel(),
            ]);
    }
}
