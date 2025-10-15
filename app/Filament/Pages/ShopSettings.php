<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class ShopSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'Shop';

    public static function getNavigationGroup(): ?string
    {
        return 'Shop';
    }

    // protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver'; // Uncomment if you want to set a custom navigation icon

    // protected ?string $subheading = ''; // Uncomment if you want to set a custom subheading

    // protected static ?string $slug = 'shop-settings'; // Uncomment if you want to set a custom slug

    protected string $view = 'filament.pages.shop-settings';

    protected function settingName(): string
    {
        return 'shop';
    }

    /**
     * Provide default values.
     *
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        return [
            'enable_shipping' => true,
            'enable_free_shipping' => true,
            'free_shipping_threshold' => 50,
            'shipping_costs' => [
                [
                    'display_name' => 'Corriere',
                    'type' => 'fixed_amount',
                    'amount' => 5,
                    'currency' => 'eur',
                    'minimum' => [
                        'unit' => 'business_day',
                        'value' => 2,
                    ],
                    'maximum' => [
                        'unit' => 'business_day',
                        'value' => 5,
                    ],
                ],
            ],
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Spedizioni')
                            ->icon(Phosphor::PackageDuotone)
                            ->schema([
                                Toggle::make('enable_shipping')
                                    ->live()
                                    ->label('Abilita spedizioni')
                                    ->helperText('Abilita o disabilita la gestione delle spedizioni nello shop.')
                                    ->default(true),
                                Toggle::make('enable_free_shipping')
                                    ->visible(fn (callable $get) => $get('enable_shipping') === true)
                                    ->live()
                                    ->label('Abilita spedizione gratuita')
                                    ->helperText('Abilita o disabilita la spedizione gratuita per ordini superiori a una certa soglia.')
                                    ->default(true),
                                TextInput::make('free_shipping_threshold')
                                    ->visible(fn (callable $get) => $get('enable_free_shipping') === true && $get('enable_shipping') === true)
                                    ->label('Soglia per spedizione gratuita')
                                    ->suffix('€')
                                    ->numeric()
                                    ->default(50)
                                    ->required(fn (callable $get) => $get('enable_free_shipping') === true),

                                Repeater::make('shipping_costs')
                                    ->visible(fn (callable $get) => $get('enable_shipping') === true)
                                    ->label('Costi di spedizione')
                                    ->itemLabel(function (array $state): ?string {
                                        $display = $state['display_name'] ?? null;
                                        $amount = $state['amount'] ?? null;

                                        if ($amount === null && $display === null) {
                                            return null;
                                        }

                                        $unit = (($state['type'] ?? 'fixed_amount') === 'fixed_amount') ? '€' : '%';

                                        if ($display) {
                                            return $display.' - '.$amount.$unit;
                                        }

                                        return $amount.$unit;
                                    })
                                    ->schema([
                                        TextInput::make('display_name')
                                            ->label('Nome visualizzato')
                                            ->required(),
                                        Hidden::make('type')->default('fixed_amount'),
                                        TextInput::make('amount')
                                            ->label('Importo')
                                            ->suffix('€')
                                            ->numeric()
                                            ->required(),
                                        Hidden::make('currency')->default('eur'),
                                        Section::make('Stima tempi di consegna')
                                            ->columnSpanFull()
                                            ->columns(2)
                                            ->schema([
                                                Fieldset::make('Minimo')
                                                    ->schema([
                                                        Select::make('minimum.unit')
                                                            ->label('Unità')
                                                            ->options([
                                                                'business_day' => 'Giorno lavorativo',
                                                                'day' => 'Giorno di calendario',
                                                                'week' => 'Settimana',
                                                                'hour' => 'Ora',
                                                                'month' => 'Mese',
                                                            ])
                                                            ->default('business_day')
                                                            ->required(),
                                                        TextInput::make('minimum.value')
                                                            ->label('Valore')
                                                            ->numeric()
                                                            ->required(),
                                                    ]),
                                                Fieldset::make('Massimo')
                                                    ->schema([
                                                        Select::make('maximum.unit')
                                                            ->label('Unità')
                                                            ->options([
                                                                'business_day' => 'Giorno lavorativo',
                                                                'day' => 'Giorno di calendario',
                                                                'week' => 'Settimana',
                                                                'hour' => 'Ora',
                                                                'month' => 'Mese',
                                                            ])
                                                            ->default('business_day')
                                                            ->required(),
                                                        TextInput::make('maximum.value')
                                                            ->label('Valore')
                                                            ->numeric()
                                                            ->required(),
                                                    ]),
                                            ]),
                                    ])
                                    ->addActionLabel('Aggiungi costo di spedizione')
                                    ->columns(2),
                            ]),
                        Tab::make('Tab 2')
                            ->schema([
                                // ...
                            ]),
                        Tab::make('Tab 3')
                            ->schema([
                                // ...
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    // public function save(): void
    // {

    //     $state = $this->form->getState();

    //     dump($state);

    //     parent::save();

    // }
}
