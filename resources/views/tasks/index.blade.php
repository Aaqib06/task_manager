@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tasks</h2>

    <div class="mb-3">
        <form method="GET" action="{{ route('tasks.index') }}" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title" class="form-control">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in-progress" {{ request('status')=='in-progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                @can('create', App\Models\Task::class)
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Create Task</a>
                @endcan
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>SubCategory</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Created By</th>
                @can('update', App\Models\Task::class)
                <th>Actions</th>
                @endcan
            </tr>
        </thead>
      <tbody>
    @forelse($tasks as $task)
    <tr id="task-{{ $task->id }}">
        <td>{{ $task->title }}</td>
        <td>{{ optional($task->category)->name ?? 'N/A' }}</td>
        <td>{{ optional($task->subCategory)->name ?? 'N/A' }}</td>
        <td>{{ ucfirst($task->status) }}</td>
        <td>{{ $task->due_date->format('Y-m-d') }}</td>
        <td>{{ optional($task->user)->name ?? 'N/A' }}</td>
        @can('update', $task)
        <td>
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
            <button class="btn btn-sm btn-danger btn-delete-task" data-id="{{ $task->id }}">Delete</button>
        </td>
        @endcan
    </tr>
    @empty
    <tr><td colspan="7" class="text-center">No tasks found.</td></tr>
    @endforelse
</tbody>

    </table>

    {{ $tasks->withQueryString()->links() }}
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $('.btn-delete-task').click(function(){
        if(!confirm('Are you sure you want to delete this task?')) return;

        let id = $(this).data('id');
        $.ajax({
            url: '/tasks/' + id,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: function(res) {
                if(res.success) {
                    $('#task-' + id).remove();
                }
            }
        });
    });
});
</script>
@endsection
