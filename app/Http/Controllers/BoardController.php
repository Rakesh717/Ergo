<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Contracts\Auth\Authenticatable;
use Inertia\Inertia;

class BoardController extends Controller
{
    public function show(Board $board, Authenticatable $user)
    {
        abort_if($board->team_id !== $user->currentTeam->id, 403);

        $board->load(['sections.tasks.assignee']);

        return Inertia::render('Boards/Show', [
            'board' => $board,
            'members' => $user->currentTeam->allUsers(),
        ]);
    }
}
