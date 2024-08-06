<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentsResource\Pages;
use App\Filament\Resources\PaymentsResource\RelationManagers;
use App\Models\Payments;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class PaymentsResource extends Resource
{
    protected static ?string $model = Payments::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'description')
                    ->label("Order Number")
                    ->required(),
                Forms\Components\TextInput::make('payerEmail')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('payerMobile')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('paymentMode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pollUrl')
                    ->maxLength(255),
                Forms\Components\TextInput::make('totalBill')
                    ->prefix("$")
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.description')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payerEmail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payerMobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paymentMode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pollUrl')
                    ->searchable(),
                Tables\Columns\TextColumn::make('totalBill')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(function ($record) {
                return null;
            });
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayments::route('/create'),
            'edit' => Pages\EditPayments::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }

//    public static function infolist(Infolist $infolist): Infolist
//    {
//        return $infolist
//            ->schema([
//                Infolists\Components\TextEntry::make('name'),
//                Infolists\Components\TextEntry::make('payerEmail'),
////                Infolists\Components\TextEntry::make('notes')
////                    ->columnSpanFull(),
//            ]);
//    }
}
