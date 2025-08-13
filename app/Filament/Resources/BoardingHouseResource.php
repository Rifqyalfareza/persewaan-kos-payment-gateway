<?php

namespace App\Filament\Resources;

use Dom\Text;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\BoardingHouse;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Modal\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BoardingHouseResource\Pages;
use Filament\Tables\Actions\ActionGroup as ActionsActionGroup;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('General Information')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('address')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('categories_id')
                                    ->label('Category')
                                    ->relationship('categories', 'category_name')
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('category_name')
                                            ->required()
                                            ->maxLength(255)
                                            ->reactive()
                                            ->debounce(500)
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                $set('slug', Str::slug($state));
                                            }),
                                        TextInput::make('slug')
                                            ->required()
                                            ->disabled()
                                            ->maxLength(255)
                                            ->dehydrated(),
                                    ]),
                                RichEditor::make('description')
                                    ->required()
                                    ->maxLength(65535)
                                    ->columnSpan('full'),
                                FileUpload::make('thumbnail')
                                    ->image()
                                    ->required()
                                    ->maxSize(1024)
                                    ->directory('boarding-houses')
                                    ->columnSpan('full'),
                            ])
                            ->columns(3),

                        Tabs\Tab::make('Rooms & Facilities')
                            ->schema([
                                Repeater::make('rooms')
                                    ->relationship('rooms')
                                    ->columns(2)
                                    ->collapsed()
                                    ->itemLabel(fn(array $state): ?string => $state['room_name'] ?? 'New Room')
                                    ->cloneable()
                                    ->addActionLabel('Add Another Room')
                                    ->schema([
                                        TextInput::make('room_name')
                                            ->label('Room Name')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('room_type')
                                            ->label('Room Type')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('square_feet')
                                            ->label('Square Feet')
                                            ->numeric()
                                            ->required()
                                            ->maxValue(10000)
                                            ->minValue(1),

                                        TextInput::make('price_per_month')
                                            ->label('Price Per Month')
                                            ->numeric()
                                            ->required()
                                            ->prefix('IDR')
                                            ->minValue(1),

                                        Toggle::make('is_available')
                                            ->default(true)
                                            ->label('Is Available')
                                            ->inline()
                                            ->onColor('success')
                                            ->offColor('danger'),

                                        Grid::make(2)
                                            ->schema([
                                                Repeater::make('roomImages')
                                                    ->relationship('roomImage')
                                                    ->label('Room Images')
                                                    ->schema([
                                                        FileUpload::make('image')
                                                            ->image()
                                                            ->required()
                                                            ->maxSize(1024)
                                                            ->directory('room-images'),
                                                    ])
                                                    ->columns(1),

                                                Repeater::make('facilities')
                                                    ->relationship('facilities')
                                                    ->label('Room Facilities')
                                                    ->schema([
                                                        TextInput::make('facilities_name')
                                                            ->required()
                                                            ->label('Facility Name'),
                                                    ])
                                                    ->columns(1),
                                            ])
                                            ->columnSpan('full'), 
                                    ])
                            ])

                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->searchable()
                    ->rowIndex(),
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Kost Name'),
                TextColumn::make('categories.category_name')
                    ->searchable()
                    ->sortable()
                    ->label('Category')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('address')
                    ->searchable()
                    ->sortable()
                    ->label('Address')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->address),
                TextColumn::make('description')
                    ->limit(50)
                    ->html()
                    ->sortable()
                    ->label('Description'),
                TextColumn::make('rooms.room_name')
                    ->label('Rooms')
                    ->formatStateUsing(function ($record) {
                        $rooms = $record->rooms->pluck('room_type')->join(', ');
                        return $rooms ?: 'No rooms';
                    })
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->rooms->pluck('room_type')->join(', ');
                    }),
                // TextColumn::make('rooms.price_per_month')
                //     ->label('Price Per Month')
                //     ->money('IDR', true)
                //     ->formatStateUsing(function ($record) {
                //         $prices = $record->rooms->pluck('price_per_month')->join(' - ');
                //         return $prices ?: 'No price';
                //     })
                //     ->badge()
                //     ->color('success'),
                // TextColumn::make('rooms.is_available')
                //     ->label('Availability')
                    // ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionsActionGroup::make([
                    Tables\Actions\ViewAction::make()->color('info'),
                    Tables\Actions\EditAction::make()->color('primary'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }
}
