<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\Auth\Authenticatable;

class MarkTaskCompleteController extends Controller
{
    public function __invoke(Task $task, Authenticatable $user)
    {
        abort_if($task->team_id !== $user->currentTeam->id, 403);

        $task->update(['completed_at' => now()]);

        return back();
    }

    public function destroy(Task $task, Authenticatable $user)
    {
        abort_if($task->team_id !== $user->currentTeam->id, 403);

        $task->update(['completed_at' => null]);

        return back();
    }
}
