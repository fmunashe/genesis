<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QRCodeResource\Pages;
use App\Filament\Resources\QRCodeResource\RelationManagers;
use App\Http\Controllers\QRcodeController;
use App\Models\QRCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class QRCodeResource extends Resource
{
    protected static ?string $model = QRcode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected string $controller = QRcodeController::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('used')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\IconColumn::make('used')
                    ->label('Verified And Used')
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
                //
            ])
            ->actions([
                Action::make('customSave')
                    ->label('Verify And Admit')
                    ->action(function (QRCode $record, array $data): void {
                        if ($data['confirm']) {
                            $code = $record->code;
                            $controller = new QRcodeController();
                            $response = $controller->verify($code);
                            $responseData = $response->getData(true);
                            if ($responseData['success']) {
                                Notification::make()
                                    ->title('Success')
                                    ->body($responseData['message'])
                                    ->success()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('Error')
                                    ->body($responseData['message'])
                                    ->danger()
                                    ->send();
                            }
                        } else {
                            Notification::make()
                                ->title('Error')
                                ->body("Please Confirm Code verification To Proceed")
                                ->danger()
                                ->send();
                        }

                    })
                    ->form([
                        Forms\Components\Toggle::make('confirm')
                            ->label("Confirm Code Verification")
                            ->required()
                    ]),
                Tables\Actions\ViewAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(function ($record) {
                return null;
            })
            ->headerActions([
                // Add or remove header actions, but do not include the Create action
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
            'index' => Pages\ListQRCodes::route('/'),
            'create' => Pages\CreateQRCode::route('/create'),
            'edit' => Pages\EditQRCode::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
