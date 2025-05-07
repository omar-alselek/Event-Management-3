<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminWebController extends Controller
{
    public function pendingOrganizers()
    {
        $organizers = Organizer::with('user')->whereHas('user', function($q) {
            $q->where('is_approved', false);
        })->get();
        return view('admin.organizers.pending', compact('organizers'));
    }

    public function approveOrganizer(Request $request, Organizer $organizer)
    {
        $organizer->user->is_approved = true;
        $organizer->user->save();
        return redirect()->route('admin.organizers.pending')->with('success', 'تمت الموافقة على المنظم بنجاح');
    }

    public function reports()
    {
        $reports = Report::with('user', 'event')->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    public function showReport(Report $report)
    {
        return view('admin.reports.show', compact('report'));
    }

    public function updateReport(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved,rejected',
            'admin_notes' => 'nullable|string',
        ]);
        $report->status = $request->status;
        $report->admin_notes = $request->admin_notes;
        $report->save();
        return redirect()->route('admin.reports')->with('success', 'تم تحديث حالة البلاغ بنجاح');
    }

    public function dashboard()
    {
        $users = \App\Models\User::all();
        $organizers = \App\Models\Organizer::with('user')->get();
        $attendees = $users->where('role', 'attendee');
        $admins = $users->where('role', 'admin');
        return view('admin.dashboard', compact('users', 'organizers', 'attendees', 'admins'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'])) {
            return redirect()->route('admin.login')->with('error', 'Invalid credentials or not an admin.');
        }
        return redirect()->route('admin.dashboard');
    }
} 