<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Filament\Resources\EquipmentResource\RelationManagers;
use App\Models\Equipment;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Captured By')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('equipment_status_id')
                    ->relationship('equipmentStatus', 'status')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Equipment Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('equipmentID')
                    ->label('Equipment ID')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Equipment Description')
                    ->required(),
                Forms\Components\Toggle::make('allocation_status')
                    ->label('Allocated ?')
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Captured By')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipmentStatus.status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipmentID')
                    ->label("Equipment ID")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('allocation.user.name')
                    ->label("Assignee")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('allocation_status')
                    ->sortable()
                    ->boolean(),
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
                SelectFilter::make('allocation_status')
                    ->label('Allocation Status')
                    ->multiple()
                    ->options([
                        true => 'Allocated',
                        false => 'Vacant'
                    ]),

                SelectFilter::make('Equipment Status')
                    ->multiple()
                    ->options([
                        'Old' => 'Old',
                        'Brand New' => 'Brand New',
                        'Fairly New' => 'Fairly New'
                    ])
                    ->relationship('equipmentStatus', 'status')
                    ->preload(),

                SelectFilter::make('Captured By')
                    ->multiple()
                    ->options([
                        'name' => 'Name'
                    ])
                    ->relationship('user', 'name')
                    ->preload()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}
