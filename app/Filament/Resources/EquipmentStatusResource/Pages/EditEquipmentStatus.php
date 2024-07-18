<?php

namespace App\Filament\Resources\EquipmentStatusResource\Pages;

use App\Filament\Resources\EquipmentStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentStatus extends EditRecord
{
    protected static string $resource = EquipmentStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
