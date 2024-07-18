<?php

namespace App\Filament\Widgets;

use App\Models\Equipment;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class EquipmentAllocationOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $allocationStatus = $this->filters['allocationStatus'] ?? null;
        if ($allocationStatus != null) {
            $allocationStatus = $allocationStatus == "Allocated" ? 1 : 0;
        }
        return [
            BaseWidget\Stat::make(
                label: 'Total Equipment',
                value: Equipment::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->when($allocationStatus, fn(Builder $query) => $query->where('allocation_status', '=', $allocationStatus))
                    ->count(),
            ),
            BaseWidget\Stat::make(
                label: 'Total Allocated Equipment',
                value: Equipment::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->where('allocation_status','=',1)
                    ->count(),
            ),

            BaseWidget\Stat::make(
                label: 'Total Available Equipment',
                value: Equipment::query()
                    ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                    ->where('allocation_status','=',0)
                    ->count(),
            ),
            // ...
        ];
    }
}
