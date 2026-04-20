<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Pen;
use App\Models\Pig;
use App\Models\PigActivity;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Admin view to see all tasks and assignment form.
     */
    public function adminIndex()
    {
        $tasks = Task::with(['assignee', 'pen', 'pig'])->orderBy('due_date')->get();
        $workers = User::where('role', 'farm_worker')->get();
        $pens = Pen::all();
        $pigs = Pig::all();

        return view('admin.tasks.index', compact('tasks', 'workers', 'pens', 'pigs'));
    }

    /**
     * Admin method to store a new task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'pen_id' => 'nullable|exists:pens,id',
            'pig_id' => 'nullable|exists:pigs,id',
        ]);

        Task::create($validated);

        return back()->with('success', 'Task assigned successfully.');
    }

    /**
     * Worker view to see their own tasks.
     */
    public function workerIndex()
    {
        $tasks = Task::where('assigned_to', Auth::id())
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->get();

        $completedTasks = Task::where('assigned_to', Auth::id())
            ->where('status', 'completed')
            ->orderByDesc('completed_at')
            ->limit(5)
            ->get();

        return view('worker.task', compact('tasks', 'completedTasks'));
    }

    /**
     * Worker method to mark task as completed and sync to pig records.
     */
    public function updateStatus(Request $request, Task $task)
    {
        if ($task->assigned_to !== Auth::id()) {
            abort(403);
        }

        $task->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // AUTOMATION: Log this as an activity for the relevant pigs
        $type = 'Care';
        $medicalKeywords = ['vaccine', 'medical', 'medicine', 'sick', 'deworm', 'treatment', 'clinic', 'checkup', 'vet'];
        foreach ($medicalKeywords as $word) {
            if (stripos($task->title, $word) !== false || stripos(($task->description ?? ''), $word) !== false) {
                $type = 'Medical';
                break;
            }
        }

        $pigsToLog = collect();

        // If specific pig, log for that pig
        if ($task->pig_id) {
            $pigsToLog->push(Pig::find($task->pig_id));
        } 
        // If whole pen, log for all pigs in pen
        elseif ($task->pen_id) {
            $penPigs = Pig::where('pen_id', $task->pen_id)->where('status', '!=', 'Sold')->where('status', '!=', 'Disposed')->get();
            $pigsToLog = $pigsToLog->concat($penPigs);
        }

        foreach ($pigsToLog as $pig) {
            if ($pig) {
                PigActivity::create([
                    'pig_id' => $pig->id,
                    'user_id' => Auth::id(),
                    'type' => $type,
                    'action' => 'Task Completed: ' . $task->title,
                    'details' => $task->description ?: 'Assigned task completed as part of regular duties.',
                ]);
            }
        }

        return back()->with('success', 'Task completed and animal records updated!');
    }

    public function destroy(Task $task)
    {
        if (!Auth::user()->role === 'admin') {
            abort(403);
        }
        $task->delete();
        return back()->with('success', 'Task deleted.');
    }
}
