<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketTypeRequest;
use App\Http\Requests\UpdateTicketTypeRequest;
use App\Models\TicketType;
use Illuminate\Http\JsonResponse;

class TicketTypeController extends BaseController
{

    public function index(): JsonResponse
    {
        $ticketTypes = TicketType::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($ticketTypes, "Ticket types retrieved successfully");
    }


    public function store(StoreTicketTypeRequest $request): JsonResponse
    {
        $data = $request->all();
        $type = TicketType::query()->create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        return $this->buildSuccessResponse($type, "Ticket type saved successfully");
    }


    public function show(TicketType $ticketType): JsonResponse
    {
        return $this->buildSuccessResponse($ticketType, "Ticket type retrieved successfully");
    }


    public function update(UpdateTicketTypeRequest $request, TicketType $ticketType): JsonResponse
    {
        $data = $request->all();
        $updatedTicketType = $ticketType->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        return $this->buildSuccessResponse($updatedTicketType, "Ticket type updated successfully");
    }


    public function destroy(TicketType $ticketType): JsonResponse
    {
        $ticketType->delete();
        return $this->buildSuccessResponse($ticketType, "Ticket type removed successfully");
    }
}
