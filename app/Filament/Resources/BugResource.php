<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BugResource\Pages;
use App\Filament\Resources\BugResource\RelationManagers;
use App\Models\Bug;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BugResource extends Resource
{
    protected static ?string $model = Bug::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    // ->disabled()
                    ->required(),
                Forms\Components\Toggle::make('resolved')
                    ->label('Resolvido?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->prefix('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('resolved')
                    ->label('Resolvido?')
                    ->sortable()
                    ->boolean(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('resolved')
                    ->label('Resolvido')
                    ->options([
                        0 => 'Não',
                        1 => 'Sim',
                    ])
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
            'index' => Pages\ListBugs::route('/'),
            'create' => Pages\CreateBug::route('/create'),
            'edit' => Pages\EditBug::route('/{record}/edit'),
        ];
    }
}
