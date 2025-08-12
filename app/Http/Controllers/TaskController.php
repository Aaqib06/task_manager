<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List tasks with search & filter & pagination
    public function index(Request $request)
    {
        $query = Task::with(['category', 'subCategory', 'user']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('due_date')->paginate(5);

        return view('tasks.index', compact('tasks'));
    }

    // Show create form
    public function create()
    {
        $this->authorize('create', Task::class);

        $categories = Category::all();

        return view('tasks.create', compact('categories'));
    }

    // Store new task (AJAX)
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'status'         => 'required|in:pending,in-progress,completed',
            'due_date'       => 'required|date|after_or_equal:today',
        ]);

        $validated['user_id'] = Auth::id();

        $task = Task::create($validated);

        return response()->json(['success' => true, 'task' => $task]);
    }

    // Show task details
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return view('tasks.show', compact('task'));
    }

    // Edit task form
    public function edit(Task $task)
    {
        $this->authorize('update', $task);  // Always pass $task here

        $categories = Category::all();

        return view('tasks.edit', compact('task', 'categories'));
    }

    // Update task (AJAX)
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);  // Always pass $task here

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'status'         => 'required|in:pending,in-progress,completed',
            'due_date'       => 'required|date|after_or_equal:today',
        ]);

        $task->update($validated);

        return response()->json(['success' => true, 'task' => $task]);
    }

    // Delete task (AJAX)
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);  // Always pass $task here

        $task->delete();

        return response()->json(['success' => true]);
    }
}
