<?php

namespace App\Http\Controllers;

use App\Models\Section;
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


        $task = $section->tasks()->create([
            'title' => $request->get('title'),
            'team_id' => $user->currentTeam->id,
            'completed_at' => $section->isCompleteSection() ? now() : null,
        ]);

        return back();
    }
}
