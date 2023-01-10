<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     */
    public function delete(Team $team): void
    {
        $team->owner()->where('current_team_id', $team->id)
            ->update(['current_team_id' => null]);

        $team->users()->where('current_team_id', $team->id)
            ->update(['current_team_id' => null]);

        $team->delete();
    }
}
