<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: #fff; width: 220px; position: fixed; right: 0; top: 0; z-index: 100; }
        .sidebar a, .sidebar form button { color: #fff; text-decoration: none; display: flex; align-items: center; padding: 1rem; border: none; background: none; width: 100%; text-align: right; }
        .sidebar a.active, .sidebar a:hover, .sidebar form button:hover { background: #495057; }
        .sidebar .sidebar-header { font-size: 1.5rem; font-weight: bold; padding: 1.5rem 1rem; text-align: center; }
        .sidebar .logout-btn { position: absolute; bottom: 0; width: 100%; }
        .content { margin-right: 220px; }
        @media (max-width: 768px) {
            .sidebar { min-width: 100vw; position: static; }
            .content { margin-right: 0; }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <nav class="sidebar flex-shrink-0 p-0">
            <div class="sidebar-header mb-4">Admin Panel</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home me-2"></i>Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users me-2"></i>Users</a>
            <a href="{{ route('admin.organizers.pending') }}" class="{{ request()->routeIs('admin.organizers.*') ? 'active' : '' }}"><i class="fas fa-user-tie me-2"></i>Organizers</a>
            <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}"><i class="fas fa-calendar-alt me-2"></i>Events</a>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"><i class="fas fa-ticket-alt me-2"></i>Bookings</a>
            <a href="{{ route('admin.tickets.index') }}" class="{{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}"><i class="fas fa-tags me-2"></i>Tickets</a>
            <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports*') ? 'active' : '' }}"><i class="fas fa-flag me-2"></i>Reports</a>
            <form action="{{ route('admin.logout') }}" method="POST" class="logout-btn">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
            </form>
        </nav>
        <div class="content flex-grow-1">
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 