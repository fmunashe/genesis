<?php

namespace App\Filament\Resources\TicketTypeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'tickets';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('banner')
                    ->label("Event Banner / Flyer Image")
                    ->directory('uploads')
                    ->visibility('public')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('eventName')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('eventVenue')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('ageRestriction')
                    ->numeric()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('eventDate')
                    ->required(),
                Forms\Components\DateTimePicker::make('startTime')
                    ->required(),
                Forms\Components\DateTimePicker::make('endTime')
                    ->required(),
                Forms\Components\TextInput::make('entrance')
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    /**
     * @throws \Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('banner'),
                Tables\Columns\TextColumn::make('eventName'),
                Tables\Columns\TextColumn::make('eventVenue'),
                Tables\Columns\TextColumn::make('eventDate'),
                Tables\Columns\TextColumn::make('startTime'),
                Tables\Columns\TextColumn::make('endTime'),
                Tables\Columns\IconColumn::make('status')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('price')
                ->money(),
                Tables\Columns\TextColumn::make('ageRestriction'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label("Ticket Status")
                    ->multiple()
                    ->options([
                        true => 'Active',
                        false => 'Lapsed Events'
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
