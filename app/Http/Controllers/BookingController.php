<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->role === 'attendee') {
            $bookings = Booking::with(['ticket.event', 'user'])
                ->where('user_id', $user->id)
                ->paginate(10);
        } elseif ($user->isOrganizer() && $user->is_approved) {
            $bookings = Booking::with(['ticket.event', 'user'])
                ->whereHas('ticket.event', function($q) use ($user) {
                    $q->where('organizer_id', $user->organizer->id);
                })
                ->paginate(10);
        } elseif ($user->isAdmin()) {
            $bookings = Booking::with(['ticket.event', 'user'])->paginate(10);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        // منع الحجز لغير المشاركين
        if ($request->user()->role !== 'attendee') {
            return response()->json([
                'message' => 'Only attendees can make bookings.'
            ], 403);
        }

        $request->validate([
            'ticket_id' => ['required', 'exists:tickets,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'attendee_names' => ['required', 'array', 'min:1'],
            'attendee_names.*' => ['required', 'string', 'max:255'],
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        if ($request->quantity > $ticket->remaining_quantity) {
            return response()->json([
                'message' => 'Not enough tickets available',
            ], 422);
        }

        if (count($request->attendee_names) !== $request->quantity) {
            return response()->json([
                'message' => 'Number of attendee names must match quantity',
            ], 422);
        }

        $totalPrice = $ticket->price * $request->quantity;

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'ticket_id' => $request->ticket_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'attendee_names' => $request->attendee_names,
            'status' => 'pending',
            'qr_code' => null,
        ]);

        // Generate QR code
        $qrData = [
            'booking_id' => $booking->id,
            'event' => $ticket->event->title,
            'attendees' => $request->attendee_names,
        ];

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_L,
            'scale' => 5,
        ]);

        $qrImage = (new QRCode($options))->render(json_encode($qrData));
        // إذا كان الناتج base64، فك الترميز
        if (str_starts_with($qrImage, 'data:image/svg+xml;base64,')) {
            $qrImage = base64_decode(substr($qrImage, strlen('data:image/svg+xml;base64,')));
        }
        $qrPath = 'booking-qr-codes/' . $booking->id . '.svg';
        Storage::disk('public')->put($qrPath, $qrImage);
        $booking->update(['qr_code' => $qrPath]);

        // Update remaining tickets
        $ticket->decrement('remaining_quantity', $request->quantity);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking->load(['ticket.event', 'user']),
        ], 201);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return response()->json($booking->load(['ticket.event', 'user']));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);

        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending bookings can be cancelled',
            ], 422);
        }

        $booking->update(['status' => 'cancelled']);
        $booking->ticket->increment('remaining_quantity', $booking->quantity);

        return response()->json([
            'message' => 'Booking cancelled successfully',
            'booking' => $booking,
        ]);
    }

    public function qrCode(Booking $booking)
    {
        $this->authorize('view', $booking);

        if (!$booking->qr_code) {
            return response()->json(['message' => 'QR code not found'], 404);
        }

        $path = storage_path('app/public/' . $booking->qr_code);

        if (!file_exists($path)) {
            return response()->json(['message' => 'QR code file not found'], 404);
        }

        if (str_ends_with($booking->qr_code, '.svg')) {
            return response(file_get_contents($path), 200)
                ->header('Content-Type', 'image/svg+xml');
        }

        return response(file_get_contents($path), 200)
            ->header('Content-Type', 'image/png');
    }
} 