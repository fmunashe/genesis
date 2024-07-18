<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\EquipmentAllocationOverview;
use App\Models\Equipment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    // ...
    protected static ?string $title = 'Main dashboard';

    public function getWidgets(): array
    {
//        return Filament::getWidgets();
        return [
            EquipmentAllocationOverview::class
        ];
    }

    public function getColumns(): int|string|array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 3,
        ];
    }

//    public function filtersForm(Form $form): Form
//    {
//        return $form
//            ->schema([
//                Section::make()
//                    ->schema([
//                        DatePicker::make('startDate'),
//                        DatePicker::make('endDate'),
//                        // ...
//                    ])
//                    ->columns(3),
//            ]);
//    }
    /**
     * @throws \Exception
     */
    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->form([
                    DatePicker::make('startDate'),
                    DatePicker::make('endDate'),
                    Select::make("allocationStatus")
                        ->searchable()
                        ->options(
                            Equipment::query()->pluck('allocation_status', 'allocation_status')->toArray()
                        )
                ]),
        ];
    }
}
