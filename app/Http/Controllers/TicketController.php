<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;

class TicketController extends BaseController
{

    public function index(): JsonResponse
    {
        $tickets = Ticket::query()->where('status', '=', true)->paginate(10);
        return $this->buildSuccessResponse($tickets, 'Tickets retrieved successfully');
    }


    public function store(StoreTicketRequest $request): JsonResponse
    {
        $data = $request->all();
        $ticket = Ticket::query()->create([
            'eventName' => $data['eventName'],
            'eventVenue' => $data['eventVenue'],
            'price' => $data['price'],
            'ageRestriction' => $data['ageRestriction'],
            'eventDate' => $data['eventDate'],
            'startTime' => $data['startTime'],
            'endTime' => $data['endTime'],
            'entrance' => $data['entrance']
        ]);
        return $this->buildSuccessResponse($ticket, "Ticket created successfully");
    }


    public function show(Ticket $ticket): JsonResponse
    {
        return $this->buildSuccessResponse($ticket, "Ticket retrieved successfully");
    }


    public function update(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $data = $request->all();
        $updatedTicket = $ticket->update([
            'eventName' => $data['eventName'],
            'eventVenue' => $data['eventVenue'],
            'price' => $data['price'],
            'ageRestriction' => $data['ageRestriction'],
            'eventDate' => $data['eventDate'],
            'startTime' => $data['startTime'],
            'endTime' => $data['endTime'],
            'entrance' => $data['entrance'],
            'status' => $data['status'],
        ]);
        return $this->buildSuccessResponse($updatedTicket, "Ticket updated successfully");
    }


    public function destroy(Ticket $ticket): JsonResponse
    {
        $ticket->delete();
        return $this->buildSuccessResponse($ticket, "Ticket removed successfully");
    }
}
