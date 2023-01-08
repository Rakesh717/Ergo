<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdateTaskDueDateController extends Controller
{
    public function __invoke(Task $task, Authenticatable $user)
    {
        abort_if($task->board->team_id !== $user->currentTeam->id, 403);

        $task->update(['due_at' => request('date') ? Carbon::parse(request('date')) : null]);

        return back();
    }
}
