<?php

// app/Filament/Resources/AppointmentResource.php
namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Appointment;
use Filament\Resources\Resource;
use Illuminate\Contracts\Database\Query\Builder;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Times;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('client_name')
                    ->required()
                    ->label('Nome do cliente'),

                Forms\Components\TextInput::make('client_cpf')
                    ->required()
                    ->mask('999.999.999-99')
                    ->label('CPF do cliente'),

                Forms\Components\Select::make('service_id')
                    ->label('Serviço')
                    ->required()
                    ->relationship(
                        name: 'service',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query->where('is_active', true)
                    ),

                Forms\Components\DatePicker::make('start_time')
                    ->label('Data')
                    ->required()
                    ->minutesStep(15),

                Forms\Components\Select::make('end_time')
                    ->label('Hora')
                    ->required()
                    ->preload()
                    ->options(function () {
                        $times = [];
                        for ($h = 8; $h < 14; $h++) {
                            $times[sprintf('%02d:00', $h)] = sprintf('%02d:00', $h);
                            $times[sprintf('%02d:30', $h)] = sprintf('%02d:30', $h);
                        }
                        return $times;
                    }),

                Forms\Components\Select::make('status')
                    ->options([
                        'Agendado' => 'Agendado',
                        'Confirmado' => 'Confirmado',
                        'Cancelado' => 'Cancelado',
                        'Concluído' => 'Concluído',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Cliente')
                    ->sortable(),

                Tables\Columns\TextColumn::make('client_cpf')
                    ->label('Cliente')
                    ->sortable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Serviço'),

                Tables\Columns\TextColumn::make('start_time')
                    ->dateTime('d/m/Y')
                    ->label('Data')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_time')
                    ->label('Hora'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->color(fn(string $state): string => match ($state) {
                        'Agendado' => 'info',
                        'Confirmado' => 'success',
                        'Cancelado' => 'danger',
                        'Concluído' => 'primary',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Agendado' => 'Agendado',
                        'Confirmado' => 'Confirmado',
                        'Cancelado' => 'Cancelado',
                        'Concluído' => 'Concluído',
                    ]),

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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Agendamento'; // Ex: "Usuário" no lugar de "User"
    }
}
