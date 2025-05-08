<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    // عرض جميع الفعاليات
    public function index()
    {
        return response()->json(Event::all());
    }

    // إنشاء فعالية جديدة
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'category' => 'required|string',
        ]);

        $organizerId = auth()->user()->organizer->id ?? null;
        if (!$organizerId) {
            return response()->json(['error' => 'Organizer not found for this user.'], 403);
        }

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'category' => $request->category,
            'organizer_id' => $organizerId,
        ]);

        return response()->json($event, 201);
    }

    // عرض تفاصيل فعالية
    public function show(Event $event)
    {
        return response()->json($event);
    }

    // تحديث فعالية
    public function update(Request $request, Event $event)
    {
        // Check if the user is authorized to update this event
        if (auth()->user()->organizer && auth()->user()->organizer->id != $event->organizer_id) {
            return response()->json(['error' => 'You are not authorized to update this event'], 403);
        }

        // Get all input data from the request
        $data = $request->all();
        
        // Log the request data for debugging
        Log::info('Event update request:', [
            'event_id' => $event->id,
            'request_data' => $data,
            'content_type' => $request->header('Content-Type'),
            'method' => $request->method()
        ]);

        // Filter only the allowed fields
        $filteredData = array_filter($data, function($key) {
            return in_array($key, [
                'title',
                'description',
                'location',
                'latitude',
                'longitude',
                'start_date',
                'end_date',
                'category',
                'image_path',
                'video_path',
                'is_published'
            ]);
        }, ARRAY_FILTER_USE_KEY);

        // Update the event with the filtered data
        $event->update($filteredData);
        $event->refresh();

        // Log the updated event for debugging
        Log::info('Event updated successfully:', ['event' => $event->toArray()]);

        return response()->json($event);
    }

    // حذف فعالية
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully.'], 204);
    }
} 