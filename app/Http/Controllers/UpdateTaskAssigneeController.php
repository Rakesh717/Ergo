<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdateTaskAssigneeController extends Controller
{
    public function __invoke(Task $task, Authenticatable $user)
    {
        abort_if($task->board->team_id !== $user->currentTeam->id, 403);

        $assignee = User::where("id", request('assignee_id'))->first();

        if (!$assignee || !$assignee->belongsToTeam($user->currentTeam)) {
            abort(403);
        }

        $task->update(['assignee_id' => request('assignee_id')]);

        // TODO: Send notification to assignee

        return back();
    }
}
