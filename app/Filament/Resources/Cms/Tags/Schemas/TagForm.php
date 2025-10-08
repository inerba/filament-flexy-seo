<?php

namespace App\Filament\Resources\Cms\Tags\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TagForm
{
    use \App\Traits\CmsUtils;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome del tag')
                    ->required()
                    ->translatableTabs()
                    ->extraAttributes(fn () => self::isMultilingual() ? [] : ['class' => 'hide-tabs'])
                    ->columnSpanFull(),
            ]);
    }
}
