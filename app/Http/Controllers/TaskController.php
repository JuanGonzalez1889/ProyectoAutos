<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Filtrar por agencia si no es ADMIN
        $query = Task::with('user');
        
        if ($user && !$user->isAdmin()) {
            $query->where('agencia_id', $user->agencia_id);
        }
        
        $tasks = [
            'todo' => $query->clone()->todo()->orderBy('priority', 'desc')->orderBy('due_date')->get(),
            'in_progress' => $query->clone()->inProgress()->orderBy('priority', 'desc')->orderBy('due_date')->get(),
            'done' => $query->clone()->done()->orderBy('updated_at', 'desc')->get(),
        ];
        
        $stats = [
            'total' => $query->count(),
            'todo' => $query->clone()->todo()->count(),
            'in_progress' => $query->clone()->inProgress()->count(),
            'done' => $query->clone()->done()->count(),
            'high_priority' => $query->clone()->highPriority()->whereIn('status', ['todo', 'in_progress'])->count(),
        ];
        
        return view('tasks.index', compact('tasks', 'stats'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'related_to' => 'nullable|string',
            'related_id' => 'nullable|integer',
        ]);
        
        $validated['user_id'] = $user->id;
        $validated['agencia_id'] = $user->agencia_id;
        $validated['status'] = 'todo';
        
        Task::create($validated);
        
        return redirect()->route('admin.tasks.index')->with('success', 'Tarea creada exitosamente');
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);
        
        $task->update($validated);
        
        return redirect()->route('admin.tasks.index')->with('success', 'Tarea actualizada exitosamente');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);
        
        $task->update($validated);
        
        return response()->json(['success' => true]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        
        return redirect()->route('admin.tasks.index')->with('success', 'Tarea eliminada exitosamente');
    }
}
