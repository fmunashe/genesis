<?php

namespace App\Observers;

use App\Models\Allocation;
use App\Models\Equipment;

class AllocationObserver
{
    /**
     * Handle the Allocation "created" event.
     */
    public function created(Allocation $allocation): void
    {
        $allocation->equipment->update([
            'allocation_status' => true
        ]);
        $this->updateAllEquipment();
    }

    /**
     * Handle the Allocation "updated" event.
     */
    public function updated(Allocation $allocation): void
    {
        $allocation->equipment->update([
            'allocation_status' => true
        ]);
        $this->updateAllEquipment();
    }

    /**
     * Handle the Allocation "deleted" event.
     */
    public function deleted(Allocation $allocation): void
    {
        $allocation->equipment->update([
            'allocation_status' => false
        ]);
        $this->updateAllEquipment();
    }

    /**
     * Handle the Allocation "restored" event.
     */
    public function restored(Allocation $allocation): void
    {
        //
    }

    /**
     * Handle the Allocation "force deleted" event.
     */
    public function forceDeleted(Allocation $allocation): void
    {
        //
    }

    private function updateAllEquipment(): void
    {
        $allocationIds = Allocation::query()->pluck('equipment_id', 'equipment_id')->toArray();
        Equipment::query()->whereNotIn('id', $allocationIds)->update([
            'allocation_status' => false
        ]);
    }
}
