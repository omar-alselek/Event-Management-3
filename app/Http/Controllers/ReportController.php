<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Event;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = Report::with(['user', 'event'])
            ->when($request->user()->isAdmin(), function ($query) {
                return $query;
            })
            ->when($request->user()->isAttendee(), function ($query) use ($request) {
                return $query->where('user_id', $request->user()->id);
            })
            ->paginate(10);

        return response()->json($reports);
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'reason' => ['required', 'string'],
        ]);

        $report = Report::create([
            'user_id' => $request->user()->id,
            'event_id' => $event->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Report submitted successfully',
            'report' => $report,
        ], 201);
    }

    public function update(Request $request, Report $report)
    {
        $this->authorize('update', $report);

        $request->validate([
            'status' => ['required', 'in:reviewed,resolved'],
            'admin_notes' => ['required', 'string'],
        ]);

        $report->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return response()->json([
            'message' => 'Report updated successfully',
            'report' => $report,
        ]);
    }
} 