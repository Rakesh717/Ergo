<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Task;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateSectionTasksController extends Controller
{
    public function __invoke(Section $section, Authenticatable $user, Request $request)
    {
        abort_if($section->board->team_id !== $user->currentTeam->id, 403);

        $request->validate(['tasks' => ['required', 'array']]);

        DB::transaction(function () use ($request, $section) {
            $tasks = Task::query()
                ->whereRelation('board', 'boards.id', $section->board_id)
                ->find($request->tasks);

            $completeTasks = $section->isCompleteSection();

            $order = 1;

            foreach ($request->get('tasks', []) as $id) {
                $task = $tasks->firstWhere('id', $id);

                if (!$task) continue;

                $task->update([
                    'sort_number' => $order++,
                    'section_id' => $section->id,
                    'completed_at' => $task->completed_at ?? ($completeTasks ? now() : null)
                ]);
            }
        });

        return back();
    }
}
