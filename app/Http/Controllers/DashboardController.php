<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;

class DashboardController extends Controller
{
    public function __invoke(Authenticatable $user)
    {
        $tasks = Task::query()
            ->whereRelation('team', 'teams.id', $user->currentTeam->id)
            ->whereRelation('assignee', 'users.id', $user->id)
            ->where('completed_at', null)
            ->with(['section.board'])
            ->orderBy(DB::raw('-due_at'), 'DESC')
            ->get()
            ->map(function ($task) {
                if ($task->due_at) {
                    if (now() > $task->due_at) {
                        $task->color = "red";
                    } else if (now()->addDay() > $task->due_at) {
                        $task->color = "yellow";
                    } else {
                        $task->color = null;
                    }
                }

                $task->color ??= $task->color;

                return $task;
            });

        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
        ]);
    }
}
