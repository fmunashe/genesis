<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('ticket_type_id')
                    ->relationship('ticketType', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
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
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ticketType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('banner')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('eventName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('eventVenue')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ageRestriction')
                    ->searchable(),
                Tables\Columns\TextColumn::make('eventDate')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('startTime')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('endTime')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('entrance')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('status')
                    ->label("Active")
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('Ticket Type')
                    ->multiple()
                    ->options([
                        'Early Bird' => 'Early Bird',
                        'Final Release' => 'Final Release'
                    ])
                    ->relationship('ticketType', 'name')
                    ->preload(),

                SelectFilter::make('status')
                    ->label("Ticket Status")
                    ->multiple()
                    ->options([
                        true => 'Active',
                        false => 'Lapsed Events'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
