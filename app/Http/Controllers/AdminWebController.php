<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminWebController extends Controller
{
    public function __construct()
    {
        // Apply auth middleware to all methods except login and showLoginPage
        $this->middleware('auth', ['except' => ['login', 'showLoginPage']]);
        
        // Check if user is admin for protected routes
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->isAdmin()) {
                // If trying to access a protected route and not authenticated as admin
                if ($request->route()->getName() !== 'admin.login.submit') {
                    abort(403);
                }
            }
            return $next($request);
        }, ['except' => ['login', 'showLoginPage']]);
    }

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
        $latestReports = \App\Models\Report::with(['user', 'event'])->latest()->take(5)->get();
        $latestEvents = \App\Models\Event::with('organizer.user')->latest()->take(5)->get();
        return view('admin.dashboard', compact('users', 'organizers', 'attendees', 'admins', 'latestReports', 'latestEvents'));
    }

    /**
     * Show the login page at the root URL
     */
    public function showLoginPage()
    {
        // If already logged in as admin, redirect to dashboard
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        // Show the login form
        return view('auth.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // First check if the user exists
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found with this email.');
        }
        
        // Then attempt authentication without role restriction
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home')->with('error', 'Invalid password.');
        }
        
        // Check if authenticated user is an admin
        if (!auth()->user()->isAdmin()) {
            auth()->logout();
            return redirect()->route('home')->with('error', 'You are not authorized as an admin.');
        }
        
        // Successful login, redirect to dashboard
        return redirect()->route('admin.dashboard');
    }

    // USERS
    public function usersIndex(Request $request)
    {
        $users = \App\Models\User::query();
        if ($request->search) {
            $users->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
        }
        $users = $users->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function usersShow($id) {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function usersEdit($id) {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, $id) {
        $user = \App\Models\User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'role', 'phone', 'organization']));
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function usersBan($id) {
        $user = \App\Models\User::findOrFail($id);
        $user->banned = true;
        $user->save();
        return back()->with('success', 'User banned successfully');
    }

    public function usersUnban($id) {
        $user = \App\Models\User::findOrFail($id);
        $user->banned = false;
        $user->save();
        return back()->with('success', 'User unbanned successfully');
    }

    public function usersChangeRole($id) {
        $user = \App\Models\User::findOrFail($id);
        $roles = ['admin', 'organizer', 'attendee'];
        return view('admin.users.change_role', compact('user', 'roles'));
    }

    public function usersDestroy($id) {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }

    // EVENTS
    public function eventsIndex(Request $request)
    {
        $events = \App\Models\Event::with('organizer.user');
        if ($request->search) {
            $events->where('title', 'like', '%'.$request->search.'%');
        }
        $events = $events->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function eventsShow($id) {
        $event = \App\Models\Event::with('organizer.user')->findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    public function eventsEdit($id) {
        $event = \App\Models\Event::with('organizer.user')->findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function eventsUpdate(Request $request, $id) {
        $event = \App\Models\Event::findOrFail($id);
        $event->update($request->only(['title', 'description', 'location', 'start_date', 'end_date', 'category']));
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully');
    }

    public function eventsDestroy($id) {
        $event = \App\Models\Event::findOrFail($id);
        $event->delete();
        return back()->with('success', 'Event deleted successfully');
    }

    public function eventsPublish($id) {
        $event = \App\Models\Event::findOrFail($id);
        $event->is_published = true;
        $event->save();
        return back()->with('success', 'Event published successfully');
    }

    public function eventsUnpublish($id) {
        $event = \App\Models\Event::findOrFail($id);
        $event->is_published = false;
        $event->save();
        return back()->with('success', 'Event unpublished successfully');
    }

    // BOOKINGS
    public function bookingsIndex(Request $request)
    {
        $bookings = \App\Models\Booking::with(['user', 'ticket.event']);
        if ($request->search) {
            $bookings->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            });
        }
        $bookings = $bookings->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function bookingsShow($id) {
        $booking = \App\Models\Booking::with(['user', 'ticket.event'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function bookingsEdit($id) {
        $booking = \App\Models\Booking::with(['user', 'ticket.event'])->findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    public function bookingsUpdate(Request $request, $id) {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->update($request->only(['status']));
        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully');
    }

    public function bookingsCancel($id) {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();
        return back()->with('success', 'Booking cancelled successfully');
    }

    public function bookingsComplete($id) {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->status = 'completed';
        $booking->save();
        return back()->with('success', 'Booking marked as completed');
    }

    // TICKETS
    public function ticketsIndex(Request $request)
    {
        $tickets = \App\Models\Ticket::with('event');
        if ($request->search) {
            $tickets->where('type', 'like', '%'.$request->search.'%');
        }
        $tickets = $tickets->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function ticketsShow($id) {
        $ticket = \App\Models\Ticket::with('event')->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function ticketsEdit($id) {
        $ticket = \App\Models\Ticket::with('event')->findOrFail($id);
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function ticketsUpdate(Request $request, $id) {
        $ticket = \App\Models\Ticket::findOrFail($id);
        $ticket->update($request->only(['type', 'price', 'quantity', 'description']));
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket updated successfully');
    }

    public function ticketsDestroy($id) {
        $ticket = \App\Models\Ticket::findOrFail($id);
        $ticket->delete();
        return back()->with('success', 'Ticket deleted successfully');
    }

    public function ticketsActivate($id) {
        $ticket = \App\Models\Ticket::findOrFail($id);
        $ticket->is_active = true;
        $ticket->save();
        return back()->with('success', 'Ticket activated successfully');
    }

    public function ticketsDeactivate($id) {
        $ticket = \App\Models\Ticket::findOrFail($id);
        $ticket->is_active = false;
        $ticket->save();
        return back()->with('success', 'Ticket deactivated successfully');
    }
} 