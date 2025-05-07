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
        $data = $request->only([
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

        // سجل البيانات في اللوج للتتبع
        Log::info('Event update data:', $data);

        $event->update($data);
        $event->refresh();

        return response()->json($event);
    }

    // حذف فعالية
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully.'], 204);
    }
} 