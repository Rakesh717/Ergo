<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Task;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Section $section, Authenticatable $user, Request $request)
    {
        abort_if($section->board->team_id !== $user->currentTeam->id, 403);

        $request->validate([
            'title' => ['required', 'string', 'max:255']
        ]);

        $section->tasks()->create([
            'title' => $request->get('title'),
            'team_id' => $user->currentTeam->id,
            'completed_at' => $section->isCompleteSection() ? now() : null,
            'sort_number' => Task::where('section_id', $section->id)->max('sort_number') ?? 1,
        ]);

        return back();
    }
}
