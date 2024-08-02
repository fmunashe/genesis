<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class TicketController extends BaseController
{

    public function index(): JsonResponse
    {
        $tickets = Ticket::query()->with('ticketType')->where('status', '=', true)->paginate(10);
        return $this->buildSuccessResponse($tickets, 'Tickets retrieved successfully');
    }


    public function store(StoreTicketRequest $request): JsonResponse
    {
        $data = $request->all();
        $banner = $request->file('banner');
        $path = $banner->store('uploads', 'public');


        $ticket = Ticket::query()->create([
            'banner' => $path,
            'ticket_type_id' => $data['ticket_type_id'],
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
        $ticket->load('ticketType');
        return $this->buildSuccessResponse($ticket, "Ticket retrieved successfully");
    }


    public function update(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $data = $request->all();
        $updatedTicket = $ticket->update([
            'ticket_type_id' => $data['ticket_type_id'],
            'eventName' => $data['eventName'],
            'eventVenue' => $data['eventVenue'],
            'price' => $data['price'],
            'ageRestriction' => $data['ageRestriction'],
            'eventDate' => Carbon::parse($data['eventDate']),
            'startTime' => Carbon::parse($data['startTime']),
            'endTime' => Carbon::parse($data['endTime']),
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
