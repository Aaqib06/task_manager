<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="{{ asset('css/admin-panel.css') }}" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar">
  <div class="d-flex align-items-center">
    <span class="toggle-btn" id="toggleSidebar"><i class="bi bi-list"></i></span>
    <a href="{{ route('dashboard') }}" class="brand">Task Manager</a>
  </div>

  <div class="nav-right">
    <i class="bi bi-bell nav-icon">
      <span class="badge">3</span>
    </i>
    <div class="dropdown">
      <a href="#" class="nav-icon dropdown-toggle" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li><span class="dropdown-item-text">Hello, {{ auth()->user()->name }}</span></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="sidebar" id="sidebar">
  <ul>
    <li class="active">
      <a href="{{ route('dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="{{ route('tasks.index') }}">
        <i class="bi bi-list-task"></i>
        <span>Tasks</span>
      </a>
    </li>
    <li>
      <a href="{{ route('categories.index') ?? '#' }}">
        <i class="bi bi-tags"></i>
        <span>Categories</span>
      </a>
    </li>
    {{-- Add more links here --}}
  </ul>
</div>

<div class="content" id="content">
  <div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
      <div class="col-md-4">
        <div class="card-summary">
          <i class="bi bi-list-task"></i>
          <div class="info">
            <h3>{{ $tasksCount ?? 0 }}</h3>
            <p>Total Tasks</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card-summary">
          <i class="bi bi-check-circle"></i>
          <div class="info">
            <h3>{{ $completedTasksCount ?? 0 }}</h3>
            <p>Completed Tasks</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card-summary">
          <i class="bi bi-clock-history"></i>
          <div class="info">
            <h3>{{ $pendingTasksCount ?? 0 }}</h3>
            <p>Pending Tasks</p>
          </div>
        </div>
      </div>
    </div>

    {{-- More dashboard content/widgets here --}}
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const toggleBtn = document.getElementById('toggleSidebar');
  const sidebar = document.getElementById('sidebar');
  const content = document.getElementById('content');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    content.classList.toggle('collapsed');
  });
</script>

</body>
</html>
