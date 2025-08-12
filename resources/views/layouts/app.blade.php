<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{ route('tasks.index') }}">Task Manager</a>
    <div>
        @auth
        <span class="me-3">Hello, {{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
        @endauth
    </div>
  </div>
</nav>

@yield('content')

@yield('scripts')
</body>
</html>
