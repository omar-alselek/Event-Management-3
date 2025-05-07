<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $tickets = Ticket::with('event')
            ->whereHas('event', function ($query) use ($request) {
                $query->where('organizer_id', $request->user()->organizer->id);
            })
            ->paginate(10);

        return response()->json($tickets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'type' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        $event = Event::findOrFail($request->event_id);
        $this->authorize('create', [Ticket::class, $event]);

        $ticket = Ticket::create([
            'event_id' => $request->event_id,
            'type' => $request->type,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'remaining_quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Ticket created successfully',
            'ticket' => $ticket,
        ], 201);
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        return response()->json($ticket->load('event'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $request->validate([
            'type' => ['sometimes', 'required', 'string', 'max:255'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'quantity' => ['sometimes', 'required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        if ($request->has('quantity')) {
            $soldTickets = $ticket->quantity - $ticket->remaining_quantity;
            if ($request->quantity < $soldTickets) {
                return response()->json([
                    'message' => 'Cannot reduce quantity below number of sold tickets',
                ], 422);
            }
            $ticket->remaining_quantity = $request->quantity - $soldTickets;
        }

        $ticket->update($request->except('quantity'));

        return response()->json([
            'message' => 'Ticket updated successfully',
            'ticket' => $ticket,
        ]);
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        if ($ticket->bookings()->exists()) {
            return response()->json([
                'message' => 'Cannot delete ticket with existing bookings',
            ], 422);
        }

        $ticket->delete();

        return response()->json([
            'message' => 'Ticket deleted successfully',
        ]);
    }
} 