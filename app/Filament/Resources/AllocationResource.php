<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllocationResource\Pages;
use App\Filament\Resources\AllocationResource\RelationManagers;
use App\Models\Allocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class AllocationResource extends Resource
{
    protected static ?string $model = Allocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-signal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('equipment_id')
                    ->relationship('equipment', 'name', function ($query) {
                        return $query->where('allocation_status', false);
                    })
                    ->searchable()
                    ->preload()
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
                    ->label('Allocated User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.company.name')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment.equipmentStatus.status')
                    ->label("Equipment Status")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment.equipmentID')
                    ->label("Equipment ID")
                    ->searchable()
                    ->sortable(),
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
                SelectFilter::make('Company')
                    ->multiple()
                    ->options([
                        'name' => 'Name'
                    ])
                    ->relationship('user.company', 'name')
                    ->preload(),

                SelectFilter::make('Equipment Status')
                    ->multiple()
                    ->options([
                        'Old' => 'Old',
                        'Brand New' => 'Brand New',
                        'Fairly New' => 'Fairly New'
                    ])
                    ->relationship('equipment.equipmentStatus', 'status')
                    ->preload(),

                SelectFilter::make('Allocated User')
                    ->multiple()
                    ->options([
                        'name' => 'Name'
                    ])
                    ->relationship('user', 'name')
                    ->preload()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->beforeFormFilled(function (EditAction $action) {
                        // Runs before the form fields are populated from the database.
                        Log::info("action is ",[$action]);
                        Log::info("record is ",[$this->record]);
                    }),
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
            'index' => Pages\ListAllocations::route('/'),
            'create' => Pages\CreateAllocation::route('/create'),
            'edit' => Pages\EditAllocation::route('/{record}/edit'),
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::updating(function (Allocation $allocation) {
            // Capture the previous record values
            $original = $allocation->getOriginal();
            Log::info('Previous Record:', $original);
        });

        static::updated(function (Allocation $allocation) {
            // Capture the new record values
            Log::info('New Record:', $allocation->getAttributes());
        });
    }
}
