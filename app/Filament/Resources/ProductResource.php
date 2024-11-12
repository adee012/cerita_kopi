<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([

                        //image
                        Forms\Components\FileUpload::make('image')
                            ->label('Image')
                            ->required(),

                        //grid
                        Forms\Components\Grid::make(2)
                            ->schema([

                                //product_name
                                Forms\Components\TextInput::make('product_name')
                                    ->label('Product Name')
                                    ->placeholder('Product Name')
                                    ->required(),

                                //category
                                Forms\Components\Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'category_name')
                                    ->required(),
                            ]),

                        //grid
                        Forms\Components\Grid::make(2)
                            ->schema([

                                //status
                                Forms\Components\TextInput::make('status')
                                    ->label('Status')
                                    ->default(true)
                                    ->disabled(),

                                //product_description
                                Forms\Components\TextInput::make('product_description')
                                    ->label('Product Description')
                                    ->placeholder('Product Description')
                                    ->required(),
                            ]),



                        Forms\Components\Grid::make(2)
                            ->schema([

                                //price
                                Forms\Components\TextInput::make('price')
                                    ->label('Price')
                                    ->placeholder('Price')
                                    ->required()
                                    ->numeric()
                                    ->minValue(4),

                                //stock
                                Forms\Components\TextInput::make('stock')
                                    ->label('Stock')
                                    ->placeholder('Stock')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1),

                            ]),

                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->circular(),
                Tables\Columns\TextColumn::make('product_name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make('product_description')->label('Description'),
                Tables\Columns\TextColumn::make('price')->label('Price'),
                Tables\Columns\TextColumn::make('stock')->label('Stock'),
                Tables\Columns\TextColumn::make('status')->label('Status')->getStateUsing(function ($record) {
                    return $record->status == 1 ? 'Aktif' : 'Non-Aktif';
                }),
                Tables\Columns\TextColumn::make('category.category_name')->label('Category'),
                Tables\Columns\TextColumn::make('user.name')->label('Created By')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
